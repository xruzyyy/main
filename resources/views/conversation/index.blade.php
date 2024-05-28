@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Conversations</h1>
        <ul>
            @foreach ($conversations as $conversation)
                <li>
                    <a href="{{ route('conversations.show', $conversation->id) }}">
                        {{ $conversation->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
