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
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('Pot_Sizes_id')
                  ->constrained('pot_sizes')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('Location_id')
                  ->nullable()
                  ->constrained('location')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('Area_id')
                  ->nullable()
                  ->constrained('area')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('Aisle_id')
                  ->nullable()
                  ->constrained('aisle')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->integer('Quantity')->nullable();

            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('inventory');
    }
};
