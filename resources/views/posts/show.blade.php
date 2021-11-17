@extends('layouts.app')

@section('title', 'show post')

@section('content')
    <div class="container">
        <div class="card mb-2">
            <div class="card-body">
                <img src="{{ asset('storage/posts/' . $post->image) }}" alt="" height="300" width="300">
                <h5 class="card-title">{{ $post->title }}</h5>
                <div class="card-subtitle mb-2 text-muted small">
                    {{ $post->created_at->diffForHumans() }}
                    Category: <b>{{ $post->category->name }}</b>
                </div>
                <p class="card-text">{{ $post->content }}</p>
                <a class="btn btn-info" href="{{ route('all.posts') }}">
                    Back
                </a>
                <button class="btn btn-danger waves-effect" type="button" onclick="deletePost({{ $post->id }})">
                    <i class="material-icons">delete</i>
                </button>

                <form id="delete-form-{{ $post->id }}" action="{{ route('posts.destroy', $post->id) }}" method="POST"
                    style="display: none;">
                    @csrf
                    @method('DELETE')

                </form>
            </div>
        </div>

        @if (Session::has('status'))
            <div class="alert alert-danger">
                {{ Session::get('status') }}
            </div>
        @endif


        <ul class="list-group">
            <li class="list-group-item active">
                <b>Comments ({{ count($post->comments) }})</b>
            </li>
            @foreach ($post->comments as $comment)
                <li class="list-group-item">
                    {{ $comment->content }}
                    <button class="btn btn-danger waves-effect" type="button"
                        onclick="deleteComment({{ $comment->id }})">
                        <i class="material-icons">delete</i>
                    </button>

                    <form id="delete-form-{{ $comment->id }}" action="{{ route('comments.destroy', $comment->id) }}"
                        method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')

                    </form>
                </li>
            @endforeach
        </ul>

        <br>

        @if (Session::has('successMsg'))
            <div class="alert alert-success">
                {{ Session::get('successMsg') }}
            </div>
        @endif

        <form action="{{ route('comments.store') }}" method="post">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea name="content" class="form-control mb-2 @error('content') is-invalid @enderror"
                placeholder="New Comment"></textarea>
            @error('content')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input type="submit" value="Add Comment" class="btn btn-secondary">
        </form>

    </div>
@endsection

<script type="text/javascript">
    function deletePost(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                event.preventDefault();
                document.getElementById('delete-form-' + id).submit();
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    }

    function deleteComment(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                event.preventDefault();
                document.getElementById('delete-form-' + id).submit();
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    }
</script>
