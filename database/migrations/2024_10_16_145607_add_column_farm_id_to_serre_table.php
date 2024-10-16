<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     

    public function up()
    {
        if (!Schema::hasColumn('serres', 'farm_id')) {
            Schema::table('serres', function (Blueprint $table) {
                $table->unsignedBigInteger('farm_id')->after('id');  
                $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
            });
        }
    }
    

    public function down()
    {
        Schema::table('serres', function (Blueprint $table) {
            $table->dropForeign(['farm_id']);  
            $table->dropColumn('farm_id');  
        });

    }


};
