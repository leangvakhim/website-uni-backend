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
        Schema::create('tbsubservice', function (Blueprint $table) {
            $table->id('ss_id');
            $table->foreignId('ss_af')->nullable()->constrained('tbacadfacility', 'af_id')->onDelete('set null');
            $table->foreignId('ss_ras')->nullable()->constrained('tbras', 'ras_id')->onDelete('set null');
            $table->string('ss_title', 255)->nullable();
            $table->text('ss_subtitle')->nullable();
            $table->foreignId('ss_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->integer('ss_order')->nullable();
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
        Schema::dropIfExists('tbsubservice');
    }
};
