<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \ERP\Enums\PersonType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('person', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->smallInteger('person_type')->default(PersonType::INDIVIDUAL->value);
            $table->string('name');
            $table->string('cpf', 11)->nullable()->unique();
            $table->string('cnpj', 14)->nullable()->unique();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person');
    }
};
