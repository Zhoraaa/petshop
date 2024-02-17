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

        <form action="{{ @route('signUp') }}" method="POST" class="form-auth">
            @csrf
            <h3>Регистрация</h3>
            <div class="form-block-wrapper"><input type="text" name="login" placeholder="Ник в игре..."
                    pattern="[A-Za-z0-9_]{3,16}" required></div>
            <div class="form-block-wrapper"><input type="email" name="email" placeholder="Email адрес..." required>
            </div>
            <div class="form-block-wrapper"><input type="password" name="password" placeholder="Пароль..."
                    pattern="^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,32}$"required></div>
            <div class="form-block-wrapper"><input type="password" name="password_confirmation"
                    placeholder="Повтор пароля..." pattern="^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,32}$"required>
            </div>
            <div class="form-block-wrapper"><input type="checkbox" name="pdata" id="pdata" class="form-check-input"
                    required><label for="pdata" class="form-check-label">Даю своё
                    согласие на обработку персональных данных</label></div>
            <div class="form-block-wrapper"><button type="submit" class="btn btn-primary">Зарегистрироваться</button></div>
        </form>
        
        <a href="{{ @route('auth') }}">Есть аккаунт?</a>
    </div>
@endsection
