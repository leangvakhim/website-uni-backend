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
        Schema::create('tbgc', function (Blueprint $table) {
            $table->id('gc_id');
            $table->foreignId('gc_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('gc_title')->nullable();
            $table->string('gc_tag', 100)->nullable();
            $table->integer('gc_type')->nullable();
            $table->text('gc_detail')->nullable();
            $table->foreignId('gc_img1')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('gc_img2')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbgc');
    }
};
