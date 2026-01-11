<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sparepart_requests', function (Blueprint $table) {
            // Tambahkan kolom sparepart_id, sementara nullable untuk keamanan
            $table->unsignedBigInteger('sparepart_id')->nullable()->after('forklift_id');

            // Tambahkan foreign key
            $table->foreign('sparepart_id')
                  ->references('kode_sparepart')
                  ->on('spareparts')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('sparepart_requests', function (Blueprint $table) {
            $table->dropForeign(['sparepart_id']);
            $table->dropColumn('sparepart_id');
        });
    }
};
