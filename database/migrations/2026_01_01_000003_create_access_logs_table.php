<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('ruc', 11);
            $table->string('razon_social');
            $table->integer('duration_ms')->nullable();
            $table->decimal('duration_seconds', 8, 3)->nullable();
            $table->string('status', 20)->default('PENDING'); // PENDING, SUCCESS, FAILED
            $table->integer('steps_completed')->default(0);
            $table->text('error_message')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('accessed_at');
            $table->timestamps();

            $table->index(['company_id', 'accessed_at']);
            $table->index(['user_id', 'accessed_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_logs');
    }
};
