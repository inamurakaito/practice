<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * 購入処理API（DBトランザクション対応）
     */
    public function purchase(Request $request)
    {
        // product_id の存在チェック
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = null;

        try {
            DB::transaction(function () use ($request, &$product) {

                // 行ロック付きで商品取得（同時購入対策）
                $product = Product::lockForUpdate()->find($request->product_id);

                // 万が一取得できなかった場合の保険
                if (!$product) {
                    throw new \Exception('商品が存在しません。');
                }

                // 在庫チェック
                if ($product->stock <= 0) {
                    throw new \Exception('在庫が0のため購入できません。');
                }

                // 売上追加（sales テーブル）
                Sale::create([
                    'product_id' => $product->id,
                ]);

                // 在庫を1減らす
                $product->decrement('stock');

                // 最新状態を取得
                $product->refresh();
            });

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => '商品情報が取得できませんでした。',
                ], 500);
            }

            return response()->json([
                'success'      => true,
                'message'      => '購入が正常に完了しました！',
                'product_id'   => $product->id,
                'stock_after'  => $product->stock,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
