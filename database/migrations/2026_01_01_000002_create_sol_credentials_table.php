<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sol_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->unique()->constrained('companies')->cascadeOnDelete();
            $table->string('usuario_sol', 8);
            $table->text('clave_sol'); // AES-256 via Laravel Crypt::encryptString()
            $table->timestamp('last_verified_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sol_credentials');
    }
};
