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
use PDF;

class ReportController extends Controller
{
    public function dailyReport()
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {

            $data = [];
            $branches = User::where('role', Constants::ROLE_BRANCH)->where('is_active', true)->get();
            foreach ($branches as $branch) {

                $reportData = [];
                $reportData['totalPenjualan'] = 0;
                $reportData['totalModal'] = 0;
                $reportData['totalExpenses'] = 0;
                $reportData['details'] = [];
                $transactions = OutTransaction::whereDate('date', '=', Carbon::today()->toDateString())->where('user_id', $branch->id)->get();

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

                // Get Expenses
                $expenses = Expense::whereDate('date', '=', Carbon::today()->toDateString())->where('user_id', $branch->id)->get();
                foreach ($expenses as $expense) {
                    $reportData['totalExpenses'] += $expense->price;
                }
                $reportData['expenses'] = $expenses;

                $data[$branch->name] = $reportData;
            }

            return view('report.daily', ['data' => $data]);
        } else
            redirect('/');
    }

    public function weeklyReport()
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {

            $data = [];
            $branches = User::where('role', Constants::ROLE_BRANCH)->where('is_active', true)->get();
            foreach ($branches as $branch) {

                $reportData = [];
                $reportData['totalPenjualan'] = 0;
                $reportData['totalModal'] = 0;
                $reportData['totalPengeluaran'] = 0;
                $reportData['totalPendapatan'] = 0;
                $reportData['totalPengeluaranCash'] = 0;
                $reportData['details'] = [];
                $weekNumber = Carbon::today()->weekOfYear;
                $weeklyTransactions = OutTransaction::where('user_id', $branch->id)->orderBy('date')->get()->groupBy(function ($item) {
                    return Carbon::parse($item->date)->weekOfYear;
                });

                $weeklyExpenses = Expense::where('user_id', $branch->id)->orderBy('date')->get()->groupBy(function ($item) {
                    return Carbon::parse($item->date)->weekOfYear;
                });

                $weeklyCashExpenses = CashExpense::where('user_id', $branch->id)->orderBy('date')->get()->groupBy(function ($item) {
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
                $data[$branch->name] = $reportData;
            }

            return view('report.weekly', ['data' => $data]);

        } else redirect('/');
    }

    public function selectWeeklyReport()
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            $users = User::where('role', Constants::ROLE_BRANCH)->where('is_active', true)->get();
            return view('report.weekly-select', ['users' => $users]);
        }
    }

    public function downloadWeeklyReport($userId)
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {

//            $weekNumber = Carbon::today()->weekOfYear;
            $data = [];
            $weeklyTransactions = OutTransaction::where('user_id', $userId)->orderBy('date')->get()->groupBy(function ($item) {
                return Carbon::parse($item->date)->weekOfYear;
            });

            $weeklyExpenses = Expense::where('user_id', $userId)->orderBy('date')->get()->groupBy(function ($item) {
                return Carbon::parse($item->date)->weekOfYear;
            });

            $weeklyCashExpenses = CashExpense::where('user_id', $userId)->orderBy('date')->get()->groupBy(function ($item) {
                return Carbon::parse($item->date)->weekOfYear;
            });

            $weekNumbers = array_unique(collect(collect($weeklyCashExpenses->keys())->merge($weeklyTransactions->keys()))->merge($weeklyExpenses->keys())->values()->all());

            foreach ($weekNumbers as $weekNumber) {

                $reportData = [];
                $reportData['totalPenjualan'] = 0;
                $reportData['totalModal'] = 0;
                $reportData['totalPengeluaran'] = 0;
                $reportData['totalPendapatan'] = 0;
                $reportData['totalPengeluaranCash'] = 0;
                $reportData['details'] = [];


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

                $data[$weekNumber] = $reportData;
            }

            krsort($data);

            $user = User::find($userId);

//            return view('report.weekly-download', ['data'=>$data, 'user' => $user]);
            return PDF::loadView('report.weekly-download', ['data'=>$data, 'user' => $user])->setPaper('a4', 'portrait')->download('laporan-mingguan-' . $user->name . '.pdf');

        } else
            redirect('/');
    }
}
