<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Hapus kolom lama jika tidak sesuai
            $table->dropColumn(['name', 'email', 'phone']);

            // Tambahkan kolom baru
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade')->after('id');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->after('student_id');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null')->after('category_id');
            $table->string('title')->after('message'); // Pindahkan title setelah message
            $table->enum('status', ['Diajukan', 'Diproses', 'Selesai'])->default('Diajukan')->after('message');
            $table->timestamp('responded_at')->nullable()->after('status');
            $table->timestamp('completed_at')->nullable()->after('responded_at');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['student_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['assigned_to']);

            // Drop new columns
            $table->dropColumn(['student_id', 'category_id', 'assigned_to', 'title', 'status', 'responded_at', 'completed_at']);

            // Add back old columns if necessary (or remove them permanently if no longer used)
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
        });
    }
};