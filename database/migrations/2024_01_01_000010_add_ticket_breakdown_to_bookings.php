<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedSmallInteger('adult_qty')->default(0)->after('quantity');
            $table->unsignedSmallInteger('child_qty')->default(0)->after('adult_qty');
            $table->unsignedSmallInteger('group_qty')->default(0)->after('child_qty');
            $table->unsignedSmallInteger('infant_qty')->default(0)->after('group_qty');
        });

        // Expand enum to support 'infant' and 'mixed' ticket types
        DB::statement("ALTER TABLE bookings MODIFY COLUMN ticket_type ENUM('adult','child','group','infant','mixed') DEFAULT 'adult'");
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['adult_qty', 'child_qty', 'group_qty', 'infant_qty']);
        });
        DB::statement("ALTER TABLE bookings MODIFY COLUMN ticket_type ENUM('adult','child','group') DEFAULT 'adult'");
    }
};
