@extends('layouts.layout')

@section('title')
    Добавление письма
@endsection

@section('body')
    <div class="divider"></div>
    <br>

    <form action="{{ route('letterSave') }}" method="post" enctype="multipart/form-data" class="w60">
        @csrf
        <div class="form-group">
            <label for="from">
                <h3 class="bgray-text lt-up lt-bold">От кого письмо?</h3>
            </label>
            <input name="from" type="text" class="form-control" id="from" aria-describedby="emailHelp"
                placeholder="ООО Ledplast УСТЗ">
            <small class="form-text text-muted">Полное название организации.</small>
        </div>
        <div class="form-group">
            <label for="image">
                <h3 class="bgray-text lt-up lt-bold">Скан письма.</h3>
            </label>
            <input name="image" type="file" class="form-control-file" id="image" aria-describedby="emailHelp">
            <small class="form-text text-muted">Загрузите скан письма (.png, .jpeg, .jpg, .pdf).</small>
        </div>
        <button class="btn btn-primary">Опубликовать</button>
    </form>

    <br>
    <div class="divider"></div>
@endsection
