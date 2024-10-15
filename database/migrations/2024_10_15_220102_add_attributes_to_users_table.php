<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributesToUsersTable extends Migration
{
    
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('historique_notice')->default(0);
            $table->boolean('mesfermes_notice')->default(0);
            $table->boolean('mespersonels_notice')->default(0);
            $table->boolean('dashboard_notice')->default(0);
        });
    }
 
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['historique_notice', 'mesfermes_notice', 'mespersonels_notice', 'dashboard_notice']);
        });
    }

    
}
