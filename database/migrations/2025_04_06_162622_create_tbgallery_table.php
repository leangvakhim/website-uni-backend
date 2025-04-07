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
        Schema::create('tbgallery', function (Blueprint $table) {
            $table->id('gal_id');
            $table->foreignId('gal_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->foreignId('gal_text')->nullable()->constrained('tbtext', 'text_id')->onDelete('set null');
            $table->foreignId('gal_img1')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('gal_img2')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('gal_img3')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('gal_img4')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('gal_img5')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbgallery');
    }
};
