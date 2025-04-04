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
        Schema::table('tbsubha', function (Blueprint $table) {
            $table->foreignId('sha_ha')->nullable()->constrained('tbha', 'ha_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbsubha', function (Blueprint $table) {
            $table->dropForeign(['sha_ha']);
            $table->dropColumn('sha_ha');
        });
    }
};
