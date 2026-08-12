<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->dateTime('Date')->nullable();
            $table->string('Delivery_Notes', 150)->nullable();
            $table->decimal('Delivery_Kms', 10, 2)->nullable();
            $table->decimal('Delivery_Fee', 10, 2)->nullable();
            $table->decimal('Discount', 10, 2)->nullable();
            $table->decimal('Total_Sales_Price', 10, 2)->nullable();
            $table->string('Status', 45)->nullable();

            $table->foreignId('Customer_id')
                  ->constrained('customer')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('Users_id')
                  ->constrained('users')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sales');
    }
};
