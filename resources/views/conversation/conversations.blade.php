<!-- Display a list of conversations -->
<ul>
    @foreach($conversations as $conversation)
    <li><a href="{{ route('conversations.show', $conversation->id) }}">{{ $conversation->title }}</a></li>
    @endforeach
</ul>
