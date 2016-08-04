<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Models\CashExpense;
use App\Http\Models\Expense;
use App\Http\Models\OutDetailTransaction;
use App\Http\Models\OutTransaction;
use App\Http\Models\Product;
use App\Http\Models\User;
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
            $reportData['totalExpenses'] = 0;
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
                        'user_name' => User::find($product->user_id)->name,
                        'quantity' => $transactionDetail->quantity,
                        'deal' => $transactionDetail->deal_price,
                        'capital' => $transactionDetail->capital_price
                    ]);
                }

            }

            // Get Expenses
            $expenses = Expense::whereDate('date', '=', Carbon::today()->toDateString())->get();
            foreach ($expenses as $expense) {
                $reportData['totalExpenses'] += $expense->price;
            }
            $reportData['expenses'] = $expenses;

            return view('report.daily', ['reportData' => $reportData]);


        } else
            redirect('/');
    }

    public function weeklyReport()
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            $reportData = [];
            $reportData['totalPenjualan'] = 0;
            $reportData['totalModal'] = 0;
            $reportData['totalPengeluaran'] = 0;
            $reportData['totalPendapatan'] = 0;
            $reportData['totalPengeluaranCash'] = 0;
            $reportData['details'] = [];
            $weekNumber = Carbon::today()->weekOfYear;
            $weeklyTransactions = OutTransaction::orderBy('date')->get()->groupBy(function ($item) {
                return Carbon::parse($item->date)->weekOfYear;
            });

            $weeklyExpenses = Expense::orderBy('date')->get()->groupBy(function ($item) {
                return Carbon::parse($item->date)->weekOfYear;
            });

            $weeklyCashExpenses = CashExpense::orderBy('date')->get()->groupBy(function ($item) {
                return Carbon::parse($item->date)->weekOfYear;
            });

            $dates = [];
            $dailyTransactions = [];
            $dailyExpenses = [];
            $dailyCashExpenses = [];

            if (isset($weeklyTransactions[$weekNumber])) {
                $dailyTransactions = collect($weeklyTransactions[$weekNumber])->groupBy(function ($item) {
                    return Carbon::parse($item->date)->toDateString();
                });
                foreach ($dailyTransactions as $date => $dailyTransaction) {
                    array_push($dates, $date);
                }
            }

            if (isset($weeklyExpenses[$weekNumber])) {
                $dailyExpenses = collect($weeklyExpenses[$weekNumber])->groupBy(function ($item) {
                    return Carbon::parse($item->date)->toDateString();
                });
                foreach ($dailyExpenses as $date => $dailyExpense) {
                    array_push($dates, $date);
                }
            }

            if (isset($weeklyCashExpenses[$weekNumber])) {
                $dailyCashExpenses = collect($weeklyCashExpenses[$weekNumber])->groupBy(function ($item) {
                    return Carbon::parse($item->date)->toDateString();
                });
                foreach ($dailyCashExpenses as $date => $dailyCashExpense) {
                    array_push($dates, $date);
                }
            }

            $dates = collect(array_unique($dates))->values()->toArray();
            asort($dates);

            foreach ($dates as $date) {
                $temp = [];
                $temp['totalPenjualan'] = 0;
                $temp['totalModal'] = 0;
                $temp['totalPengeluaran'] = 0;
                $temp['totalPengeluaranCash'] = 0;
                $temp['date'] = Carbon::parse($date)->format('d M Y');

                if (isset($dailyExpenses[$date])) {
                    $temp['totalPengeluaran'] = collect($dailyExpenses[$date])->sum('price');
                    $reportData['totalPengeluaran'] += collect($dailyExpenses[$date])->sum('price');
                }

                if (isset($dailyCashExpenses[$date])) {
                    $temp['totalPengeluaranCash'] = collect($dailyCashExpenses[$date])->sum('price');
                    $reportData['totalPengeluaranCash'] += collect($dailyCashExpenses[$date])->sum('price');
                }

                if (isset($dailyTransactions[$date])) {
                    foreach ($dailyTransactions[$date] as $transaction) {
                        $transactionDetails = OutDetailTransaction::where('transaction_id', $transaction->id)->get();
                        foreach ($transactionDetails as $transactionDetail) {

                            $temp['totalPenjualan'] += $transactionDetail->deal_price * $transactionDetail->quantity;
                            $temp['totalModal'] += $transactionDetail->capital_price * $transactionDetail->quantity;

                            $reportData['totalPenjualan'] += $transactionDetail->deal_price * $transactionDetail->quantity;
                            $reportData['totalModal'] += $transactionDetail->capital_price * $transactionDetail->quantity;

                        }
                    }
                }

                array_push($reportData['details'], $temp);

            }

            return view('report.weekly', ['reportData' => $reportData]);

        } else redirect('/');
    }

    public
    function monthlyReport()
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
