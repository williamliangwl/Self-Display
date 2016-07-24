<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Models\OutDetailTransaction;
use App\Http\Models\OutTransaction;
use App\Http\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class ReportController extends Controller
{
    public function dailyReport()
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {

            $reportData = [];
            $reportData['totalPenjualan'] = 0;
            $reportData['totalModal'] = 0;
            $reportData['details'] = [];
            $transactions = OutTransaction::whereDate('date', '=', Carbon::today()->toDateString())->get();

            foreach ($transactions as $transaction) {
                $transactionDetails = OutDetailTransaction::where('transaction_id', $transaction->id)->get();

                foreach ($transactionDetails as $transactionDetail) {

                    $product = Product::where('id', $transactionDetail->product_id)->first();

                    $reportData['totalPenjualan'] += $transactionDetail->deal_price * $transactionDetail->quantity;
                    $reportData['totalModal'] += $transactionDetail->capital_price * $transactionDetail->quantity;

                    array_push($reportData['details'], [
                        'name' => $product->name,
                        'quantity' => $transactionDetail->quantity,
                        'deal' => $transactionDetail->deal_price,
                        'capital' => $transactionDetail->capital_price
                    ]);
                }

            }

            return view('report.daily', ['reportData' => $reportData]);


        }
    }

    public function weeklyReport()
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            $reportData = [];
            $reportData['totalPenjualan'] = 0;
            $reportData['totalModal'] = 0;
            $reportData['details'] = [];
            $weekNumber = Carbon::today()->weekOfYear;
            $transactions = OutTransaction::orderBy('date')->get()->groupBy(function ($item) {
                return Carbon::parse($item->date)->weekOfYear;
            });

            if (isset($transactions[$weekNumber])) {
                foreach ($transactions[$weekNumber] as $transaction) {
                    $temp = [];
                    $temp['date'] = Carbon::parse($transaction->date)->format('d M y');
                    $temp['totalPenjualan'] = 0;
                    $temp['totalModal'] = 0;
                    $transactionDetails = OutDetailTransaction::where('transaction_id', $transaction->id)->get();

                    foreach ($transactionDetails as $transactionDetail) {

                        $reportData['totalPenjualan'] += $transactionDetail->deal_price * $transactionDetail->quantity;
                        $reportData['totalModal'] += $transactionDetail->capital_price * $transactionDetail->quantity;

                        $temp['totalPenjualan'] += $transactionDetail->deal_price * $transactionDetail->quantity;
                        $temp['totalModal'] += $transactionDetail->capital_price * $transactionDetail->quantity;
                    }

                    array_push($reportData['details'], $temp);

                }
            }

            return view('report.weekly', ['reportData' => $reportData]);
//            return $reportData;

//            foreach ($transactions as $transaction) {
//                if (Carbon::parse($transaction->date)->weekOfYear == $weekNumber) {
//                    $transactionDetails = OutDetailTransaction::where('transaction_id', $transaction->id)->get();
//
//                    foreach ($transactionDetails as $transactionDetail) {
//
//                        $product = Product::where('id', $transactionDetail->product_id)->first();
//
//                        $reportData['totalPenjualan'] += $transactionDetail->deal_price * $transactionDetail->quantity;
//                        $reportData['totalModal'] += $transactionDetail->capital_price * $transactionDetail->quantity;
//
//                        array_push($reportData['details'], [
//                            'name' => $product->name,
//                            'quantity' => $transactionDetail->quantity,
//                            'deal' => $transactionDetail->deal_price,
//                            'capital' => $transactionDetail->capital_price
//                        ]);
//                    }
//                }
//            }

        }
    }

    public function monthlyReport()
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {

            $reportData = [];
            $months = [];
            $transactions = OutTransaction::orderBy('date', 'desc')->get();

            foreach ($transactions as $transaction) {
                $month = Carbon::parse($transaction->date)->month;
                if (!in_array($month, $months)) {
                    array_push($months, $month);
                }
            }

            foreach ($months as $month) {
                $data = [];
                $data['month'] = $month;
                $data['details'] = [];

                foreach ($transactions as $transaction) {
                    $transactionDate = Carbon::parse($transaction->date);
                    $transactionDetails = OutDetailTransaction::where('transaction_id', $transaction->id)->get();

                    if ($transactionDate->month == $month) {
                        $found = false;
                        if (!empty($data['details'])) {
                            foreach ($data['details'] as $key => $value) {
                                if ($data['details'][$key]['date'] == $transactionDate->toFormattedDateString()) {
                                    foreach ($transactionDetails as $transactionDetail) {
                                        $data['details'][$key]['capital'] += $transactionDetail['capital_price'] * $transactionDetail['quantity'];
                                        $data['details'][$key]['deal'] += $transactionDetail['deal_price'] * $transactionDetail['quantity'];
                                    }
                                    $found = true;
                                }
                            }
                        }

                        if (!$found) {
                            $temp = [];
                            $temp['date'] = $transactionDate->toFormattedDateString();
                            $temp['capital'] = 0;
                            $temp['deal'] = 0;

                            foreach ($transactionDetails as $transactionDetail) {
                                $temp['capital'] += $transactionDetail['capital_price'] * $transactionDetail['quantity'];
                                $temp['deal'] += $transactionDetail['deal_price'] * $transactionDetail['quantity'];
                            }

                            array_push($data['details'], $temp);
                        }
                    }
                }

                array_push($reportData, $data);
            }

            return view('report.monthly', ['reportData' => $reportData]);
        } else
            abort(403);
    }
}
