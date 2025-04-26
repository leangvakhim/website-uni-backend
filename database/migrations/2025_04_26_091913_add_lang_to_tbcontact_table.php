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
        Schema::table('tbcontact', function (Blueprint $table) {
            $table->integer('lang')->nullable()->after('con_subtitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbcontact', function (Blueprint $table) {
            $table->dropColumn('lang');
        });
    }
};
