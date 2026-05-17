#!/bin/bash
set -e

cd /var/www/html

# ── 1. Generar .env desde .env.example si no existe ──────────
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Inyectar variables de entorno de Easypanel → .env
# (si la variable de entorno está definida, sobreescribe la línea en .env)

inject_env() {
    local KEY="$1"
    local VALUE="$2"
    if [ -n "$VALUE" ]; then
        # Si la clave ya existe en .env, reemplazar; si no, agregar
        if grep -q "^${KEY}=" .env; then
            sed -i "s|^${KEY}=.*|${KEY}=${VALUE}|" .env
        else
            echo "${KEY}=${VALUE}" >> .env
        fi
    fi
}

inject_env "APP_NAME"             "${APP_NAME:-SOL-Access}"
inject_env "APP_ENV"              "${APP_ENV:-production}"
inject_env "APP_DEBUG"            "${APP_DEBUG:-false}"
inject_env "APP_URL"              "${APP_URL:-http://localhost}"
inject_env "APP_KEY"              "${APP_KEY}"
inject_env "SESSION_SECURE_COOKIE" "true"
inject_env "SESSION_HTTP_ONLY"    "true"
inject_env "SESSION_SAME_SITE"    "lax"

# ── 2. Generar APP_KEY si sigue vacío ─────────────────────────
if grep -q "^APP_KEY=$" .env 2>/dev/null || ! grep -q "^APP_KEY=" .env 2>/dev/null; then
    php artisan key:generate --force
fi

# ── 3. SQLite: crear archivo si no existe ─────────────────────
mkdir -p database
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    echo "[entrypoint] Base de datos SQLite creada."
fi

chown -R www-data:www-data database storage bootstrap/cache
chmod -R 775 database storage bootstrap/cache

# ── 4. Migraciones ───────────────────────────────────────────
php artisan migrate --force

# ── 5. Sembrar datos solo si la tabla roles está vacía ────────
ROLE_COUNT=$(php -r "
    \$pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    \$count = \$pdo->query('SELECT COUNT(*) FROM roles')->fetchColumn();
    echo \$count;
" 2>/dev/null || echo "0")

if [ "$ROLE_COUNT" = "0" ]; then
    echo "[entrypoint] Sembrando datos iniciales..."
    php artisan db:seed --force
fi

# ── 6. Caché de producción ────────────────────────────────────
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[entrypoint] SOL-Access listo. Iniciando Apache..."
exec apache2-foreground
