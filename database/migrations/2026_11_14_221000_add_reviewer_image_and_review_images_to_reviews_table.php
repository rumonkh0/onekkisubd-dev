<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'reviewer_image')) {
                $table->string('reviewer_image')->nullable()->after('review');
            }
            if (!Schema::hasColumn('reviews', 'review_images')) {
                $table->text('review_images')->nullable()->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'reviewer_image')) {
                $table->dropColumn('reviewer_image');
            }
            if (Schema::hasColumn('reviews', 'review_images')) {
                $table->dropColumn('review_images');
            }
        });
    }
};
