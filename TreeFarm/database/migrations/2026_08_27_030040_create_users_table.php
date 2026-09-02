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
        Schema::create('users', function (Blueprint $table) {

            /***************************************************

                id Field

            ****************************************************/
            $table->id();

            
            /***************************************************
            
                Foreign Keys (Core Relationships)

            ****************************************************/
            $table->unsignedBigInteger('manager_id')->nullable();


            /***************************************************

                Core Fields

            ****************************************************/
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('username', 45)->unique();
            $table->string('email', 100)->unique();
            $table->string('job_title', 100)->nullable();            
            $table->string('status', 45)->nullable();
            $table->string('password', 150);
            $table->rememberToken();

            
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
            $table->foreign('manager_id')
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
        Schema::dropIfExists('users');
    }
};
