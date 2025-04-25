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
        Schema::table('tbsetting2', function (Blueprint $table) {
            $table->string('set_baseurl', 50)->nullable()->after('set_enroll');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbsetting2', function (Blueprint $table) {
            $table->dropColumn('set_baseurl');
        });
    }
};
