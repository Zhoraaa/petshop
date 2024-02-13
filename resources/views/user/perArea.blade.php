@extends('layouts.layout')

@section('title')
    Личный кабинет
@endsection

@section('body')
    @php
        $user = auth()->user();
    @endphp
    <div class="border border-secondary rounded m-2 p-3">
        <h1>{{ $user->login }}</h1>
        <h4>Баланс: {{ $user->balance ?? 0 }}₽</h4>
        <form action="{{ route('changeBalance') }}" method="post">
            @csrf
            <input type="number" placeholder="Добавить к балансу" name="money">
            <button class="btn btn-primary">Пополнить баланс</button>
        </form>
        <p>На сайте с {{ $user->created_at }}</p>
    </div>
@endsection
