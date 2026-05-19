<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'approval_status')) {
                $table->string('approval_status')->default('approved')->after('is_verified');
            }

            if (!Schema::hasColumn('users', 'rejected_reason')) {
                $table->text('rejected_reason')->nullable()->after('approval_status');
            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'rejected_reason')) {
                $table->dropColumn('rejected_reason');
            }

            if (Schema::hasColumn('users', 'approval_status')) {
                $table->dropColumn('approval_status');
            }

        });
    }
};