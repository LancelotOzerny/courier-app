<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcel_lockers', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('address');
            $table->timestamps();
        });

        Schema::create('locker_cells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcel_locker_id')->constrained()->cascadeOnDelete();
            $table->string('number');
            $table->timestamps();

            $table->unique(['parcel_locker_id', 'number']);
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('number')->unique();
            $table->foreignId('courier_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('parcel_locker_id')->constrained()->restrictOnDelete();
            $table->timestamp('courier_created_at');
            $table->string('status')->default('new');
            $table->timestamps();

            $table->index(['courier_id', 'courier_created_at']);
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });

        Schema::create('order_cells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('locker_cell_id')->constrained()->restrictOnDelete();
            $table->timestamps();

            $table->unique(['order_id', 'locker_cell_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_cells');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('locker_cells');
        Schema::dropIfExists('parcel_lockers');
    }
};
