<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** 商品一覧表示 */
    public function index(Request $request)
    {
        $query = Product::with('company');

        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // 価格（下限〜上限）
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // 在庫数（下限〜上限）
        if ($request->filled('stock_min')) {
            $query->where('stock', '>=', $request->stock_min);
        }
        if ($request->filled('stock_max')) {
            $query->where('stock', '<=', $request->stock_max);
        }

        // ▼ ソート処理追加（Step8）
        $sort = $request->get('sort', 'id');      // ソート対象カラム
        $order = $request->get('order', 'desc');  // 昇順 or 降順
        $query->orderBy($sort, $order);
        $products = $query->get();
        $companies = Company::all();

        return view('products.index', compact('products', 'companies'));
    }

    /** Ajax版検索（非同期検索） */
    public function ajaxSearch(Request $request)
    {
        $query = Product::with('company');

        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // 価格（下限〜上限）
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // 在庫数（下限〜上限）
        if ($request->filled('stock_min')) {
            $query->where('stock', '>=', $request->stock_min);
        }
        if ($request->filled('stock_max')) {
            $query->where('stock', '<=', $request->stock_max);
        }

        // ▼ ソート処理追加（AJAX版）
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);
        $products = $query->get();

        return response()->json([
            'html' => view('products.partials.list', compact('products'))->render()
        ]);
    }

    /** 新規登録フォーム */
    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /** 登録処理 */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $data['img_path'] = $path;
            }

            Product::create($data);
            return to_route('products.index')->with('success', '商品を登録しました！');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => '登録に失敗しました: ' . $e->getMessage()]);
        }
    }

    /** 詳細 */
    public function show($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /** 編集フォーム */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    /** 更新処理 */
    public function update(ProductRequest $request, $id)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['img_path'] = $path;
        }

        $product = Product::findOrFail($id);
        $product->update($data);

        return to_route('products.index')->with('success', '商品情報を更新しました！');
    }

    /** 削除処理（Ajax対応） */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            // Ajax削除用にJSONで返す
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}