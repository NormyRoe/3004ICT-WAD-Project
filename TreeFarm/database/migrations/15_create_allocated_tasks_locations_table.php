<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('allocated_tasks_locations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('Location_id')
                  ->constrained('location')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->foreignId('Allocated_Tasks_id')
                  ->constrained('allocated_tasks')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    public function down(): void {
        Schema::dropIfExists('allocated_tasks_locations');
    }
};
