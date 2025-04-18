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
        Schema::table('tbsubcontact', function (Blueprint $table) {
            $table->dropColumn(['scon_order', 'display']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbsubcontact', function (Blueprint $table) {
            $table->integer('scon_order')->nullable();
            $table->boolean('display')->default(0);
        });
    }
};
