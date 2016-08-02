<?php

namespace App\Http\Controllers;

use App\Http\Constants;
use App\Http\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class ExpenseController extends Controller
{
    public function index()
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            $expenses = Expense::orderBy('date', 'desc')->get();

            return view('expense.index', ['expenses' => $expenses]);

        } else {
            return redirect('/');
        }
    }

    public function create(Request $request)
    {
        if (Auth::user() && Auth::user()->role == Constants::ROLE_ADMIN) {
            try {

                DB::beginTransaction();

                $expense = Expense::create([
                    'date' => $request['date'],
                    'price' => $request['price'],
                    'description' => $request['description'],
                ]);

                DB::commit();

                return redirect('/expense');
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

                $id = $request['id'];

                Expense::destroy($id);

                DB::commit();

                return redirect('/expense');
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
                    'id' => 'required',
                    'date' => 'required',
                    'price' => 'required',
                    'description' => 'required'
                ]);

                $id = $request['id'];
                $date = $request['date'];
                $price = $request['price'];
                $description = $request['description'];

                $expense = Expense::find($id);

                if (!$expense) {
                    abort(403);
                }

                $expense->date = $date;
                $expense->price = $price;
                $expense->description = $description;
                $expense->save();

                DB::commit();

                return redirect('/expense');
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }
}
