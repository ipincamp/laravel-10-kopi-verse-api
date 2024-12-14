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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('barcode')->unique()->nullable();
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            /**
             * wait   : Order is created but not paid yet.
             * prep   : Order is being prepared.
             * ready  : Order is ready to be delivered.
             * done   : Order is delivered.
             * cancel : Order is canceled.
             */
            $table->enum('status', ['wait', 'prep', 'ready', 'done', 'cancel'])->default('wait');
            $table->decimal('total', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
