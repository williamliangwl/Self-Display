<?php

namespace App\Http\Controllers;

use App\Http\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class ProductController extends Controller
{
    public function getAll()
    {
        $products = Product::all();
        return view('index', ['products' => $products]);
    }

    public function create(Request $request)
    {
        try {

            DB::beginTransaction();

            $product = Product::create([
                'name' => $request['name'],
                'price' => $request['price'],
                'stock' => $request['stock'],
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
        return redirect('/');
    }
}
