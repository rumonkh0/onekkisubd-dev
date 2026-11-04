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
            if (!Schema::hasColumn('campaigns', 'step_title')) {
                $table->string('step_title')->nullable()->after('description');
            }
            if (!Schema::hasColumn('campaigns', 'step_one')) {
                $table->text('step_one')->nullable()->after('step_title');
            }
            if (!Schema::hasColumn('campaigns', 'step_two')) {
                $table->text('step_two')->nullable()->after('step_one');
            }
            if (!Schema::hasColumn('campaigns', 'step_three')) {
                $table->text('step_three')->nullable()->after('step_two');
            }
            if (!Schema::hasColumn('campaigns', 'step_four')) {
                $table->text('step_four')->nullable()->after('step_three');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $columns = [];
            foreach (['step_title', 'step_one', 'step_two', 'step_three', 'step_four'] as $col) {
                if (Schema::hasColumn('campaigns', $col)) {
                    $columns[] = $col;
                }
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
