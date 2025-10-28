<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    // 🔗 リレーション（1商品は1社に属する）
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // 🔗 リレーション（1商品に複数の販売履歴）
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}