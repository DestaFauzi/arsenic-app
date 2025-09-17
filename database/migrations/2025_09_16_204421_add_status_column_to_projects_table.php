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
        Schema::table('projects', function (Blueprint $table) {
            // Tambah kolom status dengan tipe integer
            $table->integer('status')->default(1)->after('pic_user_id');

            // Buat index untuk performa query
            $table->index(['status', 'project_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Drop index terlebih dahulu
            $table->dropIndex(['status', 'project_type_id']);

            // Drop kolom status
            $table->dropColumn('status');
        });
    }
};
