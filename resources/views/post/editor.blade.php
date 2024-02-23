@extends('layouts.layout')

@php
    $reply_to = $data['reply_to'];
    $oldData = $data['oldData'] ?? null;
@endphp

@section('title')
    Редактирование поста
@endsection

@section('body')
    <form action="{{ @route('savePost') }}" method="post" class="border border-secondary rounded m-2 p-3 form-auth">
        @csrf
        <input type="text" class="hide" name="post_id" value="{{ isset($oldData) ? $oldData->id : null }}">
        <input type="text" class="hide" name="reply_to" value="{{ isset($reply_to) ? $reply_to : null }}">
        <div class="form-block-wrapper border border-secondary rounded">
            <input type="text" name="theme" class="theme-inp" placeholder="Тема поста..."
                value="{{ isset($oldData) ? $oldData->theme : null }}">
        </div>
        <div class="form-block-wrapper border border-secondary rounded">
            <textarea name="text" class="tinyMCE" placeholder="Текст поста...">
                {{ isset($oldData) ? $oldData->text : null }}
            </textarea>
        </div>
        <div class="form-block-wrapper">
            <button type="submit" class="btn btn-primary">Опубликовать</button>
        </div>
    </form>
@endsection
