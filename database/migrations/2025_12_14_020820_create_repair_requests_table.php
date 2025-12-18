<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('coordinator_id')->nullable()->constrained('users');
            $table->foreignId('technician_id')->nullable()->constrained('users');
            $table->foreignId('forklift_id')->nullable()->constrained();

            $table->text('deskripsi_awal');
            $table->string('jenis_kerusakan')->nullable();
            $table->string('prioritas')->nullable();

            $table->enum('status', [
                'DIAJUKAN',
                'DITUGASKAN',
                'SEDANG_DIKERJAKAN',
                'MENUNGGU_SPAREPART',
                'SELESAI'
            ])->default('DIAJUKAN');

            $table->timestamp('tanggal_diajukan')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repair_requests');
    }
};
