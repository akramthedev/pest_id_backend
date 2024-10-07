<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('user_id')->constrained('users');   
            $table->text('company_name')->nullable();
            $table->text('company_email')->nullable();
            $table->text('company_mobile')->nullable();
            $table->timestamps(); //this command add createdAt and updatedAt like in MongoDB automaticaly
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }


};
