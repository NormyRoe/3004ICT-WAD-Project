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
        Schema::create('allocated_tasks_users', function (Blueprint $table) {


            /***************************************************

                id Field

            ****************************************************/
            $table->id();
			

			/***************************************************
            
                Foreign Keys (Core Relationships)

            ****************************************************/
            $table->unsignedBigInteger('allocated_task_id');
            $table->unsignedBigInteger('user_id');
			
            
            /***************************************************

                Core Fields

            ****************************************************/
            

            
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
            $table->foreign('allocated_task_id')
                  ->references('id')->on('allocated_tasks');

            $table->foreign('user_id')
                  ->references('id')->on('users');

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
        Schema::dropIfExists('allocated_tasks_users');
    }
};
