<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable();
            }

            if (!Schema::hasColumn('users', 'summary')) {
                $table->text('summary')->nullable();
            }

            if (!Schema::hasColumn('users', 'location')) {
                $table->string('location')->nullable();
            }

            if (!Schema::hasColumn('users', 'headline')) {
                $table->string('headline')->nullable();
            }

            if (!Schema::hasColumn('users', 'experience')) {
                $table->text('experience')->nullable();
            }

            if (!Schema::hasColumn('users', 'skills')) {
                $table->text('skills')->nullable();
            }

            if (!Schema::hasColumn('users', 'certification')) {
                $table->text('certification')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'photo',
                'summary',
                'location',
                'headline',
                'experience',
                'skills',
                'certification'
            ]);

        });
    }
};