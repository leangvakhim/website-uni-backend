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
        Schema::create('tbha', function (Blueprint $table) {
            $table->id('ha_id');
            $table->foreignId('ha_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('ha_title', 255)->nullable();
            $table->foreignId('ha_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->string('ha_tagtitle', 255)->nullable();
            $table->string('ha_subtitletag', 255)->nullable();
            $table->dateTime('ha_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbha');
    }
};
