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
        Schema::create('tbstudydegree', function (Blueprint $table) {
            $table->id('std_id');
            $table->foreignId('std_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            $table->string('std_title', 255)->nullable();
            $table->text('std_subtitle')->nullable();
            $table->integer('std_type')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbstudydegree');
    }
};
