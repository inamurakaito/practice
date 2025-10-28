<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->unsignedBigInteger('product_id'); // 外部キー
            $table->timestamps(); // created_at, updated_at

            // 外部キー制約
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
