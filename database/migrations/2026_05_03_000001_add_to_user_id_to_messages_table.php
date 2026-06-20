<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('to_user_id')->nullable()->after('from_user_id')->constrained('users')->onDelete('cascade');
            // Alumni reply to admin-initiated messages
            $table->text('alumni_reply')->nullable()->after('admin_reply');
            $table->timestamp('alumni_replied_at')->nullable()->after('alumni_reply');
            $table->boolean('admin_read_reply')->default(false)->after('alumni_replied_at');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['to_user_id']);
            $table->dropColumn(['to_user_id', 'alumni_reply', 'alumni_replied_at', 'admin_read_reply']);
        });
    }
};
