<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('source'); // project_payment, additional_service, etc
            $table->text('description')->nullable();
            $table->date('received_date');
            $table->string('invoice_number')->nullable();
            $table->enum('status', ['pending', 'received'])->default('pending');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['project_id', 'status']);
            $table->index(['source', 'received_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
