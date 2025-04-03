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
        Schema::create('tbpage', function (Blueprint $table) {
            $table->id('p_id');
            $table->foreignId('p_menu')->nullable()->constrained('tbmenu', 'menu_id')->onDelete('set null');
            $table->string('p_title', 50)->nullable();
            $table->text('p_alias')->nullable();
            $table->tinyInteger('p_busy')->default(0);
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
        Schema::dropIfExists('tbpage');
    }
};
