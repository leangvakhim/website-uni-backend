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
        Schema::create('tbslideshow2', function (Blueprint $table) {
            $table->id('slider_id');
            $table->string('slider_title', 100)->nullable();
            $table->text('slider_text')->nullable();
            $table->foreignId('btn1')->nullable()->constrained('tbbtnss', 'bss_id')->onDelete('set null');
            $table->foreignId('btn2')->nullable()->constrained('tbbtnss', 'bss_id')->onDelete('set null');
            $table->foreignId('img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('logo')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->integer('slider_order');
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
        Schema::dropIfExists('tbslideshow2');
    }
};
