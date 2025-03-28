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
        Schema::create('tbbtnss', function (Blueprint $table) {
            $table->id('bss_id');
            $table->string('bss_title', 50)->nullable();
            $table->text('bss_routepage')->nullable();
            $table->tinyInteger('display')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbbtnss');
    }
};
