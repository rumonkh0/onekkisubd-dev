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
        Schema::table('campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('campaigns', 'compare_good_points')) {
                $table->longText('compare_good_points')->nullable()->after('compare_good_title');
            }
            if (!Schema::hasColumn('campaigns', 'compare_bad_points')) {
                $table->longText('compare_bad_points')->nullable()->after('compare_bad_title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (Schema::hasColumn('campaigns', 'compare_good_points')) {
                $table->dropColumn('compare_good_points');
            }
            if (Schema::hasColumn('campaigns', 'compare_bad_points')) {
                $table->dropColumn('compare_bad_points');
            }
        });
    }
};
