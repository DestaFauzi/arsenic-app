<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Drop the old enum status column
            $table->dropColumn('status');
        });

        Schema::table('expenses', function (Blueprint $table) {
            // Add new integer status column with proper workflow statuses
            $table->tinyInteger('status')->default(1)->after('reference_number')
                ->comment('1=Need Accounting Approval, 2=Need Finance Approval, 3=Need Director Approval, 4=Approved, 5=Paid, 6=Rejected');

            // Add approval notes field
            $table->text('approval_notes')->nullable()->after('status');

            // Add approved_by fields for tracking who approved at each stage
            $table->foreignId('approved_by_accounting')->nullable()->constrained('users')->onDelete('set null')->after('approval_notes');
            $table->foreignId('approved_by_finance')->nullable()->constrained('users')->onDelete('set null')->after('approved_by_accounting');
            $table->foreignId('approved_by_director')->nullable()->constrained('users')->onDelete('set null')->after('approved_by_finance');

            // Add approval timestamps
            $table->timestamp('accounting_approved_at')->nullable()->after('approved_by_director');
            $table->timestamp('finance_approved_at')->nullable()->after('accounting_approved_at');
            $table->timestamp('director_approved_at')->nullable()->after('finance_approved_at');
            $table->timestamp('paid_at')->nullable()->after('director_approved_at');

            // Add indexes for better performance
            $table->index('status');
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Drop new columns
            $table->dropForeign(['approved_by_accounting']);
            $table->dropForeign(['approved_by_finance']);
            $table->dropForeign(['approved_by_director']);

            $table->dropColumn([
                'status',
                'approval_notes',
                'approved_by_accounting',
                'approved_by_finance',
                'approved_by_director',
                'accounting_approved_at',
                'finance_approved_at',
                'director_approved_at',
                'paid_at'
            ]);
        });

        Schema::table('expenses', function (Blueprint $table) {
            // Restore old enum status column
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending')->after('reference_number');
        });
    }
};
