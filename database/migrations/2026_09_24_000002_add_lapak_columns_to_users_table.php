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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_lapak')->nullable()->after('kategori_layanan');
            $table->string('no_wa')->nullable()->after('nama_lapak');
            $table->boolean('lapak_buka')->default(true)->after('no_wa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama_lapak', 'no_wa', 'lapak_buka']);
        });
    }
};