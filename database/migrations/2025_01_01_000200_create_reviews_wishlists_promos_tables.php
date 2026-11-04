<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'hotel_id']);
        });

        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'hotel_id']);
        });

        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->string('type', 10)->default('percent'); // percent | fixed
            $table->unsignedBigInteger('value');
            $table->unsignedBigInteger('max_discount')->nullable(); // batas potongan untuk tipe persen
            $table->unsignedBigInteger('min_amount')->default(0);
            $table->unsignedInteger('max_uses')->nullable();
            $table->unsignedInteger('used')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('subtotal')->default(0)->after('method');
            $table->unsignedBigInteger('discount')->default(0)->after('subtotal');
            $table->string('promo_code')->nullable()->after('discount');
        });
    }

    public function down(): void
    {
        Schema::table('payments', fn (Blueprint $t) => $t->dropColumn(['subtotal', 'discount', 'promo_code']));
        Schema::dropIfExists('promos');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('reviews');
    }
};
