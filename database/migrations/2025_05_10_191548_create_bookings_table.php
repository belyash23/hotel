<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
CREATE TABLE bookings (
    id serial NOT NULL,
    guest_id integer NOT NULL REFERENCES guests (id) ON DELETE CASCADE,
    room_id integer NOT NULL REFERENCES  rooms (id) ON DELETE CASCADE,
    arrival_date date NOT NULL,
    departure_date date NOT NULL,
    prepayment integer NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
)
            '
        );

        DB::statement(
            '
CREATE INDEX ON bookings (room_id);
            '
        );

        DB::statement(
            '
CREATE INDEX ON bookings (guest_id);
            '
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
