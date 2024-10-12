<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFarmsAndSerresTables extends Migration
{
    public function up()
    {
        // Add foreign key to farms table for user_id if it doesn't exist
        if (!Schema::hasColumn('farms', 'user_id')) {
            Schema::table('farms', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->after('id'); // Add user_id column
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    
        // Add foreign key to serres table for farm_id if it doesn't exist
        if (!Schema::hasColumn('serres', 'farm_id')) {
            Schema::table('serres', function (Blueprint $table) {
                $table->unsignedBigInteger('farm_id')->after('id'); // Add farm_id column
                $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
            });
        }
    }
    

    public function down()
    {
        // Remove foreign key from serres table
        Schema::table('serres', function (Blueprint $table) {
            $table->dropForeign(['farm_id']); // Drop the foreign key constraint
            $table->dropColumn('farm_id'); // Drop the farm_id column if necessary
        });

        // Remove foreign key from farms table
        Schema::table('farms', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key constraint
            $table->dropColumn('user_id'); // Drop the user_id column if necessary
        });
    }
}
