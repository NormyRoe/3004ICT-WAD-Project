<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {


            /***************************************************

                id Field

            ****************************************************/
            $table->id();
			

			/***************************************************
            
                Foreign Keys (Core Relationships)

            ****************************************************/
            
			
            
            /***************************************************

                Core Fields

            ****************************************************/
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone_number', 10)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('street_address_1', 45);
            $table->string('street_address_2', 45)->nullable();
            $table->string('suburb', 45);
            $table->string('postcode', 4);

            
            /***************************************************

                created_by and modified_by fields

            ****************************************************/
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();

            
            /***************************************************

                Laravel timestamps

            ****************************************************/
            $table->timestamps();

            
            /***************************************************

                Foreign Key Constraints

            ****************************************************/
            $table->foreign('created_by')
                  ->references('id')->on('users');

            $table->foreign('modified_by')
                  ->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
