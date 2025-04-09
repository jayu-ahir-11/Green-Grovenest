@extends('layouts.app')

@section('title','Search Product')

@section('content')

<style>
    .text-muted,.product-name a {
        display: block;
        white-space: nowrap;     
        overflow: hidden;       
        text-overflow: ellipsis; 
        max-width: 100%;         
    }
    .selling-price{
        color: {{$appSetting->header_footer}};
    }
    .product-card {
        transition: transform .2s;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-card-img img {
        width: 100%;
        height: 100%;
    }
 
</style>

<div class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Search Results</h4>
                <div class="underline mb-4"></div>
            </div>
            
            @forelse($searchproduct as $productitem)
            <div class="col-12">
                <div class="product-card border-0 shadow-sm">
                    <div class="row ">
                        <div class="col-md-4 c">
                            <div class="product-card-img position-relative">
                                @if ($productitem->quantity > 0)
                                    <label class="badge bg-success position-absolute m-2">In Stock</label>
                                @else
                                    <label class="badge bg-danger position-absolute m-2">Out Of Stock</label>
                                @endif

                                @if ($productitem->productImages->count() > 0)
                                    <a href="{{ url('/collections/'.$productitem->category->slug.'/'.$productitem->slug) }}">
                                        <img src="{{ asset($productitem->productImages[0]->image)}}" alt="{{ $productitem->name }}" class="rounded-start">
                                    </a>     
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <div class="p-3 p-md-4 bg-white h-100">
                                <p class="text-muted text-uppercase small mb-2">
                                    Categories / {{$productitem->category->name}} / {{$productitem->brand}} / {{$productitem->name}}
                                </p>
                                
                                <hr class="my-2">

                                <h5 class="product-name">
                                    <a href="{{ url('/collections/'.$productitem->category->slug.'/'.$productitem->slug) }}" 
                                       class="text-decoration-none text-dark fw-bold">
                                        {{ $productitem->name }}
                                    </a>
                                </h5>
                                
                                <div class="price mt-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="selling-price h5 mb-0 me-2">₹{{ number_format($productitem->selling_price, 2) }}</span>
                                        <span class="original-price text-muted text-decoration-line-through">₹{{ number_format($productitem->original_price, 2) }}</span>
                                    </div>
                                    <hr>
                                    <p class="description" style="max-height: 45px; overflow: hidden">
                                        <b>Description: </b>{{ $productitem->description }}
                                    </p>
                                    <a href="{{ url('/collections/'.$productitem->category->slug.'/'.$productitem->slug) }}" 
                                       class="btn btn-sm float-end mb-3" 
                                       style="border: 1px solid {{$appSetting->button}}; color: {{$appSetting->button}};">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div> 
            @empty
                <div class="col-12 p-2">
                    <h4>No Such Products Found</h4>
                </div>
            @endforelse

            <div class="col-12 mt-4">
                {{ $searchproduct->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection