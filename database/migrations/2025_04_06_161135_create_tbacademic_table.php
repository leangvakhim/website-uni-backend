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
        Schema::create('tbacademic', function (Blueprint $table) {
            $table->id('acad_id');
            $table->foreignId('acad_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('acad_title', 100)->nullable();
            $table->text('acad_detail')->nullable();
            $table->foreignId('acad_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->string('acad_btntext1', 30)->nullable();
            $table->string('acad_btntext2', 30)->nullable();
            $table->string('acad_routepage', 100)->nullable();
            $table->string('acad_routetext', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbacademic');
    }
};
