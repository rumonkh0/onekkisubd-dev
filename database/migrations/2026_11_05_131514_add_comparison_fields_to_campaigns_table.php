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
            $columns = [
                'compare_tag' => fn($t) => $t->string('compare_tag')->nullable()->after('step_four'),
                'compare_title' => fn($t) => $t->string('compare_title')->nullable()->after('compare_tag'),
                'compare_subtitle' => fn($t) => $t->text('compare_subtitle')->nullable()->after('compare_title'),
                'compare_good_title' => fn($t) => $t->string('compare_good_title')->nullable()->after('compare_subtitle'),
                'compare_good_1' => fn($t) => $t->text('compare_good_1')->nullable()->after('compare_good_title'),
                'compare_good_2' => fn($t) => $t->text('compare_good_2')->nullable()->after('compare_good_1'),
                'compare_good_3' => fn($t) => $t->text('compare_good_3')->nullable()->after('compare_good_2'),
                'compare_good_4' => fn($t) => $t->text('compare_good_4')->nullable()->after('compare_good_3'),
                'compare_bad_title' => fn($t) => $t->string('compare_bad_title')->nullable()->after('compare_good_4'),
                'compare_bad_1' => fn($t) => $t->text('compare_bad_1')->nullable()->after('compare_bad_title'),
                'compare_bad_2' => fn($t) => $t->text('compare_bad_2')->nullable()->after('compare_bad_1'),
                'compare_bad_3' => fn($t) => $t->text('compare_bad_3')->nullable()->after('compare_bad_2'),
                'compare_bad_4' => fn($t) => $t->text('compare_bad_4')->nullable()->after('compare_bad_3'),
            ];

            foreach ($columns as $columnName => $adder) {
                if (!Schema::hasColumn('campaigns', $columnName)) {
                    $adder($table);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $columnNames = [
                'compare_tag',
                'compare_title',
                'compare_subtitle',
                'compare_good_title',
                'compare_good_1',
                'compare_good_2',
                'compare_good_3',
                'compare_good_4',
                'compare_bad_title',
                'compare_bad_1',
                'compare_bad_2',
                'compare_bad_3',
                'compare_bad_4',
            ];

            foreach ($columnNames as $col) {
                if (Schema::hasColumn('campaigns', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
