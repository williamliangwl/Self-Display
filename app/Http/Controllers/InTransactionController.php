<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Models\InDetailTransaction;
use App\Http\Models\InTransaction;
use App\Http\Models\Product;
use App\Http\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class InTransactionController extends Controller
{
    public function getAll()
    {
        if (Auth::user()) {
            switch (Auth::user()->role) {
                case Constants::ROLE_ADMIN:
                    $inTransactions = InTransaction::all();
                    $data = [];

                    foreach ($inTransactions as $inTransaction) {
                        $tempData = [];
                        $tempData['transaction_id'] = $inTransaction->id;
                        $tempData['transaction_date'] = $inTransaction->date;
                        $tempData['transaction_user_name'] = User::find($inTransaction->user_id)->name;
                        $tempData['transaction_details'] = [];

                        $inTransactionDetails = InDetailTransaction::where('transaction_id', $inTransaction->id)->get();
                        foreach ($inTransactionDetails as $inTransactionDetail) {
                            $product = Product::find($inTransactionDetail->product_id);
                            array_push($tempData['transaction_details'], [
                                'product_name' => $product->name,
                                'product_quantity' => $inTransactionDetail->quantity,]);
                        }

                        array_push($data, $tempData);
                    }

                    return view('transaction.in.admin.index', ['transactions' => $data]);
                    break;
                case Constants::ROLE_BRANCH:
                    $products = Product::all();
                    return view('transaction.in.branch.index', ['products' => $products]);
                    break;
            }
        }
        else
            return redirect('/');
    }

    public function create(Request $request)
    {
        if (Auth::user()) {
            try {

                DB::beginTransaction();

                $inTransaction = InTransaction::create([
                    'user_id' => Auth::user()->id,
                    'date' => date('YmdHis')
                ]);

                $product = Product::where('name', $request['name'])->first();

                if (!$product) {
                    abort(403);
                }

                $inDetailTransaction = InDetailTransaction::create([
                    'transaction_id' => $inTransaction->id,
                    'product_id' => $product->id,
                    'quantity' => $request['stock']
                ]);

                $product->stock += $inDetailTransaction->quantity;
                $product->save();

                DB::commit();

                return $inTransaction->id;

            } catch (\Exception $e) {
                Log::info($e->getTraceAsString());
                DB::rollback();
                return $e->getMessage();
            }
        }
        else
            abort(403);
    }
}
