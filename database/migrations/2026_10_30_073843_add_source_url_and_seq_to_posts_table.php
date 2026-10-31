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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('seq')->nullable()->unique()->after('slug');
            $table->string('source_url')->nullable()->after('category');
            $table->string('source_name')->default('Hyundai Motors Indonesia')->after('source_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['seq', 'source_url', 'source_name']);
        });
    }
};
