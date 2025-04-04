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
        Schema::create('tbapd', function (Blueprint $table) {
            $table->id('apd_id');
            $table->string('apd_title', 100)->nullable();
            $table->foreignId('apd_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbapd');
    }
};
