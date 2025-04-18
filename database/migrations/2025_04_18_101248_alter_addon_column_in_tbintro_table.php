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
        Schema::table('tbintro', function (Blueprint $table) {
            $table->text('in_addsubtitle')->nullable()->change();
            $table->text('inadd_title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbintro', function (Blueprint $table) {
            $table->string('in_addsubtitle', 50)->nullable()->change();
            $table->string('inadd_title', 50)->nullable()->change();
        });
    }
};
