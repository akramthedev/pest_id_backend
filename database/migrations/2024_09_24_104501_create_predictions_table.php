<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();  // Primary key (auto-incrementing ID)

            // Foreign key for user_id
            $table->foreignId('user_id')
                  ->constrained('users')  // References users table
                  ->onDelete('cascade');   // Cascade delete
            
            // Foreign key for farm_id
            $table->foreignId('farm_id')
                  ->constrained('farms')  // References farms table
                  ->onDelete('cascade');   // Cascade delete

            // Foreign key for serre_id
            $table->foreignId('serre_id')
                  ->constrained('serres')  // References serres table
                  ->onDelete('cascade');   // Cascade delete

            // Additional fields (based on your SQL file, you can adjust as needed)
            $table->float('result');            // Example: a float value for accuracy of prediction
            
            $table->timestamps();                 // Laravel's created_at and updated_at timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predictions'); // Drop the table on rollback
    }
};
