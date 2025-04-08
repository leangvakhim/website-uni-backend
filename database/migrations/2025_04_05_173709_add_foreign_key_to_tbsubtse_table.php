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
        Schema::table('tbsubtse', function (Blueprint $table) {
            $table->foreignId('stse_tse')->nullable()->constrained('tbtse', 'tse_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbsubtse', function (Blueprint $table) {
            $table->dropForeign(['stse_tse']);
            $table->dropColumn('stse_tse');
        });
    }
};
