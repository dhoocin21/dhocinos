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
        Schema::table('site_logs', function (Blueprint $table) {
            $table->string('city')->nullable()->after('region')->index();
            $table->string('device_brand')->nullable()->after('user_agent');
            $table->string('os_platform')->nullable()->after('device_brand');
            $table->string('browser_name')->nullable()->after('os_platform');
            $table->integer('duration_seconds')->default(0)->after('browser_name')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_logs', function (Blueprint $table) {
            $table->dropColumn(['city', 'device_brand', 'os_platform', 'browser_name', 'duration_seconds']);
        });
    }
};
