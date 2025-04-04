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
            Schema::table('tbslideshow2', function (Blueprint $table) {
                $table->foreignId('slider_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbslideshow2', function (Blueprint $table) {
            $table->dropForeign(['slider_sec']);
            $table->dropColumn('slider_sec');
        });
    }
};
