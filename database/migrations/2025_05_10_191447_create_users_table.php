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
CREATE TABLE users (
    id serial NOT NULL,
    name text NOT NULL,
    inn text NOT NULL UNIQUE,
    position_id integer NOT NULL,
    hotel_id integer REFERENCES hotels (id),
    PRIMARY KEY (id),
    UNIQUE (inn)
)
            '
        );

        DB::statement(
            '
CREATE INDEX ON users (hotel_id);
            '
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
