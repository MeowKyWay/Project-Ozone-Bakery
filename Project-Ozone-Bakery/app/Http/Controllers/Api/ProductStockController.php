<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class ProductStockController extends Controller
{
    public function index() {
        $productStocks = ProductStock::get();
        return $productStocks;
    }

    public function store(Request $request) {
        $request->validate ([
            'product_id'    => 'required|integer|exists:products,id',
            'amount'        => 'required|integer|min:1',
            'exp_date'      => 'required|date'
        ]);

        $productStock = new ProductStock();
        $productStock->product_id = $request->get('product_id');
        $productStock->amount = $request->get('amount');
        $productStock->exp_date = $request->get('exp_date');
        $productStock->save();
        $productStock->refresh();
        return $productStock;
    }

    public function show(ProductStock $productStock) {
        return $productStock;
    }

    public function destroy(ProductStock $productStock) {
        $productStock->delete();
        return ["message" => "delete successfully"];
    }

    public function update(Request $request, ProductStock $productStock) {
        $request->validate ([
            'product_id'    => 'nullable|integer|exists:products,id',
            'amount'        => 'nullable|integer|min:1',
            'exp_date'      => 'nullable|date'
        ]);

        if ($request->has('product_id')) $productStock->product_id = $request->get('product_id');
        if ($request->has('amount')) $productStock->amount = $request->get('amount');
        if ($request->has('exp_date')) $productStock->exp_date = $request->get('exp_date');

        $productStock->save();
        $productStock->refresh();
        return $productStock;
    }
}