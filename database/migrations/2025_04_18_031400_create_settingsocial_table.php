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
        Schema::create('tbsettingsocial', function (Blueprint $table) {
            $table->id('setsoc_id');
            $table->string('setsoc_title', 50)->nullable();
            $table->foreignId('setsoc_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('setsoc_setting')->nullable()->constrained('tbsetting2', 'set_id')->onDelete('set null');
            $table->text('setsoc_link')->nullable();
            $table->integer('setsoc_order')->nullable();
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
        Schema::dropIfExists('settingsocials');
    }
};
