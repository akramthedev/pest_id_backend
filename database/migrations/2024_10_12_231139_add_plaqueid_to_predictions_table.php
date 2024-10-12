<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->string('plaque_id', 100)->nullable();
        });
    }
    
    
    public function down(): void
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->dropColumn('plaque_id');
        });
    }
};
