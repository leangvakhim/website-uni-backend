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
        Schema::table('tbbanner', function (Blueprint $table) {
            $table->unsignedBigInteger('ban_sec')->nullable()->after('ban_id');

            $table->foreign('ban_sec')
                ->references('sec_id')
                ->on('tbsection')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbbanner', function (Blueprint $table) {
            $table->dropForeign(['ban_sec']);
            $table->dropColumn('ban_sec');
        });
    }
};
