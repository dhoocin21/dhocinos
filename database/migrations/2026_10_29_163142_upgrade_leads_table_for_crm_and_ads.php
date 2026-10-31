<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->unsignedBigInteger('promo_id')->nullable()->change();
            $table->foreignId('car_id')->nullable()->after('promo_id')->constrained('cars')->nullOnDelete();
            $table->string('car_name')->nullable()->after('car_id');
            $table->string('lead_type')->default('consultation')->after('car_name'); // consultation, promo, trade_in, credit, test_drive, quotation
            $table->string('purchase_type')->nullable()->after('lead_type'); // cash, credit, trade_in
            $table->string('status')->default('new')->after('purchase_type'); // new, contacted, prospect, test_drive, spk, lost
            $table->text('notes')->nullable()->after('status');
            $table->string('utm_source')->nullable()->after('notes');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');
            $table->string('utm_term')->nullable()->after('utm_campaign');
            $table->string('gclid')->nullable()->after('utm_term');
            $table->string('ip_address', 45)->nullable()->after('gclid');
            $table->string('region')->nullable()->after('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['car_id']);
            $table->dropColumn([
                'car_id',
                'car_name',
                'lead_type',
                'purchase_type',
                'status',
                'notes',
                'utm_source',
                'utm_medium',
                'utm_campaign',
                'utm_term',
                'gclid',
                'ip_address',
                'region',
            ]);
        });
    }
};
