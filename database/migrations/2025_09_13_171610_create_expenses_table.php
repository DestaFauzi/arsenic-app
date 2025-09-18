<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // karyawan
            $table->decimal('amount', 15, 2);
            $table->string('category'); // salary, bonus, operational, etc
            $table->text('description')->nullable();
            $table->date('payment_date');
            $table->string('reference_number')->nullable();
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['project_id', 'category']);
            $table->index(['user_id', 'status']);
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
