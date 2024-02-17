<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostType;
use App\Models\Basket;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    //
    public function home()
    {
        $data = [];

        return view('home', compact('data'));
    }

    public function file($filePath)
    {
        // Проверяем, существует ли файл
        if (Storage::exists($filePath)) {
            // Получаем содержимое файла
            $fileContents = Storage::get($filePath);

            // Определяем MIME-тип файла
            $mimeType = Storage::mimeType($filePath);

            // Возвращаем ответ с файлом и его MIME-типом
            return response($fileContents)
                ->header('Content-Type', $mimeType);
        } else {
            // Если файл не найден, возвращаем 404 Not Found
            abort(404);
        }
    }

    public function viewPosts($ptype) {
        $ptype = PostType::select('id')->where('name', $ptype)->first()->id;

        $data['title'] = $ptype;
        $data['posts'] = Post::where('posts.post_type_id', $ptype)
        ->paginate(5);

        dd($data['posts']);

        return view('forGovernment', compact('data'));
    }

    public function basket()
    {
        $data['basket'] = Basket::join('products', 'baskets.product_id', '=', 'products.id')
            ->select('baskets.id', 'baskets.product_id', 'products.name', 'products.cost', 'baskets.count')
            ->where('orderer_id', Auth::user()->id)
            ->where('order', NULL)
            ->get();

        $data['orders'] = Order::where('orderer_id', '=', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('user.basket', compact('data'));
    }
}