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
        Schema::create('tbufaddon', function (Blueprint $table) {
            $table->id('ufa_id');
            $table->foreignId('ufa_uf')->nullable()->constrained('tbufcsd', 'uf_id')->onDelete('set null');
            $table->string('ufa_title', 50)->nullable();
            $table->text('ufa_subtitle')->nullable();
            $table->integer('ufa_order')->nullable();
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
        Schema::dropIfExists('tbufaddon');
    }
};
