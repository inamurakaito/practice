<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->unsignedBigInteger('company_id'); // 外部キー
            $table->string('product_name'); // 商品名（NOT NULL）
            $table->integer('price'); // 価格（NOT NULL）
            $table->integer('stock'); // 在庫数（NOT NULL）
            $table->text('comment')->nullable(); // コメント（NULL許可）
            $table->string('img_path')->nullable(); // 画像パス（NULL許可）
            $table->timestamps(); // 登録・更新日時

            // 外部キー制約
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
