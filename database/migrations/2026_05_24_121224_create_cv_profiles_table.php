<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel utama profil CV per user
        Schema::create('cv_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('job_title')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->text('summary')->nullable();
            $table->string('photo')->nullable();           // path foto
            $table->string('template_id')->default('modern'); // template yang dipilih
            $table->string('primary_color')->default('#1a3c8f');
            $table->timestamps();
        });

        // Tabel pengalaman kerja
        Schema::create('cv_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_profile_id')->constrained()->onDelete('cascade');
            $table->string('company');
            $table->string('position');
            $table->string('start_date');
            $table->string('end_date')->nullable();        // null = Present
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Tabel pendidikan
        Schema::create('cv_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_profile_id')->constrained()->onDelete('cascade');
            $table->string('institution');
            $table->string('degree');
            $table->string('field_of_study')->nullable();
            $table->string('start_year');
            $table->string('end_year')->nullable();
            $table->string('gpa')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Tabel keahlian/skill
        Schema::create('cv_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_profile_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('level')->default(80);          // 0-100 persen
            $table->string('category')->default('Technical'); // Technical / Soft Skill
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Tabel sertifikasi
        Schema::create('cv_certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_profile_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('issuer')->nullable();
            $table->string('year')->nullable();
            $table->string('credential_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Tabel template CV yang tersedia
        Schema::create('cv_templates', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();               // 'modern', 'classic', dll
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('preview_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_certifications');
        Schema::dropIfExists('cv_skills');
        Schema::dropIfExists('cv_educations');
        Schema::dropIfExists('cv_experiences');
        Schema::dropIfExists('cv_profiles');
        Schema::dropIfExists('cv_templates');
    }
};
