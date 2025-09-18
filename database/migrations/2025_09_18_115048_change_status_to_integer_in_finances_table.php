<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if table exists before updating
        if (Schema::hasTable('finances')) {
            // Update existing string values to integer values
            DB::table('finances')->where('status', 'pending')->update(['status' => 1]);
            DB::table('finances')->where('status', 'approved')->update(['status' => 2]);
            DB::table('finances')->where('status', 'paid')->update(['status' => 3]);

            Schema::table('finances', function (Blueprint $table) {
                // Change status column from enum to tinyInteger for better performance
                $table->tinyInteger('status')->default(1)->change();

                // Add index for better performance if not exists
                if (!Schema::hasIndex('finances', 'finances_status_index')) {
                    $table->index('status');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('finances')) {
            // Update integer values back to string values
            DB::table('finances')->where('status', 1)->update(['status' => 'pending']);
            DB::table('finances')->where('status', 2)->update(['status' => 'approved']);
            DB::table('finances')->where('status', 3)->update(['status' => 'paid']);

            Schema::table('finances', function (Blueprint $table) {
                // Drop the index first if exists
                if (Schema::hasIndex('finances', 'finances_status_index')) {
                    $table->dropIndex(['status']);
                }

                // Change back to enum
                $table->enum('status', ['pending', 'approved', 'paid'])->default('pending')->change();
            });
        }
    }
};
