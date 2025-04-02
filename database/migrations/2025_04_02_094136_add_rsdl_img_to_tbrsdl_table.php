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
        Schema::table('tbrsdl', function (Blueprint $table) {
            $table->foreignId('rsdl_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbrsdl', function (Blueprint $table) {
            $table->dropForeign(['rsdl_img']);
            $table->dropColumn('rsdl_img');
        });
    }
};
