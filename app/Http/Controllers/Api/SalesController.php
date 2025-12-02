<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    /**
     * 購入処理API
     */
    public function purchase(Request $request)
    {
        // product_id の存在チェック
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        // 商品取得
        $product = Product::find($request->product_id);

        // 在庫チェック
        if ($product->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => '在庫が0のため購入できません。',
            ], 400);
        }

        // 売上追加（salesテーブルへ登録）
        Sale::create([
            'product_id' => $product->id,
        ]);

        // 在庫数を1減らす
        $product->stock -= 1;
        $product->save();

        // 成功レスポンス
        return response()->json([
            'success' => true,
            'message' => '購入が正常に完了しました！',
            'product_id' => $product->id,
            'stock_after' => $product->stock,
        ], 200);
    }
}