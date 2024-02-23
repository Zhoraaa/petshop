<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function seeOrder(Request $request)
    {
        $track_number = $request->track_number;

        $data['order'] = Order::where('track_number', $track_number)->first();
        $data['OPList'] = Basket::join('products', 'baskets.product_id', '=', 'products.id')
            ->select('baskets.id', 'baskets.product_id', 'products.name', 'products.cost', 'baskets.count')
            ->where('orderer_id', Auth::user()->id)
            ->where('order', $data['order']->id)
            ->get();

        // dd($data['OPList']);

        return view('user.order', compact('data'));
    }

    public function getOrder(Request $request)
    {
        $product = Order::where('track_number', $request->track_number)->update(['status' => 3]);

        return redirect()->route("cart");
    }

    public function newOrder(Request $request)
    {
        if (count($request->toArray()) > 1) {
            $newOrderId = Order::insertGetId([
                'track_number' => 'TRCK_' . time(),
                'monetized' => 0,
                'orderer_id' => Auth::user()->id,
                'status' => 1,
            ]);

            foreach ($request->all() as $id => $chck) {
                if ($id !== '_token') {
                    Basket::where('id', $id)
                        ->where('orderer_id', Auth::user()->id)
                        ->update(['order' => $newOrderId]);
                }
            }
            return redirect()->route('cart')->with('success', 'Заказ сформирован');
        }
        return redirect()->route('cart')->with('error', 'Заказ не может быть пустым');

    }

    public function payOrder(Request $request)
    {
        $track_number = $request->track_number;

        $balance = Auth::user()->balance;
        $basket = Basket::join('products', 'baskets.product_id', '=', 'products.id')
            ->select('products.cost as product_cost', 'baskets.count as count')
            ->where('orderer_id', Auth::user()->id)
            ->get();

        $totalCost = 0;
        foreach ($basket as $bPoint) {
            $totalCost = $totalCost + $bPoint->product_cost * $bPoint->count;
        }

        if ($totalCost <= $balance) {
            User::where('id', Auth::user()->id)
                ->update([
                    'balance' => $balance - $totalCost
                ]);

            Order::where('track_number', $track_number)->update([
                'status' => 2
            ]);

            return redirect()->route('cart')->with('success', 'Заказ оплачен');
        } else {
            return redirect()->route('cart')->with('success', 'Недостаточно средств');
        }
    }
}
