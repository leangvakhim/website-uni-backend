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
        Schema::create('tbcontact', function (Blueprint $table) {
            $table->id('con_id');
            $table->string('con_title', 255)->nullable();
            $table->text('con_subtitle')->nullable();
            $table->foreignId('con_addon')->nullable()->constrained('tbsubcontact', 'scon_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbcontact');
    }
};
