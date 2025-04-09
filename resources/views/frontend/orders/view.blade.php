@extends('layouts.app')

@section('title','My Orders Detail')


@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


        <div class="py-3 py-md-5">
            <div class="container ">
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="p-2 shadow-lg rounded bg-white ">
                            <div class="card-header" style="background-color:{{$appSetting->primary}};">
                                <h4 class=" text-white" >
                                    My order Details
                                    <a href="{{ url('/orders')}}" class="btn text-white btn-danger btn-sm float-end">Back</a>
                                </h4>
                            </div>
                            <hr> 
                            
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- Order Details Card -->
                                    <div class="col-12 col-lg-6 mb-4">
                                        <div class="card h-100 shadow-sm border-0 rounded-3">
                                            <div class="card-body">
                                                <h5 class="card-title border-bottom pb-3 mb-4">
                                                    <i class="fas fa-shopping-cart me-2"></i>Order Details
                                                </h5>
                                                <div class="row">
                                                    <div class="col-sm-4 mb-2">
                                                        <strong class="text-muted">Order ID:</strong>
                                                    </div>
                                                    <div class="col-sm-8 mb-2">
                                                        {{ $order->id }}
                                                    </div>
                                                    
                                                    <div class="col-sm-4 mb-2">
                                                        <strong class="text-muted">Tracking No:</strong>
                                                    </div>
                                                    <div class="col-sm-8 mb-2">
                                                        {{ $order->tracking_no }}
                                                    </div>

                                                    <div class="col-sm-4 mb-2">
                                                        <strong class="text-muted">Order Date:</strong>
                                                    </div>
                                                    <div class="col-sm-8 mb-2">
                                                        {{ $order->created_at->format('d-m-Y h:i A') }}
                                                    </div>

                                                    <div class="col-sm-4 mb-2">
                                                        <strong class="text-muted">Payment Mode:</strong>
                                                    </div>
                                                    <div class="col-sm-8 mb-2">
                                                        <span class="badge bg-primary">{{ $order->payment_mode }}</span>
                                                    </div>

                                                    <div class="col-sm-4 mb-2">
                                                        <strong class="text-muted">Payment ID:</strong>
                                                    </div>
                                                    <div class="col-sm-8 mb-2">
                                                        {{ $order->payment_id ?? "Not Available" }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- User Details Card -->
                                    <div class="col-12 col-lg-6 mb-4">
                                        <div class="card h-100 shadow-sm border-0 rounded-3">
                                            <div class="card-body">
                                                <h5 class="card-title border-bottom pb-3 mb-4">
                                                    <i class="fas fa-user me-2"></i>User Details
                                                </h5>
                                                <div class="row">
                                                    <div class="col-sm-4 mb-2">
                                                        <strong class="text-muted">Full Name:</strong>
                                                    </div>
                                                    <div class="col-sm-8 mb-2">
                                                        {{ $order->fullname }}
                                                    </div>

                                                    <div class="col-sm-4 mb-2">
                                                        <strong class="text-muted">Email:</strong>
                                                    </div>
                                                    <div class="col-sm-8 mb-2">
                                                        {{ $order->email }}
                                                    </div>

                                                    <div class="col-sm-4 mb-2">
                                                        <strong class="text-muted">Phone:</strong>
                                                    </div>
                                                    <div class="col-sm-8 mb-2">
                                                        {{ $order->phone }}
                                                    </div>

                                                    <div class="col-sm-4 mb-2">
                                                        <strong class="text-muted">Address:</strong>
                                                    </div>
                                                    <div class="col-sm-8 mb-2">
                                                        {{ $order->address }}
                                                    </div>

                                                    <div class="col-sm-4 mb-2">
                                                        <strong class="text-muted">Pin Code:</strong>
                                                    </div>
                                                    <div class="col-sm-8 mb-2">
                                                        {{ $order->pincode }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <hr>

                            

                            <div class="order-timeline">
                                <h2>Order Status:</h2>
                                <div class="timeline">
                                    <!-- Cancelled Order -->
                                    @if($order->status_message == 'cancelled')
                                    <div class="timeline-step cancelled">
                                        <div class="step-icon" style="color: white; background-color: red;">&#x2716;</div>
                                        <div class="step-content">
                                            <span class="step-title">Order Cancelled</span>
                                            <span class="step-description">Your order has been cancelled.If you have any queries, please contact us. <br> 
                                                <a href="mailto:greengrovenest@gmail.com"  style="text-decoration: none;">
                                                    {{ $appSetting->email1 ?? 'Emil Id.' }}
                                                </a>
                                            </span>
                                           
                                        </div>
                                    </div>
                                    @else
                                    <!-- Step 1: Confirmed Order -->
                                    <div class="timeline-step {{ $order->status_message == 'confirmed' || in_array($order->status_message, ['processing', 'shipped', 'current city', 'out for delivery', 'delivered']) ? 'completed' : '' }}">
                                        <div class="step-icon">{{ $order->status_message == 'confirmed' || in_array($order->status_message, ['processing', 'shipped', 'current city', 'out for delivery', 'delivered']) ? '✓' : '○' }}</div>
                                        <div class="step-content">
                                            <span class="step-title">Confirmed Order</span>
                                            <span class="step-description">Your order has been confirmed.</span>
                                        </div>
                                    </div>
                                    <div class="connector"></div>
                            
                                    <!-- Step 2: Processing Order -->
                                    <div class="timeline-step {{ $order->status_message == 'processing' || in_array($order->status_message, ['shipped', 'current city', 'out for delivery', 'delivered']) ? 'completed' : '' }}">
                                        <div class="step-icon">{{ $order->status_message == 'processing' || in_array($order->status_message, ['shipped', 'current city', 'out for delivery', 'delivered']) ? '✓' : '○' }}</div>
                                        <div class="step-content">
                                            <span class="step-title">Processing Order</span>
                                            <span class="step-description">Your order is being processed.</span>
                                        </div>
                                    </div>
                                    <div class="connector"></div>
                            
                                    <!-- Step 3: Shipped Order -->
                                    <div class="timeline-step {{ $order->status_message == 'shipped' || in_array($order->status_message, ['current city', 'out for delivery', 'delivered']) ? 'completed' : '' }}">
                                        <div class="step-icon">{{ $order->status_message == 'shipped' || in_array($order->status_message, ['current city', 'out for delivery', 'delivered']) ? '✓' : '○' }}</div>
                                        <div class="step-content">
                                            <span class="step-title">Shipped Order</span>
                                            <span class="step-description">Your order has been shipped.</span>
                                        </div>
                                    </div>
                                    <div class="connector"></div>
                            
                                    <!-- Step 4: Current City -->
                                    <div class="timeline-step {{ $order->status_message == 'current city' || in_array($order->status_message, ['out for delivery', 'delivered']) ? 'completed' : '' }}">
                                        <div class="step-icon">{{ $order->status_message == 'current city' || in_array($order->status_message, ['out for delivery', 'delivered']) ? '✓' : '○' }}</div>
                                        <div class="step-content">
                                            <span class="step-title">Current City</span>
                                            <span class="step-description">Your order has entered your city.</span>
                                        </div>
                                    </div>
                                    <div class="connector"></div>
                            
                                    <!-- Step 5: Out For Delivery -->
                                    <div class="timeline-step {{ $order->status_message == 'out for delivery' || $order->status_message == 'delivered' ? 'completed' : '' }}">
                                        <div class="step-icon">{{ $order->status_message == 'out for delivery' || $order->status_message == 'delivered' ? '✓' : '○' }}</div>
                                        <div class="step-content">
                                            <span class="step-title">Out For Delivery</span>
                                            <span class="step-description">Your order is out for delivery.</span>
                                        </div>
                                    </div>
                                    <div class="connector"></div>
                            
                                    <!-- Step 6: Product Delivered -->
                                    <div class="timeline-step {{ $order->status_message == 'delivered' ? 'completed' : '' }}">
                                        <div class="step-icon">{{ $order->status_message == 'delivered' ? '✓' : '○' }}</div>
                                        <div class="step-content">
                                            <span class="step-title">Product Delivered</span>
                                            <span class="step-description">Your order has been delivered.</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
            
                            <br/>
                                <h5>Order Items</h5>
                            <hr>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item Id</th>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalPrice = 0;
                                        @endphp
                                        @foreach ($order->oredrItems as $orderItems)
                                        <tr>
                                            <td width="10%">{{ $orderItems->id }}</td>
                                            <td width="10%">
                                                @if ($orderItems->product->productImages)
                                                    <img src="{{ asset($orderItems->product->productImages[0]->image) }}" style="width: 100px; height: 100px">
                                                @else
                                                    <img src="" style="width: 50px; height: 50px" alt="">
                                                @endif
                                            </td>
                                            <td>
                                                {{  $orderItems->product->name }}
                                                @if($orderItems->productColor && isset($orderItems->productColor->color->name))
                                                <span>- Color: {{ $orderItems->productColor->color->name }}</span>
                                                @endif
                                            </td>
                                            <td width="10%">₹{{ $orderItems->price }}</td>
                                            <td width="10%">{{ $orderItems->quantity }}</td>
                                            <td width="10%" class="fw-bold">₹{{ $orderItems->quantity * $orderItems->price }}</td>
                                            @php
                                                $totalPrice += $orderItems->quantity * $orderItems->price;
                                            @endphp
                                            <td width="15%" class="text-center">
                                                @if($order->status_message == 'delivered')
                                                    <div class="review-section" data-product-id="{{ $orderItems->product->id }}">
                                                        <button class="btn btn-success btn-sm open-review-modal" 
                                                                data-product-id="{{ $orderItems->product->id }}" 
                                                                data-product-name="{{ $orderItems->product->name }}">
                                                            <i class="fa fa-star"></i> Review & Rate
                                                        </button>
                                                        <span class="text-muted review-submitted" style="display: none;">Review Submitted</span>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Delivery Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr class="table-light">
                                            <td colspan="6" class="fw-bold text-end">Total Amount:</td>
                                            <td class="fw-bold text-center">₹{{ $order->original_price }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="fw-bold text-danger text-end">You saved on this order!</td>
                                            <td class="fw-bold text-center text-primary">  
                                                <span class="fw-bold text-danger">-₹{{ $order->discount_price }}</span>
                                            </td>   
                                        </tr>
                                        <tr class="table-dark text-white">
                                            <td colspan="6" class="fw-bold text-end">Your Final Amount:</td>
                                            <td class="fw-bold text-center">₹{{ $order->total_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

<!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <button id="button" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                <div class="modal-header">
                    <h5 class="modal-title">Leave a Review for: <span id="productName"></span></h5>
                </div>
                <div class="modal-body">
                    @if(session('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    @if(auth()->check())
                        <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" id="productId">
                            
                            <div class="mb-3">
                                <label for="rating" class="form-label">Your Rating:</label>
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                    @endfor
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="review" class="form-label">Your Review:</label>
                                <textarea name="review" class="form-control" rows="3" placeholder="Write your review here..." required></textarea>
                            </div>

                            <button type="submit" class="btn text-white w-100" style="background-color: {{ $appSetting->button }}">Submit Review</button>
                        </form>
                    @else
                        <p><a href="{{ route('login') }}" class="text-primary">Login</a> to leave a review.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

<script>
$(document).ready(function () {
    $(document).on("click", ".open-review-modal", function () {
        var productId = $(this).data("product-id");
        var productName = $(this).data("product-name");

        $("#productId").val(productId);
        $("#productName").text(productName);

        $("#reviewModal").modal("show");
    });

    // Handle form submission
    $("#reviewForm").on("submit", function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $("#reviewModal").modal("hide");
                
                // Find the review section for this product and update it
                var productId = $("#productId").val();
                var reviewSection = $('.review-section[data-product-id="' + productId + '"]');
                reviewSection.find('.open-review-modal').hide();
                reviewSection.find('.review-submitted').show();
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".rating input");

    stars.forEach((star) => {
        star.addEventListener("change", function () {
            updateStars();
        });
    });

    function updateStars() {
        let checkedStar = document.querySelector(".rating input:checked");

        if (checkedStar) {
            let value = checkedStar.value;
            document.querySelectorAll(".rating label").forEach((label, index) => {
                label.style.color = index < value ? "gold" : "#ccc";
            });
        }
    }
});
</script>




<style>

    #reviewModal {
        position: fixed;
        top: 30%;
        left: 54%;
        transform: translate(-50%, -50%);
        width: 480px;
        border-radius: 8px;
    }
    #button{
        margin-left: 93%;
        margin-top: 8px;
    }

    .step-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #4CAF50;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }
    
    .step-content {
        display: flex;
        flex-direction: column;
    }
    
    .connector {
        height: 20px;
        width: 2px;
        background-color: #e0e0e0;
        margin-left: 14px;
        margin-bottom: 20px;
    }
    
    .completed .step-icon {
        background-color: #4CAF50;
    }
    
        .order-timeline {
      display: flex;
      flex-direction: column;
      padding: 20px;
      font-family: Arial, sans-serif;
    }
    
    .timeline-step {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .step-icon {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #e0e0e0;
      color: #fff;
      font-size: 16px;
    }
    
    .completed .step-icon {
      background-color: #4CAF50; /* Green for completed steps */
    }
    
    .current .step-icon {
      background-color: #2196F3; /* Blue for current step */
    }
    
    .step-content {
      display: flex;
      flex-direction: column;
    }
    
    .step-title {
      font-size: 16px;
      font-weight: bold;
      color: #333;
    }
    
    .step-description {
      font-size: 14px;
      color: #666;
    }
    
    </style>

@endsection  

