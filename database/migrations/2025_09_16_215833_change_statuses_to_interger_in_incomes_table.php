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
        if (Schema::hasTable('incomes')) {
            // Update existing string values to integer values
            DB::table('incomes')->where('status', 'pending')->update(['status' => 1]);
            DB::table('incomes')->where('status', 'received')->update(['status' => 2]);

            Schema::table('incomes', function (Blueprint $table) {
                // Change status column from enum to tinyInteger for better performance
                $table->tinyInteger('status')->default(1)->change();

                // Add index for better performance
                $table->index('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('incomes')) {
            // Update integer values back to string values
            DB::table('incomes')->where('status', 1)->update(['status' => 'pending']);
            DB::table('incomes')->where('status', 2)->update(['status' => 'received']);
            DB::table('incomes')->where('status', 3)->update(['status' => 'pending']);
            DB::table('incomes')->where('status', 4)->update(['status' => 'pending']);
            DB::table('incomes')->where('status', 5)->update(['status' => 'received']);

            Schema::table('incomes', function (Blueprint $table) {
                // Drop the index first
                $table->dropIndex(['status']);

                // Change back to enum
                $table->enum('status', ['pending', 'received'])->default('pending')->change();
            });
        }
    }
};
