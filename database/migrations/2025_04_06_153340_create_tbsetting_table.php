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
        Schema::create('tbsetting', function (Blueprint $table) {
            $table->id('set_id');
            $table->string('set_facultytitle', 50)->nullable();
            $table->string('set_facultydep', 50)->nullable();
            $table->foreignId('set_logo')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('set_social')->nullable()->constrained('tbsocial', 'social_id')->onDelete('set null');
            $table->double('set_amstu');
            $table->double('set_enroll');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbsetting');
    }
};
