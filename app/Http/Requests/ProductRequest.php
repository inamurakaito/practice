<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    // 認可（true にする）
    public function authorize()
    {
        return true;
    }

    // バリデーションルール
    public function rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ];
    }

    // オリジナルメッセージ（日本語）
    public function messages()
    {
        return [
            'product_name.required' => '商品名は必ず入力してください。',
            'product_name.max' => '商品名は255文字以内で入力してください。',
            'company_id.required' => 'メーカーを選択してください。',
            'company_id.exists' => '選択されたメーカーが存在しません。',
            'price.required' => '価格を入力してください。',
            'price.integer' => '価格は数値で入力してください。',
            'price.min' => '価格は0以上で入力してください。',
            'stock.required' => '在庫数を入力してください。',
            'stock.integer' => '在庫数は数値で入力してください。',
            'stock.min' => '在庫数は0以上で入力してください。',
            'comment.max' => 'コメントは1000文字以内で入力してください。',
            'image.image' => 'アップロードできるのは画像ファイルのみです。',
            'image.mimes' => '画像はjpeg、png、jpg、gif形式で指定してください。',
            'image.max' => '画像サイズは10MB以下にしてください。',
        ];
    }
}