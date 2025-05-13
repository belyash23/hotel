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
CREATE TABLE hotels (
    id serial NOT NULL,
    name text NOT NULL,
    inn text NOT NULL UNIQUE,
    director_id integer,
    owner_id integer,
    address text NOT NULL,
    PRIMARY KEY (id)
)
            '
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
