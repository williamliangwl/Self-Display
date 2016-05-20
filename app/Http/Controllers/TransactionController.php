<?php

namespace App\Http\Controllers;

use App\Http\Models\DetailTransaction;
use App\Http\Models\Product;
use App\Http\Models\Transaction;
use App\Http\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Log;
use DB;

class TransactionController extends Controller
{

    public function getAll(Request $request)
    {
        $transactions = Transaction::all();
        $data = [];

        foreach ($transactions as $transaction) {
            $tempData = [];
            $tempData['transaction_id'] = $transaction->id;
            $tempData['transaction_date'] = $transaction->date;
            $tempData['transaction_user_name'] = User::find($transaction->user_id)->name;
            $tempData['transaction_total'] = 0;
            $tempData['transaction_details'] = [];

            $transactionDetails = DetailTransaction::where('transaction_id', $transaction->id)->get();
            foreach ($transactionDetails as $transactionDetail) {
                $product = Product::find($transactionDetail->product_id);
                $tempData['transaction_total'] += $product->price*$transactionDetail->quantity;
                array_push($tempData['transaction_details'],[
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'product_quantity' => $transactionDetail->quantity,
                ]);
            }

            array_push($data, $tempData);
        }

        return view('transaction', ['transactions' => $data]);
    }

    public function create(Request $request)
    {
        try {

            DB::beginTransaction();

            $transaction = Transaction::create([
                'user_id' => 1,
                'date' => date('YmdHis')
            ]);

            $detailTransaction = DetailTransaction::create([
                'transaction_id' => $transaction->id,
                'product_id' => $request['product_id'],
                'quantity' => $request['quantity']
            ]);

            $product = Product::find($detailTransaction->product_id);
            if (!$product)
                abort(403);
            $product->stock -= $detailTransaction->quantity;
            $product->save();

            DB::commit();

        } catch (\Exception $e) {
            Log::info($e->getTraceAsString());
            DB::rollback();
            return $e->getMessage();
        }
        return redirect('/');
    }

}
