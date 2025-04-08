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
        Schema::create('tbservice', function (Blueprint $table) {
            $table->id('s_id'); 
            $table->foreignId('s_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('s_title', 255);
            $table->string('s_subtitle', 255);
            $table->foreignId('s_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->integer('s_order')->nullable();
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
        Schema::dropIfExists('tbservice');
    }
};
