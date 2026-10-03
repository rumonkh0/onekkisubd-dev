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
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'postal_code')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('postal_code', 20)->nullable()->after('city');
            });
        }

        if (Schema::hasTable('shippings') && !Schema::hasColumn('shippings', 'postal_code')) {
            Schema::table('shippings', function (Blueprint $table) {
                $table->string('postal_code', 20)->nullable()->after('address');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'postal_code')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('postal_code');
            });
        }

        if (Schema::hasTable('shippings') && Schema::hasColumn('shippings', 'postal_code')) {
            Schema::table('shippings', function (Blueprint $table) {
                $table->dropColumn('postal_code');
            });
        }
    }
};
