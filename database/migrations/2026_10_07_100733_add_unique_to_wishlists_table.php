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
        // Remove duplicate wishlist rows before adding unique index
        $duplicates = DB::table('wishlists')
            ->select('user_id', 'property_id', DB::raw('MIN(id) as keep_id'))
            ->groupBy('user_id', 'property_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $dup) {
            DB::table('wishlists')
                ->where('user_id', $dup->user_id)
                ->where('property_id', $dup->property_id)
                ->where('id', '!=', $dup->keep_id)
                ->delete();
        }

        Schema::table('wishlists', function (Blueprint $table) {
            $table->unique(['user_id', 'property_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'property_id']);
        });
    }
};
