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
        Schema::table('tbrsd_desc', function (Blueprint $table) {
            $table->string('rsdd_title', 255)->after('rsdd_rsdtile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbrsd_desc', function (Blueprint $table) {
            $table->dropColumn('rsdd_title');
        });
    }
};
