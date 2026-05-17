# ─────────────────────────────────────────────────────────────
#  SOL-Access — Prototipo UCV  |  PHP 8.3 + Apache + SQLite
# ─────────────────────────────────────────────────────────────
FROM php:8.3-apache

# Extensiones del sistema
RUN apt-get update && apt-get install -y --no-install-recommends \
        git curl zip unzip \
        libzip-dev libpng-dev libonig-dev libxml2-dev libsqlite3-dev \
    && docker-php-ext-install \
        pdo pdo_sqlite mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# mod_rewrite y mod_headers para Laravel + security headers
RUN a2enmod rewrite headers

# Ocultar versión de PHP y Apache
RUN echo "expose_php = Off" > /usr/local/etc/php/conf.d/security.ini \
    && echo "ServerTokens Prod" >> /etc/apache2/conf-available/security.conf \
    && echo "ServerSignature Off" >> /etc/apache2/conf-available/security.conf

# DocumentRoot apunta a /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/*.conf \
        /etc/apache2/apache2.conf \
        /etc/apache2/conf-available/*.conf

# Composer 2
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ── Dependencias PHP (capa cacheada si composer.* no cambia) ──
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --optimize-autoloader \
        --no-scripts \
        --no-interaction

# ── Código fuente ──
COPY . .

# Permisos de escritura para Laravel
RUN chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

COPY docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
