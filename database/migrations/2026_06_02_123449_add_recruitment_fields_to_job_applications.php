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
        Schema::table('job_applications', function (Blueprint $table) {

        $table->timestamp('applied_at')
          ->nullable()
          ->after('status');

        $table->enum('stage', [
        'BARU',
        'INTERVIEW',
        'DITERIMA',
        'DITOLAK'
        ])->default('BARU');

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            //
        });
    }
};
