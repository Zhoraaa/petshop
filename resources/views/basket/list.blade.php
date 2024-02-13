@extends('layouts.layout')

@section('title')
    Корзина
@endsection

@php
    $totalCost = 0;
    foreach ($basket as $order) {
        if ($order->status === 'Ожидает оплаты') {
            $totalCost = $totalCost + $order->cost;
        }
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

    <div class="border border-secondary rounded m-2 p-3">
        <h3>Корзина</h3>
        <p><b>Итог: </b>{{ $totalCost }}₽</p>
        <p><b>Ваш баланс: </b>{{ auth()->user()->balance }}₽</p>
        @if ($totalCost > 0)
            <form action="{{ route('payBasket') }}" method="POST">
                @csrf
                <button class="btn btn-primary">Оплатить корзину</button>
            </form>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Товар</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Взаимодействие</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $num = 1;
                @endphp
                @foreach ($basket as $order)
                    <tr>
                        <th scope="row">{{ $num++ }}</th>
                        <td><a href="{{ route('seeProduct', ['id' => $order->product_id]) }}">{{ $order->name }}</a></td>
                        <td>{{ $order->cost }}₽</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <div class="d-flex flex-wrap">
                                <form action="{{ route('basketExclude', ['id' => $order->id]) }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger m-2">
                                        Удалить из корзины
                                    </button>
                                </form>
                                @if ($order->status === 'Оплачен')                                    
                                <form action="{{ route('getOrder', ['id' => $order->id]) }}" method="post">
                                    @csrf
                                    <button class="btn btn-success m-2">
                                        Товар получен
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
        </table>
    </div>
@endsection
