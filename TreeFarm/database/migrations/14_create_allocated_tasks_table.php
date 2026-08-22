<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('allocated_tasks', function (Blueprint $table) {
            $table->id();

            // Core fields
            $table->dateTime('Date')->nullable();
            $table->string('Notes', 200)->nullable();
            $table->tinyInteger('Done')->nullable();      // 0 or 1
            $table->tinyInteger('Allocated');             // must be 0 or 1

            // Foreign keys
            $table->foreignId('Tasks_id')
                  ->constrained('tasks')
                  ->restrictOnDelete()
                  ->restrictOnUpdate();

            $table->foreignId('Users_id')
                  ->constrained('users')
                  ->restrictOnDelete()
                  ->restrictOnUpdate();

            $table->foreignId('Trees_id')
                  ->nullable()
                  ->constrained('trees')
                  ->restrictOnDelete()
                  ->restrictOnUpdate();

            $table->foreignId('Pot_Sizes_id')
                  ->nullable()
                  ->constrained('pot_sizes')
                  ->restrictOnDelete()
                  ->restrictOnUpdate();

            // Quantity
            $table->integer('Quantity')->nullable();

            // Custom timestamps
            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('allocated_tasks');
    }
};
