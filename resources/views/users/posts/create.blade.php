@extends('layouts.app')

@section('title', 'Create a Post')

@section('content')
    <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="category" class="form-label d-block fw-bold">
                Category <span class="text-muted fw-normal">(up tp 3)</span>

            </label>
            @foreach ($all_categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}"
                        class="form-check-input">
                        {{-- [1,2] --}}
                    <label for="{{ $category->name }}" claa="form-check-label">{{ $category->name }}</label>

                </div>
            @endforeach
            {{-- error --}}
            @error('category')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

        </div>

        {{-- Discription --}}
        <div class="mb-3">
            <label for="description" class="from-lable fw-bold">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{ old('description') }}</textarea>
            {{-- error --}}
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

        </div>

        {{-- image --}}
        <div class="mb-4">
            <label for="image" class="form-label fw-bold">Image</label>
            <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
            <div class="form-text" id="image-info">
                THhe acceptable formats are jpeg, jpg,pug and gif only.<br>
                Max file size is 1048kB.
                {{-- B = byte, b = bits, example 1011 1111, 1048kB = 1MB --}}
            </div>

            {{-- error --}}
            @error('image')
                <div class="text-danger small">{{ $message }}</div>
            @enderror


        </div>
        <button type="submit" class="btn btn-primary px-5">Post</button>

    </form>
@endsection
