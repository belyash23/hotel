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
CREATE OR REPLACE VIEW popular_rooms AS  (
    SELECT
        r.num,
        r.description,
        r.count,
        r.cost,
        count(b.*) as bookings_number,
        rank() OVER (ORDER BY (count(b.*)) DESC) AS rank
    FROM bookings b
    RIGHT JOIN rooms r
        ON r.id = b.room_id
    GROUP BY r.num, r.description, r.count, r.cost
    ORDER BY rank
)
            '
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('popular_rooms_view');
    }
};
