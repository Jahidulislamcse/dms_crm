<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('content_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->enum('platform', ['facebook','instagram','linkedin','twitter','tiktok','youtube','other'])->default('facebook');
            $table->string('post_type')->default('image');
            $table->date('date');
            $table->enum('status', ['pending','scheduled','in_progress','done','cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('brief')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('content_posts');
    }
};
