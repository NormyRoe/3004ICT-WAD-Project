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
        Schema::create('allocated_tasks', function (Blueprint $table) {


            /***************************************************

                id Field

            ****************************************************/
            $table->id();
			

			/***************************************************
            
                Foreign Keys (Core Relationships)

            ****************************************************/
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('tree_id')->nullable();
            $table->unsignedBigInteger('location_1_id')->nullable();
            $table->unsignedBigInteger('location_2_id')->nullable();
            $table->unsignedBigInteger('pot_size_id')->nullable();
			
            
            /***************************************************

                Core Fields

            ****************************************************/
            $table->dateTime('date');
            $table->string('notes', 200)->nullable();
            $table->integer('quantity')->nullable();
            $table->tinyInteger('done')->nullable();
            $table->tinyInteger('allocated');

            
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
            $table->foreign('task_id')
                  ->references('id')->on('tasks');

            $table->foreign('tree_id')
                  ->references('id')->on('trees');

            $table->foreign('pot_size_id')
                  ->references('id')->on('pot_sizes');

            $table->foreign('location_1_id')
                  ->references('id')->on('locations');

            $table->foreign('location_2_id')
                  ->references('id')->on('locations');

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
        Schema::dropIfExists('allocated_tasks');
    }
};
