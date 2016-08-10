<?php

namespace App\Http\Controllers;

use App\Http\Models\Buyer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class BuyerController extends Controller
{
    public function get(Request $request)
    {
        if (Auth::user()) {

            $buyers = null;

            if (!empty($request['name']) && !empty($request['phone']))
                $buyers = Buyer::where('name', $request['name'])->where('phone', $request['phone'])->get();
            else if (!empty($request['name']))
                $buyers = Buyer::where('name', $request['name'])->get();
            else if (!empty($request['phone']))
                $buyers = Buyer::where('phone', $request['phone'])->get();


            if ($buyers != null && $buyers->count() == 1)
                return $buyers->first();
            else
                return null;
        } else
            abort(403);
    }

    public function getAll()
    {
        if (Auth::user()) {
            $buyers = Buyer::all();

            return $buyers;
        } else
            abort(403);
    }

    public function create(Request $request)
    {
        if (Auth::user()) {
            try {
                DB::beginTransaction();

                $buyer = Buyer::where('phone', $request['phone'])->first();

                if ($buyer == null) {
                    $buyer = Buyer::create([
                        'name' => $request['name'],
                        'phone' => $request['phone'],
                        'address' => $request['address']
                    ]);
                } else {
                    $buyer->name = $request['name'];
                    $buyer->address = $request['address'];
                    $buyer->save();
                }

                DB::commit();

                return $buyer->id;
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        } else
            abort(403);
    }
}
