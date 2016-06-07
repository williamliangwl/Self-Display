<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Models\OutDetailTransaction;
use App\Http\Models\Product;
use App\Http\Models\OutTransaction;
use App\Http\Models\User;
use PDF;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Log;
use DB;
use Auth;
use phpDocumentor\Reflection\DocBlock\Tag\AuthorTag;

class OutTransactionController extends Controller
{

    public function getAll()
    {
        if (Auth::user()) {
            switch (Auth::user()->role) {
                case Constants::ROLE_ADMIN:
                    $outTransactions = $this->getOutTransactions();

                    return view('transaction.out.admin.index', ['transactions' => $outTransactions]);
                    break;
                case Constants::ROLE_BRANCH:
                    $products = Product::where('stock','>',0)->get();
                    return view('transaction.out.branch.index', ['products' => $products]);
                    break;
            }
        } else
            return redirect('/');
    }

    public function getPrevious()
    {
        if (Auth::user()) {
            $outTransactions = $this->getOutTransactions('', Auth::user()->id);
            return view('transaction.out.branch.previous', ['transactions' => $outTransactions]);
        } else
            return redirect('/');
    }

    public function create(Request $request)
    {
        if (Auth::user()) {
            try {

                DB::beginTransaction();

                $outTransaction = OutTransaction::create([
                    'user_id' => Auth::user()->id,
                    'date' => date('YmdHis'),
                    'recipient' => $request['recipient']
                ]);

                foreach ($request['items'] as $item) {
                    $outDetailTransaction = OutDetailTransaction::create([
                        'transaction_id' => $outTransaction->id,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'deal_price' => Product::find($item['id'])->price,
                    ]);

                    $product = Product::find($outDetailTransaction->product_id);
                    if (!$product || $product->stock - $outDetailTransaction->quantity < 0)
                        throwException(new \Exception('Product not found or no stock available'));
                    $product->stock -= $outDetailTransaction->quantity;
                    $product->save();
                }

                DB::commit();

                return $outTransaction->id;

            } catch (\Exception $e) {
                Log::info($e->getTraceAsString());
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }

    public function report($transactionId)
    {
        if (Auth::user()) {
            $transaction = $this->getOutTransactions($transactionId);
            return PDF::loadView('transaction.out.report', ['transaction' => $transaction])->setPaper('a4', 'landscape')->stream('nota-'.$transactionId.'.pdf');
        }
        else
            return redirect('/');
    }

    private function getOutTransactions($id = '', $user_id = '')
    {
        $outTransactions = OutTransaction::where('id', $id)->orderBy('id', 'desc')->get();

        if (empty($id))
            $outTransactions = OutTransaction::orderBy('id', 'desc')->get();

        if (!empty($user_id))
            $outTransactions = OutTransaction::where('user_id', $user_id)->orderBy('id', 'desc')->get();

        $data = [];

        foreach ($outTransactions as $outTransaction) {
            $tempData = [];
            $tempData['transaction_id'] = $outTransaction->id;
            $tempData['transaction_date'] = $outTransaction->date;
            $tempData['transaction_recipient'] = $outTransaction->recipient;
            $tempData['transaction_user_name'] = User::find($outTransaction->user_id)->name;
            $tempData['transaction_total'] = 0;
            $tempData['transaction_total_text'] = '';
            $tempData['transaction_details'] = [];

            $outTransactionDetails = OutDetailTransaction::where('transaction_id', $outTransaction->id)->get();
            foreach ($outTransactionDetails as $outTransactionDetail) {
                $product = Product::find($outTransactionDetail->product_id);
                $tempData['transaction_total'] += $product->price * $outTransactionDetail->quantity;
                array_push($tempData['transaction_details'], [
                    'product_name' => $product->name,
                    'product_price' => $outTransactionDetail->deal_price,
                    'product_quantity' => $outTransactionDetail->quantity,
                ]);
            }
            $tempData['transaction_total_text'] = $this->getMoneyText($tempData['transaction_total']);

            array_push($data, $tempData);
        }
        return $data;
    }

    private function getMoneyText($money)
    {
        $satuan = [
            'Nol',
            'Satu',
            'Dua',
            'Tiga',
            'Empat',
            'Lima',
            'Enam',
            'Tujuh',
            'Delapan',
            'Sembilan',
            'Sepuluh'
        ];

        $ribuan = [
            'Miliar',
            'Juta',
            'Ribu',
            ''
        ];

        $divider = 1000000000;
        $ribuIndex = 0;
        $result = '';

        while ($divider > 0) {
            $left = floor($money / $divider);
            if ($left > 0) {
                // handle ratusan
                $divider2 = 100;
                while ($divider2 > 0) {
                    $left2 = floor($left / $divider2);
                    if ($left2 > 0) {
                        if ($divider2 == 100) {
                            if ($left2 == 1)
                                $result .= "Seratus";
                            else
                                $result .= $satuan[$left2] . " Ratus ";
                        } else if ($divider2 == 10) {
                            if ($left2 == 1) {
                                if ($left == 10)
                                    $result .= " Sepuluh ";
                                else if ($left == 11)
                                    $result .= "Sebelas";
                                else
                                    $result .= $satuan[$left - 10] . " Belas ";
                                break;
                            } else
                                $result .= $satuan[$left2] . " Puluh ";
                        } else {
                            $result .= $satuan[$left2];
                        }
                    }
                    $left %= $divider2;
                    $divider2 = floor($divider2 / 10);
                }
                $result .= ' ' . $ribuan[$ribuIndex] . ' ';
            }
            $money %= $divider;
            $divider = floor($divider / 1000);
            $ribuIndex++;
        }
        return $result;
    }
}
