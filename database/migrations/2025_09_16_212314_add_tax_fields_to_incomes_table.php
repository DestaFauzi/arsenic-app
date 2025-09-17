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
        Schema::table('incomes', function (Blueprint $table) {
            $table->decimal('tax_percentage', 5, 2)->nullable()->after('amount');
            $table->decimal('tax_amount', 15, 2)->nullable()->after('tax_percentage');
            $table->decimal('grand_total', 15, 2)->nullable()->after('tax_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn(['tax_percentage', 'tax_amount', 'grand_total']);
        });
    }
};
