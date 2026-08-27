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
        Schema::create('trees', function (Blueprint $table) {


            /***************************************************

                id Field

            ****************************************************/
            $table->id();


            /***************************************************
                Foreign Keys (Core Relationships)
            ****************************************************/
            $table->unsignedBigInteger('tree_type_id');

            
            /***************************************************

                Core Fields

            ****************************************************/            
            $table->string('plant_id', 5)->unique();
            $table->string('botanical_name', 150)->unique();
            $table->string('common_name', 100)->unique();
            $table->integer('mature_height_min')->nullable();
            $table->integer('mature_height_max');
            $table->integer('mature_width_min')->nullable();
            $table->integer('mature_width_max');

            
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
            $table->foreign('tree_type_id')
                  ->references('id')->on('tree_types');

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
        Schema::dropIfExists('trees');
    }
};
