{{-- Deactivate --}}
<div class="modal fade" id="deactivate-user-{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h1 class="modal-title fs-5 text-danger">
                    <i class="fa-solid fa-user-slash"></i> Deactivate User
                </h1>
            </div>
            <div class="modal-body">
                Are you sure you want to deactivate <span class="fw-bold">{{ $user->name }}</span>
            </div>
            <div class="modal-footer border-0">

                <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Deactivate</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- Activate --}}
<div class="modal fade" id="activate-user-{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header border-success">
                <h1 class="modal-title fs-5 text-success">
                    <i class="fa-solid fa-user-check"></i> Activate User
                </h1>
            </div>
            <div class="modal-body">
                Are you sure you want to activate <span class="fw-bold">{{ $user->name }}</span>
            </div>
            <div class="modal-footer border-0">

                <form action="{{route('admin.users.activate', $user->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">Activate</button>
                </form>
            </div>
        </div>
    </div>
</div>
