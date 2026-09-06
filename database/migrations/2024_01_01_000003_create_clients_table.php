<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('assigned_smm')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_sales')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['active','inactive','onboarding','paused'])->default('active');
            $table->enum('billing_cycle', ['monthly','quarterly','one-time'])->default('monthly');
            $table->decimal('advance', 10, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->tinyInteger('satisfaction_score')->nullable();
            $table->date('onboarded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('clients');
    }
};
