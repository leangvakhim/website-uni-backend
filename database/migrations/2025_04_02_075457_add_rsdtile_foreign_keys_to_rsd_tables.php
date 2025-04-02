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
            $table->foreignId('rsdd_rsdtile')->nullable()->constrained('tbrsd_title', 'rsdt_id')->onDelete('set null');
        });

        Schema::table('tbrsd_project', function (Blueprint $table) {
            $table->foreignId('rsdp_rsdtile')->nullable()->constrained('tbrsd_title', 'rsdt_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbrsd_desc', function (Blueprint $table) {
            $table->dropForeign(['rsdd_rsdtile']);
            $table->dropColumn('rsdd_rsdtile');
        });

        Schema::table('tbrsd_project', function (Blueprint $table) {
            $table->dropForeign(['rsdp_rsdtile']);
            $table->dropColumn('rsdp_rsdtile');
        });
    }
};
