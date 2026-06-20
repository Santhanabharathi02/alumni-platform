<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('admin');
            }

            if (!Schema::hasColumn('users', 'alumni_id')) {
                $table->unsignedBigInteger('alumni_id')->nullable();
            }
        });

        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                try {
                    $table->foreign('alumni_id')->references('id')->on('alumnis')->nullOnDelete();
                } catch (\Throwable $e) {
                    // Ignore if the foreign key already exists or cannot be added.
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'alumni_id')) {
                try {
                    $table->dropForeign(['alumni_id']);
                } catch (\Throwable $e) {
                    // Ignore when the foreign key does not exist.
                }

                $table->dropColumn('alumni_id');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
