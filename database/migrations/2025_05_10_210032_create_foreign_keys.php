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
ALTER TABLE hotels
    ADD FOREIGN KEY (owner_id) REFERENCES users (id);
            '
        );

        DB::statement(
            '
ALTER TABLE hotels
    ADD FOREIGN KEY (director_id) REFERENCES users (id);
            '
        );

        DB::statement(
            '
ALTER TABLE users
    ADD FOREIGN KEY (position_id) REFERENCES positions (id);
            '
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foreign_keys');
    }
};
