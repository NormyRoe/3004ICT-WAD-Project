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
        Schema::create('prices', function (Blueprint $table) {


            /***************************************************

                id Field

            ****************************************************/
            $table->id();
			

			/***************************************************
            
                Foreign Keys (Core Relationships)

            ****************************************************/
            $table->unsignedBigInteger('pot_size_id')->nullable();
			
            
            /***************************************************

                Core Fields

            ****************************************************/
            $table->string('name', 45)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('rate', 10, 2)->nullable();

            
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
            $table->foreign('pot_size_id')
                  ->references('id')->on('pot_sizes');

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
        Schema::dropIfExists('prices');
    }
};
