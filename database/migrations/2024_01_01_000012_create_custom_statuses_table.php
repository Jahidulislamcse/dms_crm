<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('custom_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->cascadeOnDelete();
            $table->string('name');
            $table->string('color', 20)->default('#64748b');
            $table->integer('order')->default(0);
            $table->boolean('is_default')->default(false);
            $table->enum('core_status', ['pending','in_progress','done_pending_review','done'])->default('in_progress');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('custom_statuses');
    }
};
