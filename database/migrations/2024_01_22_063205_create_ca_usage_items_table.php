<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ca_usage_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ca_usage_id')->constrained('ca_usages')->cascadeOnDelete();
            $table->date('date');
            $table->text('note');
            $table->enum('type', ['debit', 'credit']);
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_usage_items');
    }
};
