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
        Schema::create('tbnew', function (Blueprint $table) {
            $table->id('n_id');
            $table->text('n_title')->nullable();
            $table->text('n_shorttitle')->nullable();
            $table->foreignId('n_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->string('n_tags', 50)->nullable();
            $table->dateTime('n_date')->nullable();
            $table->text('n_detail')->nullable();
            $table->tinyInteger('n_fav')->default(0);
            $table->integer('lang')->nullable();
            $table->integer('n_order'); 
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
        Schema::dropIfExists('tbnew');
    }
};
