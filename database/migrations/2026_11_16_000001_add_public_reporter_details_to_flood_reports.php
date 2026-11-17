<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flood_reports', function (Blueprint $table) {
            $table->string('reporter_name')->nullable()->after('user_id');
            $table->string('contact_phone', 30)->nullable()->after('reporter_name')->index();
            $table->string('flow_condition', 30)->nullable()->after('water_level_cm');
        });
    }

    public function down(): void
    {
        Schema::table('flood_reports', function (Blueprint $table) {
            $table->dropIndex(['contact_phone']);
            $table->dropColumn(['reporter_name', 'contact_phone', 'flow_condition']);
        });
    }
};
