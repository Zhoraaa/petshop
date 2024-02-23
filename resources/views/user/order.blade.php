@extends('layouts.layout')

@php
    $order = $data['order'];
    $orderProductsList = $data['OPList'];

    $totalCost = 0;
    $totalProducts = 0;
    foreach ($orderProductsList as $orderProduct) {
        $totalCost = $totalCost + $orderProduct->cost * $orderProduct->count;
        $totalProducts = $totalProducts + $orderProduct->count;
    }
@endphp

@section('title')
    Заказ {{ $order->track_number }}
@endsection

@section('body')
    <div class="m-2 p-2 rounded border-secondary">
        <h2>Заказ {{ $order->track_number }}</h2>
        <p>Статус: {{ $order->status_text }}</p>
        <p>Стоимость: {{ $totalCost }}</p>
        <p>Всего позиций: {{ $orderProductsList->count() }}</p>
        <p>Всего товаров: {{ $totalProducts }}</p>
        @if ($order->status === 1)
            <form action="{{ route('payOrder', ['id' => $order->id]) }}" method="post">
                @csrf
                <button class="btn btn-primary m-2">
                    Оплатить заказ
                </button>
            </form>
            <form action="{{ route('delOrder', ['track_number' => $order->track_number]) }}" method="post">
                @csrf
                <button class="btn btn-danger m-2">
                    Расформировать заказ
                </button>
            </form>
        @endif
        @if ($order->status === 2)
            <form action="{{ route('getOrder', ['track_number' => $order->track_number]) }}" method="post">
                @csrf
                <button class="btn btn-success m-2">
                    Я получил заказ
                </button>
            </form>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Товар</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Кол-во</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $num = 1;
                @endphp
                @foreach ($orderProductsList as $orderProduct)
                    <tr>
                        <th scope="row">{{ $num++ }}</th>
                        <td><a
                                href="{{ route('seeProduct', ['id' => $orderProduct->product_id]) }}">{{ $orderProduct->name }}</a>
                        </td>
                        <td>{{ $orderProduct->cost }}₽</td>
                        <td>{{ $orderProduct->count }}</td>
                    </tr>
                @endforeach
        </table>
    </div>
@endsection
