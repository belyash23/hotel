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
CREATE OR REPLACE VIEW hotel_free_rooms_count AS  (
    SELECT
        h.name as hotel_name,
        count(r.*)
    FROM hotels h
    LEFT JOIN rooms r ON r.hotel_id = h.id
    WHERE r.is_free = TRUE
    GROUP BY hotel_name
);
            '
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_free_rooms_count');
    }
};
