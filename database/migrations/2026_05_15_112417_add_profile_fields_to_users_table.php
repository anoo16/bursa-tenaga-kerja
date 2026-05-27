<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('role_id');
            }

            if (!Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('users', 'education')) {
                $table->string('education')->nullable()->after('birth_date');
            }

            if (!Schema::hasColumn('users', 'company_name')) {
                $table->string('company_name')->nullable()->after('education');
            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $columns = [];

            if (Schema::hasColumn('users', 'phone')) {
                $columns[] = 'phone';
            }

            if (Schema::hasColumn('users', 'birth_date')) {
                $columns[] = 'birth_date';
            }

            if (Schema::hasColumn('users', 'education')) {
                $columns[] = 'education';
            }

            if (Schema::hasColumn('users', 'company_name')) {
                $columns[] = 'company_name';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }

        });
    }
};