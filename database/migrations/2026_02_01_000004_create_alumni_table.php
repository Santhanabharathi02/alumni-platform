<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->unsignedInteger('graduation_year')->nullable();
            $table->string('degree')->nullable();
            $table->string('department')->nullable();
            $table->string('company')->nullable();
            $table->string('job_title')->nullable();
            $table->string('location')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->text('bio')->nullable();
            $table->date('last_contacted_at')->nullable();
            $table->boolean('is_mentor')->default(false);
            $table->boolean('available_for_internships')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
