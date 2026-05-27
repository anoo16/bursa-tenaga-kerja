<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'npwp')) {
                $table->string('npwp', 30)
                    ->nullable()
                    ->after('company_name');
            }

            if (!Schema::hasColumn('users', 'npwp_file')) {
                $table->string('npwp_file')
                    ->nullable()
                    ->after('npwp');
            }

            if (!Schema::hasColumn('users', 'business_license_file')) {
                $table->string('business_license_file')
                    ->nullable()
                    ->after('npwp_file');
            }

            if (!Schema::hasColumn('users', 'pic_authorization_file')) {
                $table->string('pic_authorization_file')
                    ->nullable()
                    ->after('business_license_file');
            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'pic_authorization_file')) {
                $table->dropColumn('pic_authorization_file');
            }

            if (Schema::hasColumn('users', 'business_license_file')) {
                $table->dropColumn('business_license_file');
            }

            if (Schema::hasColumn('users', 'npwp_file')) {
                $table->dropColumn('npwp_file');
            }

            if (Schema::hasColumn('users', 'npwp')) {
                $table->dropColumn('npwp');
            }

        });
    }
};