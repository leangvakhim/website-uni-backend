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
        Schema::table('tbcontact', function (Blueprint $table) {
            $table->foreignId('con_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('con_addon2')->nullable()->constrained('tbsubcontact', 'scon_id')->onDelete('set null');
            $table->foreignId('con_addon3')->nullable()->constrained('tbsubcontact', 'scon_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbcontact', function (Blueprint $table) {
            $table->dropForeign(['con_img']);
            $table->dropForeign(['con_addon2']);
            $table->dropForeign(['con_addon3']);

            $table->dropColumn(['con_img', 'con_addon2', 'con_addon3']);
        });
    }
};
