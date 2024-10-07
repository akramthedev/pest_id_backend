<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('serre_id')->constrained('serres');  
            $table->foreignId('farm_id')->constrained('farms');  
            $table->foreignId('user_id')->constrained('users');  
            $table->text('description');  
            $table->decimal('result', 5, 2);  
            $table->timestamps();  
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
