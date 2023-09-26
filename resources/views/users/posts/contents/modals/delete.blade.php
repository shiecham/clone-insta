<div class="modal fade" id="delete-post-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="modal-title h5 text-danger" id="staticBackdropLabel">
                    <i class="fa-solid fa-circle-exclamation"></i> Delete Post
                </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
                <div class="mt-3">
                    <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="image-lg">
                    <p class="mt-1 text-muted">{{ $post->description }}</p>
                </div>
            </div>
            <div class="modal-footer border-0">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button> --}}
                <form action="{{route('post.destroy',$post->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn btn-outline-danger btn-sm"
                        data-bs-dismiss="modal">Cancel</button>
                    </button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
