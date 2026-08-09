<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();

            $table->foreignId('Trees_id')
                  ->constrained('trees')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('Pot_Sizes_id')
                  ->constrained('pot_sizes')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->integer('Quantity')->nullable();

            $table->foreignId('Location_id')
                  ->constrained('location')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('inventory');
    }
};
