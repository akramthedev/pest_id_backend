<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            // Drop any existing foreign key (if needed)
            $table->dropForeign(['user_id']);
            
            // Recreate the foreign key with on delete cascade
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            // Rollback: drop the foreign key with cascade and recreate the basic one
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
