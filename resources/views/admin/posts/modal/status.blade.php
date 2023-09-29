<div class="modal fade" id="hide-post-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h1 class="modal-title fs-5 text-danger">
                    <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                </h1>
            </div>
            <div class="modal-body">
                Are you sure you want to hide <span class="fw-bold">{{ $post->name }}</span>
            </div>
            <div class="modal-footer border-0">

                <form action="{{ route('admin.posts.hide', $post->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Hide</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="unhide-post-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header border-success">
                <h1 class="modal-title fs-5 text-success">
                    <i class="fa-solid fa-eye"></i> Unhide Post {{ $post->id }}
                </h1>
            </div>
            <div class="modal-body">
                Are you sure you want to unhide <span class="fw-bold">{{ $post->name }}</span>
            </div>
            <div class="modal-footer border-0">

                <form action="{{ route('admin.posts.unhide', $post->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="button" class="btn btn-outline-success btn-sm"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">Unhide</button>
                </form>
            </div>
        </div>
    </div>
</div>
