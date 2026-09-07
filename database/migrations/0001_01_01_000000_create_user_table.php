<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->timestamp('verify_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('uuid');
            $table->index('email');
        });

        // Apenas após o primeiro acesso com sucesso que o usuário terá acesso ao sistema, o login DEVE barrar um usuário sem acesso
        // Adicionar attemps via middleware, proteger e impedir enviar múltiplas requisições, 1 a cada 10 minutos
        // Job depois de 24 horas, deleta os otps
        //  Testar

        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('user')
                ->cascadeOnDelete();
            $table->string('code');
            $table->smallInteger('type'); // 1 = FIRST ACCESS, 2 = PASSWORD RESET
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->unsignedTinyInteger('attempts')->default(0); // max = 3
            $table->timestamps();
            $table->index(['user_id', 'type']);
            $table->index('expires_at');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
