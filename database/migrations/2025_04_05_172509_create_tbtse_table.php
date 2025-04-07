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
        Schema::create('tbtse', function (Blueprint $table) {
            $table->id('tse_id');
            $table->foreignId('tse_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->integer('tse_type')->nullable();
            $table->foreignId('tse_text')->nullable()->constrained('tbtext', 'text_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbtse');
    }
};
