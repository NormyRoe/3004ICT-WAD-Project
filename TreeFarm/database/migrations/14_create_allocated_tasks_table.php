<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('allocated_tasks', function (Blueprint $table) {
            $table->id();

            $table->dateTime('Date')->nullable();
            $table->string('Notes', 200)->nullable();
            $table->tinyInteger('Done')->nullable();

            $table->foreignId('Tasks_id')
                  ->constrained('tasks')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('Users_id')
                  ->constrained('users')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('Trees_id')
                  ->nullable()
                  ->constrained('trees')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->integer('Quantity')->nullable();

            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('allocated_tasks');
    }
};
