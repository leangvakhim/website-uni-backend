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
        Schema::create('tbheadersection', function (Blueprint $table) {
            $table->id('hsec_id');
            $table->foreignId('hsec_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('hsec_title', 50)->nullable();
            $table->string('hsec_subtitle', 255)->nullable();
            $table->string('hsec_btntitle', 15)->nullable();
            $table->text('hsec_routepage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbheadersection');
    }
};
