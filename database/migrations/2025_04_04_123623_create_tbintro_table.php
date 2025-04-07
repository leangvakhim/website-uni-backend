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
        Schema::create('tbintro', function (Blueprint $table) {
            $table->id('in_id');
            $table->foreignId('in_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('in_title', 255)->nullable();
            $table->text('in_detail')->nullable();
            $table->foreignId('in_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->string('inadd_title', 50)->nullable();
            $table->string('in_addsubtitle', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbintro');
    }
};
