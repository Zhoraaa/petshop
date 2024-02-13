@extends('layouts.layout')

@section('title')
    Страница аутентификаций
@endsection

@section('body')

    @if (!empty($errors->all()))
        <div class="alert alert-danger rounded border-alert m-3">
            @foreach ($errors->all() as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </div>
    @endif
    <div class="border border-secondary rounded m-2 p-3">

        <form action="{{ @route('signIn') }}" method="POST" class="form-auth">
            @csrf
            <h1>Авторизация</h1>
            <div class="form-block-wrapper"><input type="email" name="email" placeholder="Email адрес..." required></div>
            <div class="form-block-wrapper"><input type="password" name="password" placeholder="Пароль..."
                    pattern="^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,32}$"required></div>
            <div class="form-block-wrapper"><button type="submit" class="btn btn-primary">Войти</button></div>
        </form>

        <a href="{{ @route('reg') }}">Нет аккаунта?</a>

    </div>
@endsection
