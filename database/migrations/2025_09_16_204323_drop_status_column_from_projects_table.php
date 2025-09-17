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
            // Drop index terlebih dahulu jika ada
            $table->dropIndex(['status', 'project_type_id']);

            // Drop kolom status
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Tambah kembali kolom status sebagai enum
            $table->enum('status', ['planning', 'in_progress', 'on_hold', 'completed', 'cancelled'])
                ->default('planning')
                ->after('pic_user_id');

            // Buat kembali index
            $table->index(['status', 'project_type_id']);
        });
    }
};
