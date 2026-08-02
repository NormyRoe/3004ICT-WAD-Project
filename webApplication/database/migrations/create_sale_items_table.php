<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();

            $table->integer('Quantity')->nullable();
            $table->decimal('Unit_Price', 10, 2)->nullable();
            $table->decimal('Discount', 10, 2)->nullable();
            $table->decimal('Total_Price', 10, 2)->nullable();

            $table->foreignId('Inventory_id')
                  ->constrained('inventory')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('Sales_id')
                  ->constrained('sales')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sale_items');
    }
};
