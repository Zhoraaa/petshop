<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Http\Request;
class BasketController extends Controller
{
    //
    public function addToCart(Request $request)
    {
        $check = Basket::where([
            'product_id' => $request->id
        ])
            ->where([
                'orderer_id' => auth()->user()->id,
            ])
            ->first();

        // dd($check);

        if (!$check) {
            Basket::create([
                'product_id' => $request->id,
                'orderer_id' => auth()->user()->id,
                'count' => 1,
            ]);
        } else {
            Basket::where('id', $check->id)->update([
                'count' => $check->count + 1
            ]);
        }


        return redirect()->route('seeProduct', ['id' => $request->id]);
    }

}
