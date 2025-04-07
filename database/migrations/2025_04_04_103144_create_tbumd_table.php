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
        Schema::create('tbumd', function (Blueprint $table) {
            $table->id('umd_id');
            $table->foreignId('umd_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('umd_title', 100)->nullable();
            $table->text('umd_detail')->nullable();
            $table->string('umd_routepage', 100)->nullable();
            $table->string('umd_btntext', 20)->nullable();
            $table->foreignId('umd_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbumd');
    }
};
