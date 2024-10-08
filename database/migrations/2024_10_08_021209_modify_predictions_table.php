<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     
    public function up(): void
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->dropColumn('description');  
            $table->integer('plaque_id')->after('serre_id');  
        });
    }

     
    public function down(): void
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->text('description')->after('serre_id');  
            $table->dropColumn('plaque_id');  
        });
    }
};
