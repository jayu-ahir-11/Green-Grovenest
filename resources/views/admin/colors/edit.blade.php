@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div class="card shadow-lg rounded">
            <div class="card-header">
                <h3>Edit Colors
                    <a href="{{ url('admin/colors') }}" class="btn btn-danger btn-sm text-white float-end">
                        Back
                    </a>
                </h3>
            </div>
            <div class="card-body"> 
                <form action="{{ url('admin/colors/'.$color->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name">Color Name</label>
                        <input type="text"  name="name" class="form-control" value="{{ $color->name }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="code">Color Code</label>
                        <input type="text" name="code" class="form-control" value="{{ $color->name }}">
                        @error('code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status">Color Status</label> <br/>
                        <input type="checkbox"  name="status"  {{ $color->status ? 'checked' : '' }} style="height:30px;width:30px;" /> Check = Hidden, Uncheck = Visible
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Upadte</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</div>   

@endsection
