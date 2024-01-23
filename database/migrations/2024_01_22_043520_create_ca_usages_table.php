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
        Schema::create('ca_usages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cash_advance_id')->nullable()->constrained('cash_advances')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('admin_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->date('date');
            $table->text('note')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_user_signature_showed')->default(false);
            $table->boolean('is_admin_signature_showed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_usages');
    }
};
