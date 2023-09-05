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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('noInvoice');
            $table->foreignId('book_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->integer('price');
            $table->integer('status')->default(0)->comment('0 = belum bayar, 1 = sudah bayar, 2 = selesai, 3 = dibatalkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
