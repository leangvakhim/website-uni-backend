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
        Schema::create('tbras', function (Blueprint $table) {
            $table->id('ras_id');
            $table->foreignId('ras_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->foreignId('ras_text')->nullable()->constrained('tbtext', 'text_id')->onDelete('set null');
            $table->foreignId('ras_img1')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('ras_img2')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ras');
    }
};
