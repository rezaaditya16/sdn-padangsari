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
        Schema::table('complaint_responses', function (Blueprint $table) {
            $table->json('attachments')->nullable()->after('message');
            $table->enum('action_type', ['response', 'status_update', 'completion'])->default('response')->after('attachments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaint_responses', function (Blueprint $table) {
            $table->dropColumn(['attachments', 'action_type']);
        });
    }
};
