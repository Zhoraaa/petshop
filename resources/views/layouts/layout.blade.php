<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ledplast - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('imgs/logo.svg') }}" type="image/x-icon">
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    {{-- TineMCE --}}
    <script src="https://cdn.tiny.cloud/1/uig2iyio5vvat8bnvd2319qa49zs1kp1ktl25x3q5u1l5og8/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.tinyMCE',
            language: 'ru',
            menubar: 'edit format insert view',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
    {{-- Local --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('imgs/logo.svg') }}" type="image/x-icon">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-bindigo lt-thin">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('imgs/logo.svg') }}" alt="Логотип" class="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Каталог
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-white hov-gray" href="{{ @route('shop') }}">Товары</a>
                        <a class="dropdown-item text-white hov-gray" href="#">Услуги</a>
                    </div>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Статьи
                    </a>
                    <div class="dropdown-menu active">
                        <a class="dropdown-item text-white hov-gray" href="{{ @route('delivery') }}">Доставка</a>
                        <a class="dropdown-item text-white hov-gray" href="#">Гарантия</a>
                        <a class="dropdown-item text-white hov-gray" href="{{ @route('viewPosts', ['ptype' => 'Госучреждениям']) }}">Госучреждениям</a>
                        <a class="dropdown-item text-white hov-gray" href="{{ @route('viewPosts', ['ptype' => 'Полезная информация']) }}">Полезная информация</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ @route('about') }}">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ @route('contacts') }}">Контакты</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ @route('auth') }}">Вход</a>
                    </li>
                @endguest
                @auth

                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            Пользователь
                        </a>
                        <div class="dropdown-menu active">
                            @if (auth()->user()->role === 1)
                                <a class="dropdown-item text-white hov-gray"
                                    href="{{ @route('usrRedaction') }}">Администрирование</a>
                            @endif
                            @if (auth()->user()->role < 3)
                                <a class="dropdown-item text-white hov-gray"
                                    href="{{ @route('forum') }}">Статьи</a>
                            @endif
                            <a class="dropdown-item text-white hov-gray" href="{{ @route('cart') }}">Корзина</a>
                            <a class="dropdown-item text-white hov-gray" href="{{ @route('user') }}">Личный кабинет</a>
                            <form action="{{ @route('logout') }}" method="POST">
                                @csrf
                                <button class="lt-thin bg-bindigo border-0 dropdown-item text-white hov-gray" href="#">Выход</button>
                            </form>

                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    @yield('body')

    <footer class="bg-bindigo lt-thin">
        <div class="ftr-wrapper w80">
            <div class="ftr-logo">
                <img src="{{ asset('imgs/fullestlogo.svg') }}" alt="">
            </div>
            <div class="ftr-info">
                <div class="list m-2">
                    <div class="l-point lt-bold">
                        <p>Сервисы</p>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="{{ route('shop') }}">Товары</a>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="">Услуги</a>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="">Электромонтаж</a>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="">АСУНО</a>
                    </div>
                </div>
                <div class="list m-2">
                    <div class="l-point lt-bold">
                        <p>Статьи</p>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="">Государственным<br>учреждениям</a>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="">Полезная<br>информация</a>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="">Наши работы</a>
                    </div>
                </div>
                <div class="list m-2">
                    <div class="l-point lt-bold">
                        <p>О нас</p>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="">Вакансии</a>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="">Контакты</a>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="">История<br>компании</a>
                    </div>
                    <div class="l-point lt-thin">
                        <a href="">Франшиза</a>
                    </div>
                </div>
                <div class="ftr-office-info m-2">
                    <p>г. Уфа, ул. Красина, д. 21</p>
                    <p>+7 347 266 06 78</p>
                    <p>info@ledplast.ru</p>
                    <p>ООО “Уральский светотехнический завод”, 2024</p>
                    <div class="ftr-soc-links lt-thin">
                        <a href=""><img src="{{ asset('imgs/vk.svg') }}" alt=""></a>
                        <a href=""><img src="{{ asset('imgs/tiktok.svg') }}" alt=""></a>
                        <a href=""><img src="{{ asset('imgs/YT.svg') }}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
