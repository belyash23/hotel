<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(
            '
CREATE OR REPLACE VIEW positions_count AS  (
    SELECT
        name,
        (
            SELECT count(*)
            FROM (
                SELECT position_id
                FROM users
                WHERE positions.id = users.position_id

            ) as users_temp
        ) as count
    FROM positions
);
            '
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions_count');
    }
};
