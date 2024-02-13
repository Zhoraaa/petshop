@extends('layouts.layout')

@section('title')
    Форум
@endsection

@section('body')
    <div class="border border-secondary rounded m-2 p-3">
        <div class="w80 centering pagination">
            {{ $posts->links() }}
        </div>
        @auth
            @if (auth()->user()->role < 3)
                <form action="{{ @route('postNew') }}" method="post">
                    @csrf
                    <button class="btn btn-primary m-2">Новый пост</button>
                </form>
            @endif
        @endauth
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
                    <p>{!! substr($post->text, 0, 200) !!}</p>
                </div>
            @endforeach
        @else
            Постов пока нет
        @endif

        <div class="w80 centering pagination">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
