<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('cv_file')->nullable()->after('cover_letter');
            $table->string('portfolio_file')->nullable()->after('cv_file');
            $table->string('portfolio_link')->nullable()->after('portfolio_file');
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['cv_file', 'portfolio_file', 'portfolio_link']);
        });
    }
};