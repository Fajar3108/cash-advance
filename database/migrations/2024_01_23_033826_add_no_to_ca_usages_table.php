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
        Schema::table('ca_usages', function (Blueprint $table) {
            DB::statement('ALTER TABLE ca_usages ADD no INT UNIQUE NOT NULL AUTO_INCREMENT AFTER cash_advance_id');
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ca_usages', function (Blueprint $table) {
            $table->dropColumn('no');
        });
    }
};
