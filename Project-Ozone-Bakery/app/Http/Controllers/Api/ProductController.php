<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::get();
        return $products;
    }

    public function store(Request $request) {
        $request->validate ([
            'name'      => 'required|min:3|max:256',
            'price'     => 'required|integer|min:0'
        ]);

        $product = new Product();
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->save();
        $product->refresh();
        return $product;
    }

    public function show(Product $product) {
        return $product;
    }

    public function destroy(Product $product) {
        $product->delete();
        return ["message" => "delete successfully"];
    }

    public function update(Request $request, Product $product) {
        $request->validate ([
            'name' => 'nullable|min:3|max:256',
            'price' => 'nullable|integer|min:0'
        ]);

        if ($request->has('name')) $product->name = $request->input('name');
        if ($request->has('price')) $product->price = $request->input('price');

        $product->save();
        $product->refresh();
        return $product;
    }
        
}