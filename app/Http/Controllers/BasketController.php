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
            ->where([
                'order' => NULL
            ])
            ->first();

        if (!$check) {
            Basket::create([
                'product_id' => $request->id,
                'orderer_id' => auth()->user()->id,
                'count' => $request->count,
            ]);
        } else {
            Basket::where('id', $check->id)->update([
                'count' => $check->count + $request->count
            ]);
        }

        return redirect()->route('seeProduct', ['id' => $request->id]);
    }

    public function delFromCart($id) {
        $del = Basket::find($id)->delete();

        return redirect()->route('cart')->with('success', 'Товар успешно удалён из вашей корзины');
    }
}
