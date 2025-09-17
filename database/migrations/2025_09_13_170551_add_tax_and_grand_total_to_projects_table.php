<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('tax_percentage', 5, 2)->default(11.00)->after('budget'); // Default PPN 11%
            $table->decimal('tax_amount', 15, 2)->nullable()->after('tax_percentage');
            $table->decimal('grand_total', 15, 2)->nullable()->after('tax_amount'); // budget + tax
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['tax_percentage', 'tax_amount', 'grand_total']);
        });
    }
};
