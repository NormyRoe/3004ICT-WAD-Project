<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exception_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('Price', 10, 2)->nullable();

            $table->foreignId('Trees_id')
                  ->constrained('trees')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('Pot_Sizes_id')
                  ->constrained('pot_sizes')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('exception_prices');
    }
};
