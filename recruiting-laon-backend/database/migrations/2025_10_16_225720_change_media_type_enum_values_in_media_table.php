<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('media')->where('media_type', 'media')->update(['media_type' => 'movie']);

        Schema::table('media', function (Blueprint $table) {
            Schema::table('media', function (Blueprint $table) {
                $table->enum('media_type', ['movie', 'tv-serie'])
                    ->default('movie')
                    ->after('tmdb_id')
                    ->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('media')->where('media_type', 'movie')->update(['media_type' => 'media']);

        Schema::table('media', function (Blueprint $table) {
            $table->enum('media_type', ['media', 'tv-serie'])
                  ->default('media')
                  ->change();
        });
    }
};
