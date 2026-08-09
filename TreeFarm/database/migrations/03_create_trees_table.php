<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('trees', function (Blueprint $table) {
            $table->id();

            $table->string('Plant_ID', 5)->nullable()->unique();
            $table->string('Botanical_Name', 150)->nullable()->unique();
            $table->string('Common_Name', 100)->nullable()->unique();

            $table->foreignId('Tree_Type_id')
                  ->constrained('tree_type')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->integer('Mature_Height_Min')->nullable();
            $table->integer('Mature_Height_Max')->nullable();
            $table->integer('Mature_Width_Min')->nullable();
            $table->integer('Mature_Width_Max')->nullable();

            $table->dateTime('created_on')->nullable();
            $table->dateTime('modified_on')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('trees');
    }
};
