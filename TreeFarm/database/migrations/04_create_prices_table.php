<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();

            $table->foreignId('Pot_Sizes_id')
                  ->nullable()
                  ->constrained('pot_sizes')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->decimal('Price', 10, 2)->nullable();
            $table->decimal('Rate', 10, 2)->nullable();

            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('prices');
    }
};
