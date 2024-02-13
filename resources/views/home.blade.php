@extends('layouts.layout')

@section('title')
    Уральский светотехнический завод
@endsection

@php
    $forGrid = [
        '1' => 'Уличные светильники',
        'Промышленные светильники',
        'Офисные светильники',
        'Парковые опоры (светильники)',
        'Кронштейны и закладные',
        'Асуно, it-разработка ПО',
        'Светофорные комплексы',
        'Мобильное освещение',
        'Архитектурная подсветка',
    ];
    $ourWorks = $data['oworks'];
    $letters = $data['letters'];
@endphp

@section('body')
    <div class="cover-wrapper">
        <div class="d-flex flex-column centering">
            <img src="{{ asset('imgs/sitecover.jpg') }}" alt="" class="cover">
        </div>
        <div class="blur centering">
            <div class="logos text-light">
                <div class="fullogo">
                    <img src="{{ asset('imgs/fullogo.svg') }}" alt="">
                </div>
                <p>Мы дарим людям свет</p>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    {{-- Микро каталог --}}

    <div class="mini-catalogue">
        <h1 class="bblue-text text-center lt-up lt-bold">
            Большой выбор товаров
        </h1>
        <div class="grid-ctlg">
            @foreach ($forGrid as $key => $item)
                <a href="{{ route('shop', ['category' => $key]) }}">
                    @csrf
                    <div class="category-card">
                        <div class="logo-ctg bg-bindigo centering">
                            <img src="{{ asset('imgs/logos/' . $key . '.svg') }}" alt="">
                        </div>
                        <div class="category-name bgray-text text-center lt-up">
                            {!! $item !!}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="divider"></div>

    <br>

    <div class="w80 d-flex">
        <div class="guy no-matter">
            <img src="imgs/services.png" alt="">
        </div>
        <div class="d-flex flex-column">
            <h1 class="bindigo-text lt-up lt-bold m-2">
                Уcлуги
            </h1>
            <span class="bgray-text m-2">
                Наша компания предоставляет широкий спектр услуг. Составление документации, проведение энергосервисных,
                монтажных и геодезических работ. Ознакомиться с полным списком услуг вы можете на соответствующей
                странице.
            </span>
            <div>
                <a href="" class="btn btn-primary text-light bg-bindigo lt-up m-2">
                    К каталогу услуг →
                </a>
            </div>
            <br>
        </div>
    </div>

    {{-- Наши работы --}}

    <div class="divider"></div>
    <br>

    <div class="w80 d-flex flex-wrap justify-content-between align-items-center">
        <h1 class="bindigo-text lt-bold lt-up">
            Наши работы
        </h1>

        @auth
            @if (auth()->user()->role < 3)
                    <form action="{{ @route('OWnew') }}" method="post">
                        @csrf
                        <button class="btn btn-primary m-2">Добавить проект</button>
                    </form>
            @endif
        @endauth
    </div>

    @if (!$ourWorks->isEmpty())
        <div class="d-flex flex-column align-items-center w80">
            @foreach ($ourWorks as $ourWork)
                @php
                    $link = $ourWork->cover === 'default.png' ? 'imgs/default.png' : 'storage/imgs/our_works/covers/' . $ourWork->cover;
                @endphp
                <div class="d-flex flex-wrap justify-content-around align-items-center w-100 m-2">
                    <div class="OWcover centering">
                        <img src="{{ asset($link) }}" alt="">
                    </div>
                    <div class="m-2 d-flex flex-wrap flex-column w60">
                        <h3 class="bgray-text lt-bold lt-up">
                            {{ $ourWork->name }}
                        </h3>
                        <div class="bgray-text lt-thin">
                            {{ $ourWork->year }}
                        </div>
                        <br>
                        <div class="bgray-text">
                            {!! strlen($ourWork->description) < 200 ? $ourWork->description : substr($ourWork->description, 0, 150) . '...' !!}
                        </div>
                        <br>
                        <a href="{{ route('OWview', ['id' => $ourWork->id]) }}"><button class="btn btn-primary">Подробнее
                                →</button></a>
                    </div>
                </div>
                <br>
            @endforeach
        </div>
    @endif

    <br>

    <div class="divider"></div>

    <br>

    <div class="w80 d-flex flex-wrap justify-content-between align-items-center">
        <h1 class="lt-bold lt-up bindigo-text">Благодарственные письма</h1>
        @auth
            @if (auth()->user()->role < 3)
                    <form action="{{ @route('letterNew') }}" method="post">
                        @csrf
                        <button class="btn btn-primary m-2">Добавить письмо</button>
                    </form>
            @endif
        @endauth
    </div>

    <div class="w80 d-flex justify-content-start flex-wrap letters-wrapper">
        @foreach ($letters as $letter)
            <div class="letter-wrapper">
                <img src="{{ asset('storage/imgs/letter_scans/' . $letter->image) }}" alt="Письмо от {{ $letter->from }}" title="Письмо от {{ $letter->from }}"
                    class="letter">
                @auth
                    @if (auth()->user()->role < 3)
                        <div class="letter-hover d-flex flex-column centering">
                            <form action="{{ route('letterDel', ['id' => $letter->id]) }}" method="post">
                                @csrf
                                <button class="btn btn-danger">Удалить письмо</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        @endforeach
    </div>
    <br>

    <div class="divider"></div>
    {{-- Вакансии --}}
    <br>

    <div class="w80 d-flex ">
        <div class="d-flex flex-column">
            <h1 class="bindigo-text lt-up lt-bold m-2">
                ВАКАНСИИ
            </h1>
            <span class="bgray-text m-2">
                Корпоративная связь, софинансирование абонементов в фитнес – клуб (Leo Fit), система накопления
                персональных дней (1 день в год), отсутствие обязательного dress-code, книжный клуб (библиотека),
                ДМС
                (подбор сети клиник, оптимального корпоративного тарифа) по согласованию, софинансирование авиа- и
                ж/д-билетов в отпуск по РФ по согласованию.
            </span>
            <h1 class="bindigo-text lt-up lt-bold m-2">
                СЕЙЧАС ИЩЕМ:
            </h1>
            <ul class="bgray-text lt-bold wewant m-2">
                <li>Монатжника</li>
                <li>Высотника</li>
                <li>Сотника</li>
                <li>Прапорщика</li>
            </ul>
            <br>
        </div>
        <div class="guy no-matter">
            <img src="imgs/vacancies.png" alt="">
        </div>
    </div>
@endsection
