<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('nisn')->unique()->after('id');
            $table->date('birth_date')->after('name');
            $table->string('parent_email')->nullable()->after('photo'); // Tambahkan parent_email
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['nisn', 'birth_date', 'parent_email']);
        });
    }
};