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
        Schema::table('tbannouncement', function (Blueprint $table) {
            if (!Schema::hasColumn('tbannouncement', 'am_tag')) {
                $table->string('am_tag')->nullable()->after('am_fav');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbannouncement', function (Blueprint $table) {
            $table->dropColumn('am_tag');
        });
    }
};
