@extends('layouts.app')

@section('title', 'create post')

@section('content')
    <div class="container">
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="upload-image">Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="upload-image">
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control @error('content') is-invalid @enderror"></textarea>
                @error('content')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">
                            {{ $category['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <a class="btn btn-info" href="{{ route('all.posts') }}">
                Back
            </a>
            <input type="submit" value="Add Post" class="btn btn-primary">
        </form>
    </div>
@endsection
