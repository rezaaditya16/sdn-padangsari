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
            // Remove teaching-related columns
            $table->dropColumn([
                'teaching_schedule',
                'class_attendance_logs',
                'classes_attended',
                'classes_scheduled',
                'teaching_completion_rate'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Restore teaching-related columns
            $table->json('teaching_schedule')->nullable();
            $table->json('class_attendance_logs')->nullable();
            $table->integer('classes_attended')->default(0);
            $table->integer('classes_scheduled')->default(0);
            $table->decimal('teaching_completion_rate', 5, 2)->default(0);
        });
    }
};
