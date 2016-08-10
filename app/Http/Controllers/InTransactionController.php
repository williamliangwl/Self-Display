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
use Log;

class InTransactionController extends Controller
{
    public function getAll()
    {
        if (Auth::user()) {
            switch (Auth::user()->role) {
                case Constants::ROLE_ADMIN:
                    $transactions = $this->getInTransactions();
                    return view('transaction.in.admin.index', ['transactions' => $transactions]);
                    break;
                case Constants::ROLE_BRANCH:
                    $products = Product::where('is_active', true)->orderBy('name')->get();
                    return view('transaction.in.branch.index', ['products' => $products]);
                    break;
            }
        } else
            return redirect('/');
    }

    public function getPrevious()
    {
        if (Auth::user()) {
            $inTransactions = $this->getInTransactions(Auth::user()->id);
            return view('transaction.in.branch.previous', ['transactions' => $inTransactions]);
        } else
            return redirect('/');
    }

    public function create(Request $request)
    {
        if (Auth::user()) {
            try {

                DB::beginTransaction();

                $this->validate($request, [
                    'stock' => 'required',
                    'name' => 'required_without:id'
                ]);

                $inTransaction = InTransaction::create([
                    'user_id' => Auth::user()->id,
                    'date' => date('YmdHis')
                ]);

                if (!isset($request['id']) || empty($request['id']))
                    $product = Product::where('name', $request['name'])->where('user_id', Auth::user()->id)->first();
                else
                    $product = Product::find($request['id']);

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
        } else
            abort(403);
    }

    public function delete(Request $request)
    {
        if (Auth::user()) {
            try {

                DB::beginTransaction();

                $id = $request['id'];

                $inTransaction = InTransaction::find($id);
                $inDetailTransactions = InDetailTransaction::where('transaction_id', $inTransaction->id)->get();

                foreach ($inDetailTransactions as $inDetailTransaction) {
                    $product = Product::find($inDetailTransaction->product_id);
                    if (!$product)
                        throwException(new \Exception('Product not found or no stock available'));
                    $product->stock -= $inDetailTransaction->quantity;
                    $product->save();
                    InDetailTransaction::destroy($inDetailTransaction->id);
                }
                InTransaction::destroy($inTransaction->id);

                DB::commit();

                if (Auth::user()->role == Constants::ROLE_BRANCH)
                    return redirect()->action('InTransactionController@getPrevious');
                else if (Auth::user()->role == Constants::ROLE_ADMIN)
                    return redirect()->action('InTransactionController@getAll');


            } catch (\Exception $e) {
                Log::info($e->getTraceAsString());
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }

    public function getInTransactions($user_id = '')
    {
        $inTransactions = InTransaction::orderBy('date', 'desc')->get();

        if (!empty($user_id))
            $inTransactions = InTransaction::where('user_id', $user_id)->orderBy('date', 'desc')->get();

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

        return $data;
    }
}
