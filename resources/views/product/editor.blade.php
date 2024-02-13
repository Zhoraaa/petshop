@extends('layouts.layout')

@section('title')
    Редактирование товара
@endsection



@section('body')
    <form action="{{ @route('productSave') }}" method="POST" enctype="multipart/form-data"
        class="border border-secondary rounded m-2 p-3 form-auth">
        @csrf
        @php
            $product = $data['product'];
            // dd($product);
            $selected = null;
        @endphp
        <input type="text" class="hide" name="product_id" value="{{ isset($product) ? $product->id : null }}">
        <div class="form-block-wrapper border border-secondary rounded">
            <input type="text" name="name" class="name-inp" placeholder="Наименование товара"
                value="{{ isset($product) ? $product->name : null }}">
        </div>
        <div class="form-block-wrapper border border-secondary rounded">
            <textarea name="description" class="tinyMCE" placeholder="Описание товара">
                {{ isset($product) ? $product->description : null }}
            </textarea>
        </div>
        <div class="form-block-wrapper border border-secondary rounded">
            <textarea name="advantages" class="tinyMCE" placeholder="Описание товара">
                {{ isset($product) ? $product->advantages : null }}
            </textarea>
        </div>
        <div class="form-block-wrapper border border-secondary rounded">
            <textarea name="usability" class="tinyMCE" placeholder="Описание товара">
                {{ isset($product) ? $product->usability : null }}
            </textarea>
        </div>
        <div class="form-block-wrapper border border-secondary rounded">
            <textarea name="parameters" class="tinyMCE" placeholder="Описание товара">
                {{ isset($product) ? $product->parameters : null }}
            </textarea>
        </div>
        <div class="form-block-wrapper border border-secondary rounded">
            <input type="number" name="cost" class="" placeholder="Цена товара"
                value="{{ isset($product) ? $product->cost : null }}">
        </div>
        <div class="form-block-wrapper border border-secondary rounded">
            <input type="file" name="images[]" multiple>
        </div>
        <div class="form-block-wrapper border border-secondary rounded">
            <select name="type" id="">
                <option value="" disabled>Выберите категорию</option>
                @foreach ($data['pTypes'] as $pType)
                    @if ($product != null)
                        @php
                            if ($pType['id'] == $product->type) {
                                $selected = 'selected';
                            }
                        @endphp
                    @endif
                    <option value="{{ $pType['id'] }}" {{ $selected }}>{{ $pType['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-block-wrapper">
            <button type="submit" class="btn btn-primary">Опубликовать</button>
        </div>
    </form>
@endsection
