<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('serres', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('farm_id')->constrained('farms');  
            $table->string('name');  
            $table->float('size'); 
            $table->enum('type', ['vegetable', 'fruit', 'flower']); 
            $table->timestamps();  
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('serres');
    }
};
