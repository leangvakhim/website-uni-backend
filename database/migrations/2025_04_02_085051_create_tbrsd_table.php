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
        Schema::create('tbrsd', function (Blueprint $table) {
            $table->id('rsd_id');
            $table->string('rsd_title', 255)->nullable();
            $table->string('rsd_subtitle', 255)->nullable();
            $table->string('rsd_lead', 255)->nullable();
            $table->foreignId('rsd_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('rsd_text')->nullable()->constrained('tbrsd_title', 'rsdt_id')->onDelete('set null');
            $table->tinyInteger('rsd_fav')->default(0);
            $table->integer('lang')->nullable();
            $table->integer('rsd_order');
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
        Schema::dropIfExists('tbrsd');
    }
};
