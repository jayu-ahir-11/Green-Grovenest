



@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
       
        <div class="card shadow-lg rounded">
            <div class="card-header">
                <h3>Add New Blog
                    <a href="{{ url('admin/blogs') }}" class="btn btn-danger btn-sm text-white float-end">
                        Back
                    </a>
                </h3>
            </div>
            <div class="card-body"> 
                <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control"  required>

                    </div>
                    <div class="mb-3">
                        <label >Content</label>
                        <textarea name="content" class="form-control" rows="5" required></textarea>

                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                        
                    </div>
                  
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</div>   

@endsection
