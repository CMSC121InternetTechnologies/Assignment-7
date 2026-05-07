<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Freedom Board</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}"/>
</head>
<body>
    <div class="nav">
        <div>
            <a href="{{ route('posts.index') }}">Home</a>
        </div>
        <div>
            @auth
                Welcome, <strong>{{ Auth::user()->name }}</strong>!
                <form method="POST" action="{{ route('logout') }}" style="display:inline; background:none; padding:0; margin:0;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#fff; cursor:pointer; text-decoration:underline; padding:0; margin-left:15px; font:inherit;">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('register') }}">Register</a>
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </div>

    <h1>Freedom Board</h1>

    @auth
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <input type="hidden" name="current_page" value="{{ $posts->currentPage() }}">
            <textarea name="message" placeholder="What's on your mind?" required></textarea>
            <button type="submit">Post Message</button>
        </form>
    @else
        <div style="background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <p>Please <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a> to post a message.</p>
        </div>
    @endauth

    <hr>
    <h2>Recent Messages</h2>

    @forelse($posts as $post)
        @include('posts._comment', ['post' => $post, 'level' => 0])
    @empty
        <p>No messages yet. Be the first to post!</p>
    @endforelse

    {{-- Pagination controls matching original style --}}
    @if($posts->lastPage() > 1)
        <div class="pagination">
            @if($posts->currentPage() > 1)
                <a class="pagination-btn" href="{{ $posts->previousPageUrl() }}">&laquo; Previous</a>
            @endif

            <span class="pagination-info">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</span>

            @if($posts->hasMorePages())
                <a class="pagination-btn" href="{{ $posts->nextPageUrl() }}">Next &raquo;</a>
            @endif
        </div>
    @endif

    <script>
        function toggleReplyForm(postId) {
            var form = document.getElementById('reply-form-' + postId);
            if (form.style.display === 'none' || form.style.display === '') form.style.display = 'flex';
            else form.style.display = 'none';
        }
    </script>
</body>
</html>
