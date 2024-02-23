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
                <h3 class="lt-bold lt-up bindigo-text">{{ $product->name }}</h3>

                @if ($product->description != null)
                    <span class="m-2">{!! $product->description !!}</span>
                @endif
                @if ($product->cost !== null)
                    <h4 class="m-2">{{ $product->cost }}₽</h4>
                @endif
                @auth

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Добавить в корзину
                    </button>
                @endauth
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ @route('addToCart', ['id' => $product->id]) }}" method="post" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление товара в корзину</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="count">Впишите количество необходимых товаров</label>
                        <input type="number" min="1" class="form-control" id="count" aria-describedby="count"
                            placeholder="0" name="count">
                        <small id="count" class="form-text text-muted">
                            Только натуральные целые числа.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button class="btn btn-primary m-2">Добавить в корзину</button>
                </div>
            </form>
        </div>
    </div>

    <br>
    <br>
    <div class="divider"></div>
    <br>
    <br>
    <div class="text-info">
        <br>
        @if ($product->more_inf != null)
            <div class="w60">
                <h3 class="lt-bold lt-up bindigo-text">Подробнее о товаре:</h3>
                <span class="m-2 bgray-text">{!! $product->more_inf !!}</span>
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
