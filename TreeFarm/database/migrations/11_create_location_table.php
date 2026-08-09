<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('location', function (Blueprint $table) {
            $table->id();

            $table->foreignId('Area_id')
                  ->constrained('area')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('Block_id')
                  ->nullable()
                  ->constrained('block')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('Aisle_id')
                  ->nullable()
                  ->constrained('aisle')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    public function down(): void {
        Schema::dropIfExists('location');
    }
};
