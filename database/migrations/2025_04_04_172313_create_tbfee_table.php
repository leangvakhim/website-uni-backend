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
        Schema::create('tbfee', function (Blueprint $table) {
            $table->id('fe_id');
            $table->foreignId('fe_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('fe_title', 255)->nullable();
            $table->text('fe_desc')->nullable();
            $table->foreignId('fe_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->string('fe_price', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbfee');
    }
};
