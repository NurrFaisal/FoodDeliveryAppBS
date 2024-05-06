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
        if (!Schema::hasTable('rider_locations')) {
            Schema::create('rider_locations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('rider_id');
                $table->string('lat');
                $table->string('long');
                $table->datetime('capture_time');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rider_locations');
    }
};
