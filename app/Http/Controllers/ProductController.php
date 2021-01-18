<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function addProduct(Request $request){
        $product = $request->validate([
            'product_name' => 'required|string',
            'product_desc' => 'required|string',
            'product_category' => 'required|string',
            'product_image' => 'required|string'
        ]);

        Product::create($product);

        return response(['product' => $product],201);
    }

    public function allProducts(Request $request){
        $products = Product::all();

        return response(['products' => $products]);
    }

    public function deleteProduct(Request $request){
        
        $id = $request->id; 
        $deleted_product = Product::where('id',$id)->delete();

        return response(['deleted' => $deleted_product]);
    }
}
