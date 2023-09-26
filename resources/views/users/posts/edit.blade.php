@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        {{-- category check box --}}
        <div class="mb-3">
            <label for="category" class="form-label d-block fw-bold">
                Category <span class="text-muted fw-normal">(up tp 3)</span>

            </label>
            @foreach ($all_categories as $category)
                <div class="form-check form-check-inline">

                    {{-- [1,2] --}}
                    @if (in_array($category->id, $selected_categories))
                        {{--
                        in_array(1.[1,2,3])= TRUE
                        --}}
                        <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}"
                            class="form-check-input" checked>
                    @else
                        <input type="checkbox" name="category[]" id="{{ $category->name }}" value="{{ $category->id }}"
                            class="form-check-input">
                    @endif
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
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{ old('description', $post->description) }}</textarea>
            {{-- error --}}
            @error('description')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

        </div>

        {{-- image --}}
        <div class="row mb-4">
            <div class="col-6">
                <label for="image" class="form-label fw-bold">Image</label>
                <img src="{{ $post->image }}" alt="post id{{ $post->id }}" class="img-thumbnail w-100">
                <input type="file" name="image" id="image" class="form-control mt-1" aria-describedby="image-info">
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



        </div>
        <button type="submit" class="btn btn-warning px-5">Save</button>

    </form>
@endsection
