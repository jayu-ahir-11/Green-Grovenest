@extends('layouts.app')

@section('title', $blog->title)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">

@section('content')
<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem;">
    <article style="background: #ffffff; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
        @if($blog->image)
        <div style="position: relative;">
            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" 
                 style="width: 100%; height: 500px; object-fit: cover;">
            <div style="position: absolute; bottom: 0; left: 0; right: 0; 
                        background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 2rem;">
                <h1 style="color: white; font-size: 2.5rem; margin: 0;">{{ $blog->title }}</h1>
            </div>
        </div>
        @endif

        <div style="padding: 2rem;">
            <div style="margin-bottom: 1.5rem;">
                <span class="float-end">
                    <i class="mdi mdi-calendar-clock" style="margin-right: 0.5rem;"></i>
                    {{ $blog->created_at->format('M d, Y') }}
                </span>
            </div>

            <div style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                {!! nl2br(e($blog->content)) !!}
            </div>

            <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #eee;">
                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center;">
                    <div style="margin-bottom: 1rem;">
                        <a href="{{ route('frontend.blogs.index') }}" 
                           style="display: inline-flex; align-items: center; padding: 0.8rem 1.5rem;
                                  border: 2px solid {{ $appSetting->button }}; color: {{ $appSetting->button }};
                                  text-decoration: none; border-radius: 25px; font-weight: bold;">
                            <i class="mdi mdi-arrow-left" style="margin-right: 0.5rem;"></i>
                            Back to Blogs
                        </a>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: 1rem; font-size: 1.1rem;">Share this article:</span>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" 
                               target="_blank" style="background: #3b5998; color: white; padding: 0.5rem;
                                                    border-radius: 50%; width: 35px; height: 35px; 
                                                    display: flex; align-items: center; justify-content: center;
                                                    text-decoration: none;">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" 
                               target="_blank" style="background: #1DA1F2; color: white; padding: 0.5rem;
                                                    border-radius: 50%; width: 35px; height: 35px; 
                                                    display: flex; align-items: center; justify-content: center;
                                                    text-decoration: none;">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" 
                               target="_blank" style="background: #0077b5; color: white; padding: 0.5rem;
                                                    border-radius: 50%; width: 35px; height: 35px; 
                                                    display: flex; align-items: center; justify-content: center;
                                                    text-decoration: none;">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="background: #f8f9fa; padding: 1.5rem; text-align: center; border-bottom-left-radius: 15px; 
                    border-bottom-right-radius: 15px;">
            <p style="font-size: 1.2rem; margin: 0;">✨ Thank you for reading! ✨</p>
        </div>
    </article>
</div>
@endsection
