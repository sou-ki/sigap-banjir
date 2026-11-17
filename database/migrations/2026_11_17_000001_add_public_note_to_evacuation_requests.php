<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evacuation_requests', function (Blueprint $table) {
            $table->text('public_note')->nullable()->after('additional_information');
        });
    }

    public function down(): void
    {
        Schema::table('evacuation_requests', function (Blueprint $table) {
            $table->dropColumn('public_note');
        });
    }
};
