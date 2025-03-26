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
        Schema::create('tbbanner', function (Blueprint $table) {
            $table->id('ban_id'); 
            $table->string('ban_title', 255)->nullable();
            $table->string('ban_subtitle', 255)->nullable();
            $table->foreignId('ban_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbbanner');
    }
};
