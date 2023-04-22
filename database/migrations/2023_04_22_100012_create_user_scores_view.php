<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW 'user_scores' AS
            SELECT
                id,
                name,
                score,
                DENSE_RANK() OVER (ORDER BY score DESC) AS rank
            FROM (
                SELECT
                    u.id AS id,
                    u.name AS name,
                    (
                        SELECT
                            COUNT(*)
                        FROM
                            games g
                        WHERE
                            g.user_id = u.id
                            AND g.status = 'WON') AS score
                FROM
                    users u);
                ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS 'user_scores';");
    }
};
