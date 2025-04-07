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
        Schema::create('tbufcsd', function (Blueprint $table) {
            $table->id('uf_id');
            $table->foreignId('uf_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('uf_title', 255)->nullable();
            $table->text('uf_subtitle')->nullable();
            $table->foreignId('uf_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbufcsd');
    }
};
