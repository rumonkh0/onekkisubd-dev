<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            DB::statement("ALTER TABLE `deposits` MODIFY `file` VARCHAR(255) NULL DEFAULT NULL;");
        } catch (\Throwable $e) {}

        try {
            DB::statement("ALTER TABLE `expenses` MODIFY `file` VARCHAR(255) NULL DEFAULT NULL;");
        } catch (\Throwable $e) {}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Nullable column change does not require rollback
    }
};
