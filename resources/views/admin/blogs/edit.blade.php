

@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div class="card shadow-lg rounded">
            <div class="card-header">
                <h3>Edit Blog
                    <a href="{{ url('admin/blogs') }}" class="btn btn-danger btn-sm text-white float-end">
                        Back
                    </a>
                </h3>
            </div>
            <div class="card-body"> 
                <form method="POST" action="{{ route('admin.blogs.update', $blog->_id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $blog->title }}" required>

                    </div>
                    <div class="mb-3">
                        <label >Content</label>
                        <textarea name="content" class="form-control" rows="5" required>{{ $blog->content }}</textarea>

                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                        @if($blog->image)
                            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" width="100" class="mt-2">
                        @endif
                    </div>
                  
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</div>   

@endsection
