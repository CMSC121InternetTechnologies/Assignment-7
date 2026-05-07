{{-- Recursive partial for rendering a post and all of its nested replies --}}
<div class="post thread-post" style="margin-left: {{ min($level * 30, 210) }}px;">
    <strong>{{ $post->user->name }}</strong>

    @if(isset($parentName))
        <span class="reply-to-text"> Replying to @{{ $parentName }}</span>
    @endif

    <p class="message-text">{{ $post->content }}</p>

    <div class="meta">
        Posted on: {{ $post->created_at->format('Y-m-d H:i:s') }}

        @auth
            | <button type="button" class="reply-btn" onclick="toggleReplyForm({{ $post->id }})">Reply</button>

            @if(auth()->id() === $post->user_id)
                | <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn"
                        onclick="return confirm('Are you sure you want to delete this post? All replies will also be deleted.');">
                        Delete
                    </button>
                </form>
            @endif
        @endauth
    </div>

    @auth
        <form action="{{ route('posts.store') }}" method="POST" class="reply-form" id="reply-form-{{ $post->id }}">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $post->id }}">
            <input type="hidden" name="current_page" value="{{ request('page', 1) }}">
            <input type="text" id="reply-box" name="message" placeholder="Reply to {{ $post->user->name }}..." required>
            <button type="submit">Reply</button>
        </form>
    @endauth
</div>

{{-- Recursively render each reply, passing the current post's author as the parent name --}}
@foreach($post->replies as $reply)
    @include('posts._comment', [
        'post'       => $reply,
        'level'      => $level + 1,
        'parentName' => $post->user->name,
    ])
@endforeach
