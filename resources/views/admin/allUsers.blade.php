@extends('layouts.layout')

@section('title')
    Администрирование
@endsection

@php
    $users = $data['users'];
    $roles = $data['roles'];
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
        <div class="w80 centering pagination">
            {{ $users->links() }}
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Ник</th>
                    <th scope="col">Почта</th>
                    <th scope="col">Роль</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Взаимодействие</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $num = 1;
                @endphp
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->login }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->banned ? 'Забанен' : 'Обычный' }}</td>
                        <td>
                            <div class="d-flex flex-wrap">
                                @if ($user->role === 'Покупатель' && !$user->banned)
                                    <form action="{{ route('doMod', ['id' => $user->id]) }}" method="post">
                                        @csrf
                                        <button class="btn btn-success m-2">Назначить модератором</button>
                                    </form>
                                @endif
                                @if ($user->role === 'Модер')
                                    <form action="{{ route('undoMod', ['id' => $user->id]) }}" method="post">
                                        @csrf
                                        <button class="btn btn-warning m-2">Разжаловать</button>
                                    </form>
                                @endif
                                @if (!$user->banned && $user->role != 'Админ')
                                    <form action="{{ route('ban', ['id' => $user->id]) }}" method="post">
                                        @csrf
                                        <button class="btn btn-dark m-2">Забанить</button>
                                    </form>
                                @endif
                                @if ($user->banned)
                                    <form action="{{ route('unban', ['id' => $user->id]) }}" method="post">
                                        @csrf
                                        <button class="btn btn-danger m-2">Разбанить</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
        </table>
        <div class="w80 centering pagination">
            {{ $users->links() }}
        </div>
    </div>
@endsection
