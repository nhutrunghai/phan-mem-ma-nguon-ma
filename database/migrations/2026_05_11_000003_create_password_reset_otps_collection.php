<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $collection = DB::connection('mongodb')
            ->getDatabase()
            ->selectCollection('password_reset_otps');

        $collection->createIndex(['email' => 1], ['name' => 'password_reset_otps_email_index']);
        $collection->createIndex(
            ['expires_at' => 1],
            ['expireAfterSeconds' => 0, 'name' => 'password_reset_otps_expires_at_ttl']
        );
    }

    public function down(): void
    {
        $collection = DB::connection('mongodb')
            ->getDatabase()
            ->selectCollection('password_reset_otps');

        foreach (['password_reset_otps_email_index', 'password_reset_otps_expires_at_ttl'] as $index) {
            try {
                $collection->dropIndex($index);
            } catch (Throwable) {
                //
            }
        }
    }
};
