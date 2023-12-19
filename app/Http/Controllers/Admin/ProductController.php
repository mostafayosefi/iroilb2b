<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\ProductCollection;
use App\Models\Admin\Product;

class ProductController extends Controller
{

    // add product admin
    public function store(Request $request)
    {
        $product = new Product([
            'name_fa' => $request->get('product')['nameFa'],
            'name_en' => $request->get('product')['nameEn'],
            'slug' => $request->get('product')['slug']
        ]);
        $product->save();
        return response()->json('success', 200);
    }

    // show product user
    public function index()
    {
        $product = new ProductCollection(Product::all());
        if ($product->count() == 0) {
            return response()->json('null', 200);
        } else {
            return $product;
        }
    }

    // get admin product
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product, 200);
    }

    // update admin product
    public function update($id, Request $request)
    {
        $product = Product::find($id);
        $product->name_fa = $request->get('product')['nameFa'];
        $product->name_en = $request->get('product')['nameEn'];
        $product->slug = $request->get('product')['slug'];
        $product->save();
        return response()->json('successfully updated', 200);
    }

    // delete admin product
    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json('successfully deleted', 200);
    }

}
