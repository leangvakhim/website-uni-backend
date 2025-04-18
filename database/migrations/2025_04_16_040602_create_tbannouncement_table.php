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
        Schema::create('tbannouncement', function (Blueprint $table) {
            $table->id('am_id');
            $table->string('am_title', 255)->nullable();
            $table->string('am_shortdesc', 255)->nullable();
            $table->text('am_detail')->nullable();
            $table->dateTime('am_postdate')->nullable();
            $table->foreignId('am_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->tinyInteger('am_fav')->nullable();
            $table->integer('lang')->nullable();
            $table->integer('am_orders')->nullable();
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
        Schema::dropIfExists('tbannouncement');
    }
};
