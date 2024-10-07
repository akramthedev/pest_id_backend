<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();  
            $table->string('fullName')->nullable();  
            $table->string('email')->unique();   
            $table->string('password');
            $table->string('mobile')->nullable(); 
            $table->enum('type', ['superadmin', 'admin', 'staff']);
            $table->timestamps();  
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
