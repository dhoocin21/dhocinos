<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Quotations Table (Surat Penawaran Harga / SPH)
        if (!Schema::hasTable('quotations')) {
            Schema::create('quotations', function (Blueprint $table) {
                $table->id();
                $table->string('quotation_number')->unique();
                $table->string('customer_name');
                $table->string('customer_phone');
                $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
                $table->string('variant_name')->nullable();
                $table->decimal('otr_price', 15, 2);
                $table->decimal('discount', 15, 2)->default(0);
                $table->integer('dp_percent')->default(20);
                $table->decimal('dp_amount', 15, 2);
                $table->integer('tenor_months')->default(36);
                $table->decimal('monthly_installment', 15, 2);
                $table->string('insurance_type')->default('all_risk');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 2. Trade-Ins Table (Tukar Tambah)
        if (!Schema::hasTable('trade_ins')) {
            Schema::create('trade_ins', function (Blueprint $table) {
                $table->id();
                $table->string('customer_name');
                $table->string('customer_phone');
                $table->string('old_car_brand');
                $table->string('old_car_model');
                $table->integer('old_car_year');
                $table->string('old_car_transmission')->default('automatic');
                $table->integer('old_car_mileage')->nullable();
                $table->decimal('expected_price', 15, 2)->nullable();
                $table->decimal('appraisal_price', 15, 2)->nullable();
                $table->foreignId('interested_car_id')->nullable()->constrained('cars')->nullOnDelete();
                $table->enum('status', ['pending', 'inspected', 'negotiation', 'deal', 'cancelled'])->default('pending');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 3. Showroom Events Table (Event Dealer & Promo Countdown)
        if (!Schema::hasTable('showroom_events')) {
            Schema::create('showroom_events', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->dateTime('event_date');
                $table->string('start_time')->default('09:00');
                $table->string('end_time')->default('17:00');
                $table->string('location')->default('Dealer Resmi Hyundai Gowa HR Muhammad Surabaya');
                $table->text('description')->nullable();
                $table->json('promo_highlights')->nullable();
                $table->string('banner_image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('showroom_events');
        Schema::dropIfExists('trade_ins');
        Schema::dropIfExists('quotations');
    }
};
