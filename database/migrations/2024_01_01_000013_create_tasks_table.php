<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('assigned_to')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->foreignId('parent_task_id')->nullable()->constrained('tasks')->nullOnDelete();
            $table->foreignId('custom_status_id')->nullable()->constrained('custom_statuses')->nullOnDelete();
            $table->enum('status', ['pending','in_progress','done_pending_review','done'])->default('pending');
            $table->enum('priority', ['high','medium','low'])->default('medium');
            $table->enum('approval_status', ['pending','approved','revision'])->nullable();
            $table->text('notes')->nullable();
            $table->date('deadline')->nullable();
            $table->date('scheduled_date')->nullable();
            $table->decimal('estimated_hours', 5, 2)->nullable();
            $table->integer('qty')->nullable();
            $table->boolean('recurring_enabled')->default(false);
            $table->enum('recurring_type', ['daily','weekly','monthly'])->nullable();
            $table->integer('recurring_interval')->default(1);
            $table->date('recurring_end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tasks');
    }
};
