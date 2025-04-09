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
        Schema::table('tbsection', function (Blueprint $table) {
            $table->string('sec_type', 255)->nullable()->after("sec_page");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbsection', function (Blueprint $table) {
            $table->dropColumn('sec_type');
        });
    }
};
