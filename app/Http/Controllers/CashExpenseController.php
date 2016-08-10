<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Models\CashExpense;
use App\Http\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class CashExpenseController extends Controller
{
    public function index()
    {
        if (Auth::user()) {

            switch (Auth::user()->role) {
                case Constants::ROLE_BRANCH:
                    $expenses = CashExpense::where('user_id', Auth::user()->id)->orderBy('date', 'desc')->get();

                    return view('cash-expense.branch.index', ['expenses' => $expenses]);
                    break;
                case Constants::ROLE_ADMIN:
                    $expenses = CashExpense::orderBy('date', 'desc')->get()->groupBy('user_id');
                    $expensesMap = [];

                    foreach ($expenses as $userId => $expenseList) {
                        $user = User::find($userId);
                        $expensesMap[$user->name] = $expenseList;
                    }

                    return view('cash-expense.admin.index', ['expensesMap' => $expensesMap]);
                    break;
            }

        } else {
            return redirect('/');
        }
    }

    public function create(Request $request)
    {
        if (Auth::user()) {
            try {

                DB::beginTransaction();

                $expense = CashExpense::create([
                    'date' => $request['date'],
                    'price' => $request['price'],
                    'description' => $request['description'],
                    'user_id' => Auth::user()->id
                ]);

                DB::commit();

                return redirect('/cash-expense');
            } catch (\Exception $e) {
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

                CashExpense::destroy($id);

                DB::commit();

                return redirect('/cash-expense');
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }

    public function update(Request $request)
    {
        if (Auth::user()) {
            try {

                DB::beginTransaction();

                $this->validate($request, [
                    'id' => 'required',
                    'date' => 'required',
                    'price' => 'required',
                    'description' => 'required'
                ]);

                $id = $request['id'];
                $date = $request['date'];
                $price = $request['price'];
                $description = $request['description'];

                $expense = CashExpense::find($id);

                if (!$expense) {
                    abort(403);
                }

                $expense->date = $date;
                $expense->price = $price;
                $expense->description = $description;
                $expense->save();

                DB::commit();

                return redirect('/cash-expense');
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }
}
