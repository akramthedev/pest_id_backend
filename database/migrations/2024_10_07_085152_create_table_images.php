<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('prediction_id')->constrained('predictions');  
            $table->string('name');  
            $table->float('size');  
            $table->boolean('class_A');  
            $table->boolean('class_B');  
            $table->boolean('class_C');  
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
