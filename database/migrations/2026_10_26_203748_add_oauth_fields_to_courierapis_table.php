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
        Schema::table('courierapis', function (Blueprint $table) {
            $table->string('username')->nullable()->after('url');
            $table->text('password')->nullable()->after('username');
            $table->text('refresh_token')->nullable()->after('token');
            $table->timestamp('token_expires_at')->nullable()->after('refresh_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courierapis', function (Blueprint $table) {
            $table->dropColumn(['username', 'password', 'refresh_token', 'token_expires_at']);
        });
    }
};
