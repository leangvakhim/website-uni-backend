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
        Schema::table('tbyear', function (Blueprint $table) {
            $table->foreignId('y_std')->nullable()->constrained('tbstudydegree', 'std_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbyear', function (Blueprint $table) {
            $table->dropForeign(['y_std']);
            $table->dropColumn('y_std');
        });
    }
};
