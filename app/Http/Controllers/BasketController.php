<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    //
    public function getBasket()
    {
        $basket = Basket::join('products', 'baskets.product_id', '=', 'products.id')
            ->join('statuses', "baskets.status", "=", "statuses.id")
            ->select('baskets.id', 'baskets.product_id', 'products.name', 'products.cost', 'statuses.name as status')
            ->where('orderer_id', Auth::user()->id)
            ->get();

        return view('basket.list', compact('basket'));
    }
    public function addToCart(Request $request)
    {

        Basket::create([
            'product_id' => $request->id,
            'orderer_id' => auth()->user()->id,
            'status' => 1
        ]);

        return redirect()->route('seeProduct', ['id' => $request->id]);
    }

    public function payBasket(Request $request)
    {
        $balance = Auth::user()->balance;
        $basket = Basket::join('products', 'baskets.product_id', '=', 'products.id')
            ->select('products.cost as product_cost')
            ->where('orderer_id', Auth::user()->id)
            ->where('status', '1')
            ->get();


        $totalCost = 0;
        foreach ($basket as $order) {
            $totalCost = $totalCost + $order->product_cost;
        }

        // dd($totalCost);

        if ($balance >= $totalCost) {
            Auth::user()
                ->update([
                    'balance' => $balance - $totalCost
                ]);

            Basket::where('status', 1)
                ->update(['status' => 2]);

            Order::create([
                'track_number' => 'TRCK_' . time(),
                'price' => $totalCost,
                'monetized' => 0,
                'orderer_id' => Auth::user()->id
            ]);

            return redirect()->route('cart')->with('success', 'Оплата завершена');
        }

        return redirect()->route('cart')->with('error', 'Оплата не завершена');
    }

    public function basketExclude(Request $request)
    {
        $product = DB::table("baskets")->where('id', $request->id)->delete();

        return redirect()->route("cart");
    }

    public function getOrder(Request $request)
    {
        $product = Basket::where('id', $request->id)->update(['status' => 3]);

        return redirect()->route("cart");
    }
}
