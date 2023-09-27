@extends('layouts.app')

@section('title', 'Home')

@section('content')


    <div class="colmd-8">
        <div class="col-lg-6 col-md-10 mx-auto">
            <div class="row">
                <div class="col-auto">
                    <p class="fw-bold text secondary">
                        Suggested
                    </p>
                </div>

            </div>
            @foreach ($suggested_users as $user)
                <div class="row align-items-center mb-3">
                    <div class="col-4 col-md-2">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user test-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $user->name }}
                            </a>
                            <div class="col-auto">
                                {{ $user->email }}
                            </div>
                            <div class="d-flex align-items-center xsmall">
                                <p>{{ $user->followers->count() }} followers </p>
                            </div>
                        </div>

                    </div>

                    <div class="col-auto text-end">

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
