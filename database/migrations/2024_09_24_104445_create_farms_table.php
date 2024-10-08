<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('farms', function (Blueprint $table) {
            $table->id();  
            $table->float("user_id");
            $table->string('name');  
            $table->string('location');  
            $table->float('size');  
            $table->timestamps();  
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('farms');
    }
};
