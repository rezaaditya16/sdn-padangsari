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
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('check_out_time')->nullable()->after('check_in_time');
            $table->decimal('check_out_latitude', 10, 8)->nullable()->after('longitude');
            $table->decimal('check_out_longitude', 11, 8)->nullable()->after('check_out_latitude');
            $table->decimal('check_out_distance', 8, 2)->nullable()->after('check_out_longitude');
            $table->text('check_out_notes')->nullable()->after('notes');
            $table->integer('work_hours')->nullable()->after('check_out_notes'); // dalam menit
            $table->enum('work_status', ['incomplete', 'complete', 'overtime'])->default('incomplete')->after('work_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'check_out_time',
                'check_out_latitude',
                'check_out_longitude',
                'check_out_distance',
                'check_out_notes',
                'work_hours',
                'work_status'
            ]);
        });
    }
};
