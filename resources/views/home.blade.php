@extends('layouts.layout')

@section('title')
    Зоомагазин
@endsection

@section('body')
    <div class="cover-wrapper">
        <div class="d-flex flex-column centering">
            <img src="{{ asset('imgs/sitecover.jpg') }}" alt="" class="cover">
        </div>
        <div class="blur centering">
            <div class="logos text-light">
                <div class="fullogo">
                    <img src="{{ asset('imgs/fullogo.png') }}" alt="">
                </div>
                <p>Питомцы тоже люди</p>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <br>

    <div class="w60 d-flex">
        <div class="guy no-matter">
            <img src="imgs/kitty.png" alt="">
        </div>
        <div class="d-flex flex-column">
            <h3 class="bindigo-text lt-up lt-bold m-2">
                Магазин для питомцев
            </h3>
            <span class="bgray-text m-2">
                Сеть магазинов PetShop специализируется на товарах для питомцев. У нас есть широкий выбор для всех пушистых,
                чешуйчатых и крылатых!
            </span>
            <a href="{{ route('shop') }}" class="m-2">
                <button class="btn btn-primary">К каталогу товаров</button>
            </a>
            <br>
        </div>
    </div>

    {{-- Программа --}}
    <div class="divider"></div>

    <br>

    <div class="w60 d-flex">
        <div class="d-flex flex-column">
            <h3 class="bindigo-text lt-up lt-bold m-2">
                Порадуйте питомца
            </h3>
            <span class="bgray-text m-2">
                Покупайте в розничных магазинах PetShop со скидкой до 30%!
            </span>
            <a href="https://www.google.com/maps/" class="m-2" target="_blank">
                <button class="btn btn-primary">Посмотреть ближайший магазин</button>
            </a>
            <br>
        </div>
        <div class="guy no-matter">
            <img src="imgs/puppy.png" alt="">
        </div>
    </div>
@endsection
