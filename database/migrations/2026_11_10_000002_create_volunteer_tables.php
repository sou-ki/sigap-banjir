<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('phone', 30);
            $table->string('domicile')->nullable();
            $table->enum('status', ['available', 'assigned', 'unavailable'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['status', 'name']);
        });

        Schema::create('volunteer_skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('skill_volunteer', function (Blueprint $table) {
            $table->foreignId('volunteer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('volunteer_skill_id')->constrained()->cascadeOnDelete();
            $table->primary(['volunteer_id', 'volunteer_skill_id']);
        });

        Schema::create('volunteer_needs', function (Blueprint $table) {
            $table->id();
            $table->string('need_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location');
            $table->foreignId('flood_report_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('shelter_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedSmallInteger('volunteers_required');
            $table->unsignedSmallInteger('volunteers_assigned')->default(0);
            $table->json('required_skills')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['open', 'partially_filled', 'filled', 'completed', 'cancelled'])->default('open');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['status', 'priority']);
        });

        Schema::create('volunteer_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('assignment_number')->unique();
            $table->foreignId('volunteer_need_id')->constrained()->cascadeOnDelete();
            $table->foreignId('volunteer_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['assigned', 'en_route', 'in_progress', 'completed', 'cancelled'])->default('assigned');
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['volunteer_need_id', 'volunteer_id']);
            $table->index(['status', 'assigned_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_assignments');
        Schema::dropIfExists('volunteer_needs');
        Schema::dropIfExists('skill_volunteer');
        Schema::dropIfExists('volunteer_skills');
        Schema::dropIfExists('volunteers');
    }
};
