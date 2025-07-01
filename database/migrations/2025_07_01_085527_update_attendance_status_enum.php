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
            // Change status enum to include 'absent'
            $table->enum('status', ['hadir', 'tidak_hadir', 'absent'])->default('tidak_hadir')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Revert to original enum
            $table->enum('status', ['hadir', 'tidak_hadir'])->default('tidak_hadir')->change();
        });
    }
};
