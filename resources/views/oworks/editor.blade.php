@extends('layouts.layout')

@section('title')
    Редактор проектов
@endsection

@section('body')
    <div class="divider"></div>
    
    <br>
    <br>

    <form action="{{ route('OWsave') }}" method="POST" enctype="multipart/form-data" class="w60">
        @csrf
        <input type="number" name="work_id" value="{{ $data->id ?? null }}" class="hide">
        <div class="form-group">
            <label for="owoName">
                <h3 class="bgray-text lt-up lt-bold">Место проведения</h3>
            </label>
            <input name="name" type="text" class="form-control" id="owoName" aria-describedby="emailHelp"
                placeholder="Название региона" value="{{ $data->name ?? null }}">
            <small class="form-text text-muted">Введите название места, где был сдан проект.</small>
        </div>
        <div class="form-group">
            <label for="owoCover">
                <h3 class="bgray-text lt-up lt-bold">Обложка</h3>
            </label>
            <input name="cover" type="file" class="form-control-file" id="owoName" aria-describedby="emailHelp"
                placeholder="Название региона">
            <small class="form-text text-muted">Файл-обложка для проекта (изображение).</small>
        </div>
        <div class="form-group">
            <label for="owoYear">
                <h3 class="bgray-text lt-up lt-bold">Год проведения</h3>
            </label>
            <input name="year" type="text" class="form-control" id="owoYear" aria-describedby="emailHelp"
                placeholder="XXXX" value="{{ $data->year ?? null }}">
            <small class="form-text text-muted">Введите напишите год, в который проект был сдан.</small>
        </div>
        <div class="form-group">
            <label for="owoDesc">
                <h3 class="bgray-text lt-up lt-bold">Описание проекта</h3>
            </label>
            <textarea name="description" type="text" class="form-control tinyMCE" id="owoDesc" aria-describedby="emailHelp"
                placeholder="Краткое описание">{{ $data->description ?? null }}</textarea>
            <small class="form-text text-muted">Краткое описание проекта.</small>
        </div>
        <div class="form-group">
            <label for="owoWeDo">
                <h3 class="bgray-text lt-up lt-bold">Что мы сделали</h3>
            </label>
            <textarea name="what_we_do" type="text" class="form-control tinyMCE" id="owoWeDo" aria-describedby="emailHelp"
                placeholder="Что было выполнено?">{{ $data->what_we_do ?? null }}</textarea>
            <small class="form-text text-muted">Какие работы были проведены?</small>
        </div>
        <div class="form-group">
            <label for="owoCover">
                <h3 class="bgray-text lt-up lt-bold">Медиа-файлы</h3>
            </label>
            <input name="media[]" type="file" multiple class="form-control-file" id="owoName" aria-describedby="emailHelp"
                placeholder="Название региона">
            <small class="form-text text-muted">Медиа-файлы с проекта. (фото-видео)</small>
        </div>
        <button class="btn btn-primary">Сохранить</button>
    </form>

    <br>
    <br>
    <div class="divider"></div>
@endsection
