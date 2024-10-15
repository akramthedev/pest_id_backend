<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class uzrsuodvuozsfvdhosoqduvhoucshuofdwv extends Migration
{
    
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('liste_users_notice')->default(0);
            $table->boolean('nouvelle_demande_notice')->default(0);
        });
    }
 
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['liste_users_notice', 'nouvelle_demande_notice']);
        });
    }

    
}
