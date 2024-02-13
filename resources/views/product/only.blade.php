@extends('layouts.layout')

@section('title')
    {{ $product->name }}
@endsection

@php
    switch ($product->ProductMedia()->count()) {
        case 0:
            $link = 'imgs/default.png';
            break;
        case 1:
            $link = 'storage/imgs/products/' . $product->cover;
            break;

        default:
            break;
    }
    $link = $product->ProductMedia()->count() === 0 ? 'imgs/default.png' : 'storage/imgs/products/' . $product->cover;
    $active = ' active';
    // dd($product->productMedia->all())
@endphp

@section('body')
    <div class="divider"></div>

    @auth
        @if (auth()->user()->role < 2)
            <br>
            <div class="d-flex flex-wrap centering">
                <form action="{{ @route('productEdit', ['id' => $product->id]) }}" method="post">
                    @csrf
                    <button class="btn btn-secondary m-2">Редактировать товар</button>
                </form>
                <form action="{{ @route('productDelete', ['id' => $product->id]) }}" method="post">
                    @csrf
                    <button class="btn btn-danger m-2">Удалить товар</button>
                </form>
            </div>

            <br>

            <div class="divider"></div>
        @endif
    @endauth
    <br>
    <br>

    <div class="w80">
        <div class="d-flex flex-wrap about-product flex-wrap centering justify-content-around">
            @if ($link)
                <div class="product-cover m-2 d-flex align-items-center justify-content-center">
                    <img src="{{ asset($link) }}" alt="Изображение продукта">
                </div>
            @endif
            <div class="product-text d-flex flex-wrap flex-column m-2">
                <h1 class="lt-bold lt-up bindigo-text">{{ $product->name }}</h1>

                @if ($product->description != null)
                    <span class="m-2">{!! $product->description !!}</span>
                @endif
                @if ($product->cost !== null)
                    <h4 class="m-2">{{ $product->cost }}₽</h4>
                @endif
                @auth
                    <form action="{{ @route('addToCart', ['id' => $product->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-primary m-2">Добавить в корзину</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>

    <br>
    <br>
    <div class="divider"></div>
    <br>
    <br>
    <div class="text-info">
        <br>
        @if ($product->advantages != null)
            <div class="w60">
                <h1 class="lt-bold lt-up bindigo-text">Преимущества:</h1>
                <span class="m-2 bgray-text">{!! $product->advantages !!}</span>
            </div>
        @endif
        @if ($product->usability != null)
            <div class="w60">
                <h1 class="lt-bold lt-up bindigo-text">Применение:</h1>
                <span class="m-2 bgray-text">{!! $product->usability !!}</span>
            </div>
        @endif
        @if ($product->parameters != null)
            <div class="w60">
                <h1 class="lt-bold lt-up bindigo-text">Характеристики:</h1>
                <span class="m-2 bgray-text">{!! $product->parameters !!}</span>
            </div>
        @endif
    </div>
    <br>
    <div class="w60">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                @foreach ($product->productMedia as $productMedia)
                    <div class="carousel-item{{ $active }}">
                        <div class="carousel-item-iwrapper">
                            <img class="d-block w-100" src="{{ asset('storage/imgs/products/' . $productMedia->image) }}"
                                alt="{{ $productMedia->image }}">
                        </div>
                    </div>
                    @php
                        $active = null;
                    @endphp
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <br>
@endsection
