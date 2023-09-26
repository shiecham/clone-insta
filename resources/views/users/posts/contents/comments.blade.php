<div class="mt-3">
    {{-- Show all commments here --}}
    @if ($post->comments->isNotEmpty())
        <hr>
        <ul class="list-group mt-2">
            @foreach ($post->comments->take(3) as $comment)
                <li class="list-group-item border-0 p-0 mt-2 ">
                    <a href="{{route('profile.show', $comment->user->id)}}" class="text-decoration-none text-dark fw-bold">
                        {{ $comment->user->name }}

                        {{-- REFFERENCES : {{$comment->user->name}}
                        $comment - instance of commnet from comments table
                        ->user - is the relationship inside comment.php model which is user() that calls the specific user
                        ->name is the name of user insede the users table in database.
                        --}}

                        
                    </a>
                    &nbsp;
                    <p class="d-inline fw-light">{{ $comment->body }}</p>
                    <form action="{{route('comment.destroy', $comment->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <span class="text-uppercase text-muted xsmall">{{ $comment->created_at->diffForHumans() }}</span>

                        {{-- show delete button if the login user owns the coment --}}
                        @if (Auth::user()->id === $comment->user->id)
                            &middot;
                            <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                        @endif
                    </form>
                </li>
            @endforeach
            {{-- if the list of comment excced more than 3 add a link to show post --}}
            @if ($post->comments->count() > 3)
                <li class="list-group-item border-0 px-0 pt-0">
                    <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small">View
                        all {{ $post->comments->count() }} comments</a>
                </li>
            @endif

        </ul>


    @endif

    <form action="{{ route('comment.store', $post->id) }}" method="POST">
        @csrf
        <div class="input-group">
            {{-- comment_body2 --}}
            <textarea name="comment_body{{ $post->id }}" rows="1" class="form-control form-control-sm"
                placeholder="Add a comment...">{{ old('comment_body' . $post->id) }}</textarea>
            <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
        </div>
        {{-- error --}}
        @error('comment_body' . $post->id)
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </form>


</div>
