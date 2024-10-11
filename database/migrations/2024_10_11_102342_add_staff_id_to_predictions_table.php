<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    
    public function up()
{
    Schema::table('predictions', function (Blueprint $table) {
        $table->unsignedBigInteger('staff_id')->nullable(); // Adjust to your needs
        
        // Optionally, you can also add a foreign key constraint if necessary
        $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('predictions', function (Blueprint $table) {
        $table->dropForeign(['staff_id']); // Drop foreign key if it exists
        $table->dropColumn('staff_id');
    });
}



};
