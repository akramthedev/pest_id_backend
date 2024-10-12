<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID column
            $table->foreignId('prediction_id') // Create the foreign key column
                  ->constrained('predictions') // Reference the predictions table
                  ->onDelete('cascade'); // Set onDelete cascade behavior
            $table->string('name');  // Name of the image
            $table->float('size');  // Size of the image
            $table->boolean('class_A');  // Classification field A
            $table->boolean('class_B');  // Classification field B
            $table->boolean('class_C');  // Classification field C
            
            $table->timestamps();  // Timestamps for created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
