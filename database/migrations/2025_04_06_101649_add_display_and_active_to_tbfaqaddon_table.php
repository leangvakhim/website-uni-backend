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
        Schema::table('tbfaqaddon', function (Blueprint $table) {
            $table->tinyInteger('display')->default(1)->after('fa_answer');
            $table->tinyInteger('active')->default(1)->after('display');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbfaqaddon', function (Blueprint $table) {
            $table->dropColumn('display');
            $table->dropColumn('active');
        });
    }
};
