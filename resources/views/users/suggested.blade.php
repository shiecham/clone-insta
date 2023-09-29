@extends('layouts.app')

@section('title', 'Suggested all')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="row">
                    <div class="col-auto">
                        <p class="fw-bold text-secondary">
                            Suggested
                        </p>
                    </div>
                </div>
                @foreach ($suggested_users as $user)
                    <div class="row align-items-center mb-3">
                        <div class="col-4 col-md-2">
                            <a href="{{ route('profile.show', $user->id) }}">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                        class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('profile.show', $user->id) }}"
                                    class="text-decoration-none text-dark fw-bold">
                                    {{ $user->name }}
                                </a>
                            </div>
                            <div class="col-auto">
                                {{ $user->email }}
                            </div>
                            <div class="d-flex align-items-center xsmall text-truncate">
                                @if ($user->isFollowing())
                                    <p>Follows you </p>
                                @else
                                    <p>{{ $user->followers->count() }} followers </p>
                                @endif
                            </div>
                        </div>
                        <div class="col text-end">
                            <form action="{{ route('follow.store', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Follow
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
