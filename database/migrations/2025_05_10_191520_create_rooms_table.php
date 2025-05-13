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
CREATE TABLE rooms (
    id serial NOT NULL,
    num integer NOT NULL,
    description text,
    count integer NOT NULL CHECK (count > 0),
    cost integer NOT NULL,
    status TEXT CHECK (status IN (\'repair\', \'ready\')) DEFAULT \'ready\',
    hotel_id integer REFERENCES hotels (id) ON DELETE CASCADE,
    is_free boolean NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id)
)
            '
        );

        DB::statement(
            '
CREATE INDEX ON rooms (hotel_id);
            '
        );

        DB::statement(
            '
CREATE INDEX ON rooms (status);
            '
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
