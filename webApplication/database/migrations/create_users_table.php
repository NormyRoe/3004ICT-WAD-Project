<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('First_Name', 50)->nullable();
            $table->string('Last_Name', 50)->nullable();
            $table->string('Email', 100)->nullable()->unique();
            $table->string('Job_Title', 100)->nullable();

            $table->foreignId('Roles_id')
                  ->constrained('roles')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('Manager')
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->string('Status', 45)->nullable();
            $table->string('Password', 150)->nullable();

            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
