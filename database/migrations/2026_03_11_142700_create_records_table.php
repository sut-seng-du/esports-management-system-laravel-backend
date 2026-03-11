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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('seat')->nullable();
            $table->string('member_ID')->nullable();
            $table->decimal('member_amount', 8, 2)->nullable();
            $table->text('order')->nullable();
            $table->decimal('order_amount', 8, 2)->nullable();
            $table->decimal('total', 8, 2);
            $table->boolean('paid');
            $table->boolean('online');
            $table->decimal('debt', 8, 2)->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('modified_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
