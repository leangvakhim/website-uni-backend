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
        Schema::create('tbrsdltag', function (Blueprint $table) {
            $table->id('rsdlt'); 
            $table->foreignId('rsdlt_rsdl')->nullable()->constrained('tbrsdl', 'rsdl_id')->onDelete('set null');
            $table->string('rsdlt_title', 100)->nullable();
            $table->foreignId('rsdlt_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbrsdltag');
    }
};
