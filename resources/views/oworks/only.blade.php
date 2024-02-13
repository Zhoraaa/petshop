@extends('layouts.layout')

@section('title')
    {{ $data->name }}
@endsection

@section('body')
    @auth
        @if (auth()->user()->role < 3)
            <div class="divider"></div>
            <br>
            <div class="centering">
                <form action="{{ route('OWedit', ['id' => $data->id]) }}" class="m-2">
                    @csrf
                    <button class="btn btn-secondary">
                        Редактировать
                    </button>
                </form>

                <form action="{{ route('OWdelete', ['id' => $data->id]) }}" class="m-2">
                    @csrf
                    <button class="btn btn-danger">
                        Удалить
                    </button>
                </form>
            </div>
            <br>
        @endif
    @endauth
    <div class="divider"></div>
    <br>
    <br>

    <div class="w60">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <h2 class="bindigo-text lt-bold lt-up">
                {{ $data->name }}
            </h2>
            <div class="bgray-text lt-thin lt-up no-matter">ПРОЕКТ {{ $data->year }}</div>
        </div>
        <br>
        <div class="d-flex flex-wrap">
            <div class="">
                {!! $data->description !!}
            </div>
            <div class="OWcover">
                @php
                    $link = $data->cover === 'default.png' ? 'imgs/default.png' : 'storage/imgs/products/' . $data->cover;
                @endphp
                <img src="{{ asset($link) }}" alt="">
            </div>
        </div>
    </div>

    <br>
    <br>

    <div class="divider"></div>

    <br>
    <br>

    <div class="w60">
        <h2 class="bindigo-text lt-bold lt-up">
            В рамках проекта было реализовано:
        </h2>
        <br>
        <div class="">
            {!! $data->what_we_do !!}
        </div>
    </div>

    <br>
    <br>
    <div class="divider"></div>
@endsection
