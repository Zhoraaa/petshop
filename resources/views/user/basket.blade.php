@extends('layouts.layout')

@section('title')
    Корзина
@endsection

@php
    $basket = $data['basket'];
    $orders = $data['orders'];

    $totalCost = 0;
    foreach ($basket as $bPoint) {
        $totalCost = $totalCost + $bPoint->cost * $bPoint->count;
    }
@endphp

@section('body')
    @if (session('success'))
        <div class="alert alert-success m-2" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger m-2" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="bbPoint bbPoint-secondary rounded m-2 p-3">
        <form action="{{ route('newOrder') }}" method="POST">
            @csrf
            <h3>Корзина</h3>
            <p><b>Итог: </b>{{ $totalCost }}₽</p>
            <p><b>Ваш баланс: </b>{{ auth()->user()->balance }}₽</p>
            @if ($totalCost > 0)
                <button class="btn btn-primary">Сформировать заказ</button>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Товар</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Кол-во</th>
                        <th scope="col">Взаимодействие</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $num = 1;
                    @endphp
                    @foreach ($basket as $bPoint)
                        <tr>
                            <th scope="row">{{ $num++ }}</th>
                            <td><a href="{{ route('seeProduct', ['id' => $bPoint->product_id]) }}">{{ $bPoint->name }}</a>
                            </td>
                            <td>{{ $bPoint->cost }}₽</td>
                            <td>{{ $bPoint->count }}</td>
                            <td>
                                <div class="d-flex flex-column align-items-start">
                                    <div>
                                        <input type="checkbox" name="{{ $bPoint->id }}"
                                            id="addToOrder_{{ $bPoint->id }}" checked>
                                        <label for="addToOrder_{{ $bPoint->id }}">Добавить к новому заказу</label>
                                    </div>
                                    <form action="{{ route('delFromCart', ['id' => $bPoint->id]) }}" method="post">
                                        @csrf
                                        <button class="btn btn-danger">
                                            Удалить из корзины
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
            </table>
        </form>
    </div>
    <div class="bbPoint bbPoint-secondary rounded m-2 p-3">
        <h3>Ваши заказы:</h3>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Трек-номер</th>
                    <th scope="col">Дата оформления</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $num = 1;
                @endphp
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $num++ }}</th>
                        <td><a
                                href="{{ route('seeOrder', ['track_number' => $order->track_number]) }}">{{ $order->track_number }}</a>
                        </td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                @endforeach
        </table>

    </div>
@endsection
