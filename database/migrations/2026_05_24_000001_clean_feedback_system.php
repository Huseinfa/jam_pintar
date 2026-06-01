<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ensure feedback_invitations table has all required columns
     */
    public function up(): void
    {
        Schema::table('feedback_invitations', function (Blueprint $table) {
            // Ensure reminder_sent_at exists (for tracking 1st reminder email)
            if (!Schema::hasColumn('feedback_invitations', 'reminder_sent_at')) {
                $table->timestamp('reminder_sent_at')->nullable()->after('email_sent_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_invitations', function (Blueprint $table) {
            if (Schema::hasColumn('feedback_invitations', 'reminder_sent_at')) {
                $table->dropColumn('reminder_sent_at');
            }
        });
    }
};
