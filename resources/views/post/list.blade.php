@extends('layouts.layout')

@section('title')
    Форум
@endsection

@section('body')
    <div class="border border-secondary rounded m-2 p-3">
        @auth
            @if (!auth()->user()->banned)
                <form action="{{ @route('postNew') }}" method="post">
                    @csrf
                    <button class="btn btn-primary m-2">Новый пост</button>
                </form>
            @endif
        @endauth
        <div class="m-2">
            {{ $posts->links() }}
        </div>
        @if (!empty($posts))
            @foreach ($posts as $post)
                <hr>
                <div class="border border-secondary rounded p-4">
                    <a href="{{ route('seePost', ['id' => $post->id]) }}">
                        <h2>
                            Тема: {{ $post->theme }}
                        </h2>
                    </a>
                    <span class="text-secondary font-weight-light font-italic">Автор: ({{ $post['author'] }})</span>
                    <span class="text-secondary font-weight-light font-italic">Ответов: {{ $post->replies()->count() }}</span>
                    <p>{!! substr($post->text, 0, 200) !!}</p>
                </div>
            @endforeach
        @else
            Постов пока нет
        @endif

        <div class="m-2">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
