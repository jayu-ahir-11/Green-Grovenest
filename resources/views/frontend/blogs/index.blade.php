@extends('layouts.app')

@section('title', 'Our Blogs')

@section('content')
<div class="container py-5">
    <h4>Explore Our Latest Blogs</h4>
    <div class="underline"></div>
    <br><br>
    

    <div class="row justify-content-center">
        @foreach($blogs as $blog)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card blog-card border-0 shadow-sm rounded-lg">
                @if($blog->image)
                <div class="blog-image">
                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="img-fluid rounded-top" style="height: 200px; width: 100%; object-fit: cover;">
                </div>
                @endif
                <div class="card-body">
                    <h4 class="blog-title" style="color:{{$appSetting->header_footer}}">
                        {{ \Illuminate\Support\Str::limit($blog->title, 53) }}
                    </h4>
                    <p class="blog-content text-muted">
                        {{ $blog->content}}
                    </p>
                    <a href="{{ route('frontend.blogs.show', $blog->slug) }}" class="btn btn-sm mt-2" style=" border: 1px solid {{ $appSetting->button }}; color: {{ $appSetting->button }};">
                        Read More
                        <i class="mdi mdi-chevron-double-right"></i>
                    </a>
                </div>
                <div class="card-footer bg-white text-muted small d-flex justify-content-between">
                    <span><i class="mdi mdi-calendar-clock"></i> {{ $blog->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination if necessary -->
    {{-- <div class="d-flex justify-content-center mt-4">
        {{ $blogs->links() }}
    </div> --}}
</div>

@endsection

