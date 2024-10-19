<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->foreignId('farm_id')->nullable()->change();
            $table->foreignId('serre_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->foreignId('farm_id')->nullable(false)->change();
            $table->foreignId('serre_id')->nullable(false)->change();
        });
    }
};
