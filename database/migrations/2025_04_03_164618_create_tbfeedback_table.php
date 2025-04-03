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
        Schema::create('tbfeedback', function (Blueprint $table) {
            $table->id('fb_id');
            $table->foreignId('fb_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('fb_title', 255)->nullable();
            $table->text('fb_subtitle')->nullable();
            $table->string('fb_writer', 255)->nullable();
            $table->foreignId('fb_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null'); 
            $table->integer('fb_order')->nullable();
            $table->integer('lang')->nullable();
            $table->tinyInteger('display')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbfeedback');
    }
};
