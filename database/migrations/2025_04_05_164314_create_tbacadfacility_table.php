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
        Schema::create('tbacadfacility', function (Blueprint $table) {
            $table->id('af_id');
            $table->foreignId('af_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->foreignId('af_text')->nullable()->constrained('tbtext', 'text_id')->onDelete('set null');
            $table->foreignId('af_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbacadfacility');
    }
};
