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
        Schema::create('tbevent', function (Blueprint $table) {
            $table->id('e_id');
            $table->text('e_title')->nullable();
            $table->text('e_shorttitle')->nullable();
            $table->foreignId('e_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->string('e_tags', 50)->nullable();
            $table->dateTime('e_date')->nullable();
            $table->text('e_detail')->nullable();
            $table->tinyInteger('e_fav')->default(0);
            $table->integer('lang')->nullable(); 
            $table->integer('e_order'); 
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
        Schema::dropIfExists('tbevent');
    }
};
