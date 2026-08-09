<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('First_Name', 50)->nullable();
            $table->string('Last_Name', 50)->nullable();
            $table->string('Phone_Number', 10)->nullable();
            $table->string('Email', 100)->nullable();
            $table->string('Street_Address_1', 45)->nullable();
            $table->string('Street_Address_2', 45)->nullable();
            $table->string('Suburb', 45)->nullable();
            $table->string('Postcode', 4)->nullable();
            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('customer');
    }
};
