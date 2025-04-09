@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div class="card shadow-lg rounded">
            <div class="card-header">
                 <h3>Manage Blogs
                     <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm text-white float-end">
                        Add New Blog                    </a>
                 </h3>
            </div>
            <div class="card-body table-responsive"> 
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Blogs Title</th>
                            <th>Blogs Content</th>
                            <th>Blogs Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($blogs as $blog)
                        <tr>     
                            <td>{{ $blog->id }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>
                                <p>{{ \Illuminate\Support\Str::limit($blog->content, 100) }}</p>

                            </td>
                            
                            <td>
                                @if($blog->image)
                                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="img-fluid rounded" style="width: 150px; height: 100px; ">     
                                @endif
                            </td>
                            
                            <td class="text-center">
                                <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.blogs.edit', $blog->_id) }}" class="btn btn-sm btn-success">Edit</a>
                            
                                    <!-- Delete Button Triggering Modal -->
                                    <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                        data-id="{{ $blog->_id }}" 
                                        data-title="{{ $blog->title }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal">
                                        Delete
                                    </button>
                                </div>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>    

    <!-- Stylish Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <div class="modal-body" id="deleteModalBody">
                </div>
    
                <div class="modal-footer">
                    
                    <!-- Dynamic Form to Delete -->
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('POST')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Yes, Delete it</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

</div>
@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                let blogId = this.getAttribute('data-id');
                let blogTitle = this.getAttribute('data-title');
                
                // Correct URL to destroy route
                let actionUrl = "{{ url('admin/blogs') }}/" + blogId;
                
                // Set the form action dynamically
                document.getElementById('deleteForm').setAttribute('action', actionUrl);

                // Update the modal body with blog title
                document.getElementById('deleteModalBody').innerHTML = 
                    `Are you sure you want to delete?`;
            });
        });
    });   
</script>
@endsection


