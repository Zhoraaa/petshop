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
        <p>Статус: {{ $order->status }}</p>
        <p>Стоимость: {{ $totalCost }}</p>
        <p>Всего позиций: {{ $orderProductsList->count() }}</p>
        <p>Всего товаров: {{ $totalProducts }}</p>

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
