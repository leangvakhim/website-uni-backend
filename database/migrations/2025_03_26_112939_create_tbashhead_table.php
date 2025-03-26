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
        Schema::create('tbashhead', function (Blueprint $table) {
            $table->id('ash_id');
            $table->text('ash_title')->nullable();
            $table->text('ash_subtitle')->nullable();
            $table->string('ash_routetitle', 50)->nullable();
            $table->text('ash_routepage')->nullable();        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbashhead');
    }
};
