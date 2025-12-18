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
        Schema::create('repairlogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_request_id')->constrained()->cascadeOnDelete(); //constrained() : Batasan secara default dan cascadeOnDelete() : Aksi Refrensial, jika record yang menjadi rujukan dari repair_request dihapus, maka semua record yang merujuk akan dihapus otomatis
            $table->foreignId('user_id')->constrained('users');
            $table->string('status');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('repairlogs');
    }
};
