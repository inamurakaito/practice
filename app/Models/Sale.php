<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price', //購入時の価格を保存するために必要
    ];

    // 🔗 リレーション（1販売は1つの商品に属する）
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}