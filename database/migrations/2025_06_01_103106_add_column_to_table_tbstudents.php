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
        Schema::table('tbstudents', function (Blueprint $table) {
            if (!Schema::hasColumn('tbstudents', 'student_am')) {
                $table->string('student_am')->nullable()->after('result');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbstudents', function (Blueprint $table) {
            $table->dropColumn('student_am');
        });
    }
};
