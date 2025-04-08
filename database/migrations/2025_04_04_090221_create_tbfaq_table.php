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
        Schema::create('tbfaq', function (Blueprint $table) {
            $table->id('faq_id');
            $table->foreignId('faq_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('faq_title', 255)->nullable();
            $table->text('faq_subtitle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbfaq');
    }
};
