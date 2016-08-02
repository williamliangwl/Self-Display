<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Session;
use Auth;

class ProductController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            $products = Product::where('is_active', true)->orderBy('name')->get();

            switch (Auth::user()->role) {
                case Constants::ROLE_ADMIN:
                    return view('product.admin.index', ['products' => $products]);
                    break;
                case Constants::ROLE_BRANCH:
                    return view('product.branch.index', ['products' => $products]);
                    break;
                default:
                    abort(403);
                    break;
            }
        } else {
            return redirect('/');
        }
    }

    public function getAll()
    {
        if (Auth::user())
            return Product::where('is_active',true)->orderBy('name')->get();
        else
            return '';
    }

    public function create(Request $request)
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            try {

                DB::beginTransaction();

                $product = Product::create([
                    'name' => $request['name'],
                    'capital_price' => $request['capital_price'],
                    'stock' => $request['stock'],
                    'price' => $request['price'],
                    'is_active' => true
                ]);

                DB::commit();

                return redirect('/product');
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }

    public function delete(Request $request)
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            try {
                DB::beginTransaction();

                $id = $request['product_id'];

                $product = Product::find($id);
                $product->is_active = false;
                $product->save();

                DB::commit();

                return redirect('/product');
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }

    public function update(Request $request)
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            try {

                DB::beginTransaction();

                $this->validate($request, [
                    'product_id' => 'required',
                    'product_name' => 'required',
                    'product_price' => 'required',
                    'product_capital_price' => 'required',
                    'product_stock' => 'required'
                ]);

                $id = $request['product_id'];
                $name = $request['product_name'];
                $price = $request['product_price'];
                $stock = $request['product_stock'];
                $capital = $request['product_capital_price'];

                $product = Product::find($id);

                if (!$product) {
                    abort(403);
                }

                $product->name = $name;
                $product->price = $price;
                $product->stock = $stock;
                $product->capital_price = $capital;
                $product->save();

                DB::commit();

                return redirect('/product');
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }

    public function check()
    {
        if (Auth::user()) {
            return view('product.branch.check', ['products' => []]);
        }
    }
}
