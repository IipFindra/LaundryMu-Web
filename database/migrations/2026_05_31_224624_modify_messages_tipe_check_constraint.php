<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the old check constraint and recreate it to include 'chat_admin'
        DB::statement("ALTER TABLE messages DROP CONSTRAINT IF EXISTS messages_tipe_check");
        DB::statement("ALTER TABLE messages ADD CONSTRAINT messages_tipe_check CHECK (tipe IN ('chat_pelanggan', 'broadcast', 'sistem', 'chat_admin'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the old check constraint
        DB::statement("ALTER TABLE messages DROP CONSTRAINT IF EXISTS messages_tipe_check");
        DB::statement("ALTER TABLE messages ADD CONSTRAINT messages_tipe_check CHECK (tipe IN ('chat_pelanggan', 'broadcast', 'sistem'))");
    }
};
