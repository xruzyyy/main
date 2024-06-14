<div class="container">
    <h2>Send Message</h2>
    <form action="{{ route('messages.store') }}" method="POST">
        @csrf
        <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
        <textarea name="content" rows="3" required></textarea>
        <button type="submit">Send</button>
    </form>
</div>
