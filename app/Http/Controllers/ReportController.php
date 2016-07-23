<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Models\OutDetailTransaction;
use App\Http\Models\OutTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class ReportController extends Controller
{
    public function index()
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

            return view('report.index', ['reportData' => $reportData]);
        } else
            abort(403);
    }
}
