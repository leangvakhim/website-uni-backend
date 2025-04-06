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
        Schema::create('tbsubapd', function (Blueprint $table) {
            $table->id('sapd_id');
            $table->foreignId('sapd_apd')->nullable()->constrained('tbapd', 'apd_id')->onDelete('set null');
            $table->string('sapd_title', 50)->nullable();
            $table->foreignId('sapd_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->text('sapd_routepage')->nullable();
            $table->integer('sapd_order')->nullable(); 
            $table->boolean('display')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbsubapd');
    }
};
