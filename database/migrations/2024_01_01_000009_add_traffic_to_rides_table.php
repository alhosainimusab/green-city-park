<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->enum('traffic_level', ['low', 'medium', 'high'])->nullable()->after('status');
            $table->unsignedSmallInteger('wait_time')->nullable()->comment('minutes')->after('traffic_level');
        });
    }

    public function down(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->dropColumn(['traffic_level', 'wait_time']);
        });
    }
};
