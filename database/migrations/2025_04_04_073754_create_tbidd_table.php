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
        Schema::create('tbidd', function (Blueprint $table) {
            $table->id('idd_id');
            $table->foreignId('idd_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('idd_title', 255)->nullable();
            $table->string('idd_subtitle', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbidd');
    }
};
