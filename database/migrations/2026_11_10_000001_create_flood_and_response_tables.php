<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flood_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->dateTime('occurred_at');
            $table->string('village')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedSmallInteger('water_level_cm')->nullable();
            $table->enum('danger_level', ['low', 'medium', 'high'])->default('low');
            $table->json('impacts')->nullable();
            $table->enum('status', ['pending', 'needs_clarification', 'verified', 'rejected', 'in_progress', 'resolved'])
                ->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('verification_note')->nullable();
            $table->timestamps();
            $table->index(['status', 'occurred_at']);
            $table->index(['latitude', 'longitude']);
        });

        Schema::create('flood_report_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flood_report_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name')->nullable();
            $table->unsignedInteger('size_bytes')->nullable();
            $table->timestamps();
        });

        Schema::create('shelters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('village')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedInteger('capacity');
            $table->unsignedInteger('occupant_count')->default(0);
            $table->enum('status', ['standby', 'active', 'full', 'closed'])->default('standby');
            $table->text('notes')->nullable();
            $table->foreignId('managed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['status', 'name']);
        });

        Schema::create('shelter_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shelter_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
            $table->unique(['shelter_id', 'name']);
        });

        Schema::create('evacuation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('flood_report_id')->nullable()->constrained()->nullOnDelete();
            $table->string('requester_name');
            $table->string('contact_phone', 30);
            $table->string('pickup_address')->nullable();
            $table->string('village')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->unsignedSmallInteger('people_count');
            $table->string('emergency_condition')->nullable();
            $table->json('vulnerable_groups')->nullable();
            $table->text('additional_information')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['pending', 'accepted', 'in_progress', 'completed', 'cancelled'])
                ->default('pending');
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('shelter_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'priority']);
            $table->index('flood_report_id');
        });

        Schema::create('road_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('road_name');
            $table->enum('access_status', ['open', 'limited', 'closed', 'unknown'])->default('unknown');
            $table->text('notes')->nullable();
            $table->json('coordinates')->nullable();
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('observed_at')->nullable();
            $table->timestamps();
            $table->index(['road_name', 'observed_at']);
        });

        Schema::create('evacuation_routes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('origin_name');
            $table->decimal('origin_latitude', 10, 7)->nullable();
            $table->decimal('origin_longitude', 10, 7)->nullable();
            $table->foreignId('shelter_id')->nullable()->constrained()->nullOnDelete();
            $table->string('destination_name');
            $table->decimal('destination_latitude', 10, 7)->nullable();
            $table->decimal('destination_longitude', 10, 7)->nullable();
            $table->json('route_coordinates')->nullable();
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->unsignedSmallInteger('estimated_minutes')->nullable();
            $table->enum('status', ['draft', 'active', 'closed'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['status', 'shelter_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evacuation_routes');
        Schema::dropIfExists('road_conditions');
        Schema::dropIfExists('evacuation_requests');
        Schema::dropIfExists('shelter_facilities');
        Schema::dropIfExists('shelters');
        Schema::dropIfExists('flood_report_photos');
        Schema::dropIfExists('flood_reports');
    }
};
