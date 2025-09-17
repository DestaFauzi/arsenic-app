<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('project_type_id')->constrained('project_types')->onDelete('cascade');
            $table->foreignId('pic_user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['planning', 'in_progress', 'on_hold', 'completed', 'cancelled'])->default('planning');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->json('additional_info')->nullable();
            $table->timestamps();

            $table->index(['status', 'project_type_id']);
            $table->index('pic_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
