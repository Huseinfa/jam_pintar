<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tabel untuk tracking undangan feedback. Jawaban feedback disimpan di tabel `answers`
     * dengan filtering questions yang memiliki question_type = 'feedback'
     */
    public function up(): void
    {
        Schema::create('feedback_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('test_attempt_id')->constrained('test_attempts')->onDelete('cascade');
            $table->string('token')->unique();
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_invitations');
    }
};
