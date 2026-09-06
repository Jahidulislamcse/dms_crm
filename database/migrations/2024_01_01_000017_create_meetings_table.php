<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained('leads')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('client_name')->nullable();
            $table->string('agenda')->nullable();
            $table->date('date');
            $table->time('time')->nullable();
            $table->integer('duration')->default(60);
            $table->string('location')->nullable();
            $table->enum('status', ['scheduled','completed','cancelled'])->default('scheduled');
            $table->text('outcome')->nullable();
            $table->text('next_action')->nullable();
            $table->date('next_followup')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('meetings');
    }
};
