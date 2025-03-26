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
        Schema::create('tbgcaddon', function (Blueprint $table) {
            $table->id('gca_id');
            $table->string('gca_tag', 255)->nullable();
            $table->string('gca_btntitle', 50)->nullable();
            $table->text('gca_btnlink')->nullable();        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbgcaddon');
    }
};
