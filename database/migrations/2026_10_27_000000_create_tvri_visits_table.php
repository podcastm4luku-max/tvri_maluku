<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Log kunjungan nyata untuk statistik pengunjung real-time.
     */
    public function up(): void
    {
        Schema::create('tvri_visits', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_hash', 64)->index();
            $table->date('visit_date')->index();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tvri_visits');
    }
};
