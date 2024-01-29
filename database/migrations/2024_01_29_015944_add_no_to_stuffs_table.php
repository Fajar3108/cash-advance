<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stuffs', function (Blueprint $table) {
            DB::statement('ALTER TABLE stuffs ADD no INT UNIQUE NOT NULL AUTO_INCREMENT AFTER id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stuffs', function (Blueprint $table) {
            $table->dropColumn('no');
        });
    }
};
