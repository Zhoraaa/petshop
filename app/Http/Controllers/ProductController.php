<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    public function productSave(Request $request)
    {
        function loadMedia($imgs, $product_id)
        {
            $counter = 1;
            foreach ($imgs as $image) {
                $fileName = time() . '_' . $counter . '.' . $image->extension();
                $imagePath = $image->storeAs('public/imgs/products', $fileName);
                ProductMedia::create([
                    'product_id' => $product_id,
                    'image' => $fileName
                ]);
                $counter++;
            }
        }

        if (!$request->product_id) {
            // dd($request->images);
            // Новый товар
            $product_id = Product::insertGetId([
                'name' => $request->name,
                'description' => $request->description,
                'parameters' => $request->parameters,
                'advantages' => $request->advantages,
                'usability' => $request->usability,
                'cost' => $request->cost,
                'type' => $request->type
            ]);

            if ($request->hasFile('images') && is_array($request->file('images'))) {
                loadMedia($request->images, $product_id);
            }
        } else {
            // dd($request->images);
            // Обновление
            $update['updated_at'] = null;
            if ($request->hasFile('images') && is_array($request->file('images'))) {
                $oldFiles = ProductMedia::select('image')->where('product_id', $request->product_id)->get();

                foreach ($oldFiles as $oldFile) {
                    $filePath = 'public/imgs/products/' . $oldFile->image;
                    if (Storage::exists($filePath)) {
                        Storage::delete($filePath);
                    }
                    ProductMedia::where('product_id', $request->product_id)->delete();
                }

                loadMedia($request->images, $request->product_id);
            }

            $toUPD = $request->toArray();
            $product = Product::find($request->product_id);
            // dd($toUPD);
            $testing = $product->toArray();

            foreach ($testing as $key => $item) {
                switch ($key) {
                    case 'id':
                    case 'image':
                    case 'created_at':
                    case 'updated_at':
                        break;
                    default:
                        if ($toUPD[$key] != $item) {
                            $update[$key] = $toUPD[$key];
                        }
                        break;
                }
            }

            // dd($update);

            $product->update($update);
            $product_id = $request->product_id;
        }

        return redirect()->route('seeProduct', ['id' => $product_id]);
    }

    public function allProducts(Request $request)
    {

        function takeData($query)
        {
            $data['products'] = $query->with('productMedia')->get();
            $data['count'] = $query->count();
            // dd($data['products'][0]->cover);

            return $data;
        }

        if (!$request->filled('_token') && !$request->filled('category')) {
            $query = Product::join('product_types', 'products.type', 'product_types.id')->select('products.*', 'product_types.name as products.category');

            $title = 'Все товары';
        } elseif ($request->filled('category')) {
            $query = Product::where('type', $request->category);

            $titleRaw = ProductType::select('name')->where('id', $request->category)->get()->toArray();
        } else {
            $types = array_keys($request->except('_token', 'order_by', 'sequence'));

            $query = Product::whereIn('type', $types)
            ->orderBy($request->order_by, $request->sequence);

            $titleRaw = ProductType::select('name')->whereIn('id', $types)->get()->toArray();
        }

        if (isset($titleRaw)) {
            $title = '';
            foreach ($titleRaw as $tr_tmp) {
                $title .= $tr_tmp['name'] . ', ';
            }
            $title = substr($title, 0, -2);
        }

        $data = takeData($query);

        $types = ProductType::all();

        $data += [
            'types' => $types,
        ];

        $data += [
            'title' => $title,
        ];
        
        // dd($title);

        return view("product.list", compact("data"));
    }
    public function seeProduct($id)
    {
        $product = Product::where("id", $id)->with('productMedia')->first();

        // dd($product);

        return view("product.only", compact("product"));
    }
    public function productEditor(Request $request)
    {
        $product = Product::find($request->id);
        $pTypes = ProductType::get()->all();

        $data = [
            'product' => $product,
            'pTypes' => $pTypes
        ];
        // dd($data);

        return view("product.editor", compact('data'));
    }
    public function productDelete(Request $request)
    {
        // dd($request->id);
        $oldFiles = ProductMedia::select('image')->where('product_id', $request->id)->get();

        foreach ($oldFiles as $oldFile) {
            $filePath = 'public/imgs/products/' . $oldFile->image;
            // dd($filePath);
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            ProductMedia::where('product_id', $request->id)->delete();
        }

        $product = DB::table("products")->where('id', $request->id)->delete();

        return redirect()->route("shop");
    }
}
