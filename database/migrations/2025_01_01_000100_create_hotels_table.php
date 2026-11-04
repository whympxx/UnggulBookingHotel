<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('location');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price'); // harga per malam (Rupiah)
            $table->decimal('rating', 2, 1)->default(0);
            $table->string('phone', 30)->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('facilities')->nullable();
            $table->string('status', 20)->default('active'); // active | inactive
            $table->timestamps();
        });

        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price_multiplier', 4, 2)->default(1);
            $table->unsignedInteger('total_rooms')->default(1);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('method', 10); // bca | qris | cod
            $table->unsignedBigInteger('amount');
            $table->string('reference')->nullable(); // nomor VA / ID transaksi QRIS
            $table->string('status', 20)->default('pending'); // pending | paid | expired | cancelled
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_type_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 30);
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedSmallInteger('nights');
            $table->unsignedTinyInteger('guests')->default(1);
            $table->unsignedBigInteger('price_per_night');
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('tax');
            $table->unsignedBigInteger('service_fee');
            $table->unsignedBigInteger('total');
            $table->text('special_requests')->nullable();
            $table->string('status', 20)->default('pending'); // pending | paid | confirmed | completed | cancelled
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('room_types');
        Schema::dropIfExists('hotels');
    }
};
