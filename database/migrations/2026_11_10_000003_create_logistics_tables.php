<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('name');
            $table->string('category')->nullable();
            $table->decimal('quantity', 12, 2)->default(0);
            $table->string('unit', 40);
            $table->string('source')->nullable();
            $table->string('storage_location')->nullable();
            $table->date('received_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->string('condition')->nullable();
            $table->foreignId('responsible_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('contributed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['category', 'name']);
        });

        Schema::create('logistics_needs', function (Blueprint $table) {
            $table->id();
            $table->string('need_number')->unique();
            $table->string('location');
            $table->foreignId('flood_report_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('shelter_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category')->nullable();
            $table->string('item_name');
            $table->decimal('quantity_required', 12, 2);
            $table->decimal('quantity_allocated', 12, 2)->default(0);
            $table->string('unit', 40);
            $table->enum('urgency', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->unsignedInteger('people_affected')->nullable();
            $table->text('description')->nullable();
            $table->string('information_source')->nullable();
            $table->enum('status', ['open', 'partially_fulfilled', 'fulfilled', 'cancelled'])->default('open');
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reported_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'urgency']);
        });

        Schema::create('relief_allocations', function (Blueprint $table) {
            $table->id();
            $table->string('allocation_number')->unique();
            $table->foreignId('stock_item_id')->constrained()->restrictOnDelete();
            $table->foreignId('logistics_need_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('shelter_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('quantity', 12, 2);
            $table->enum('status', ['requested', 'approved', 'rejected', 'dispatched', 'received', 'cancelled'])
                ->default('requested');
            $table->foreignId('allocated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });

        Schema::create('relief_distributions', function (Blueprint $table) {
            $table->id();
            $table->string('distribution_number')->unique();
            $table->foreignId('relief_allocation_id')->constrained()->restrictOnDelete();
            $table->string('origin');
            $table->string('destination');
            $table->decimal('quantity_sent', 12, 2);
            $table->decimal('quantity_received', 12, 2)->nullable();
            $table->string('responsible_team')->nullable();
            $table->enum('status', ['prepared', 'in_transit', 'delivered', 'confirmed', 'cancelled'])->default('prepared');
            $table->foreignId('prepared_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['status', 'shipped_at']);
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_item_id')->constrained()->restrictOnDelete();
            $table->enum('movement_type', ['received', 'dispatched', 'adjustment']);
            $table->decimal('quantity', 12, 2);
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('relief_distributions');
        Schema::dropIfExists('relief_allocations');
        Schema::dropIfExists('logistics_needs');
        Schema::dropIfExists('stock_items');
    }
};
