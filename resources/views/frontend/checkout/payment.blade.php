@extends('layouts.app')

@section('title','Checkout')

@section('content')

    <div class="final">
        <div class="payment-container">
            <h2>Paying to Green Grovenest  </h2>
            <div class="underline"></div>

            <div class="form-group">
                <label for="total1">Net Payable Amount</label>
                <input type="text" class="form-control" id="total1" value="{{ $amount / 100 }}" disabled>
            </div>
            <div class="form-group">
                <label for="order_id">Order ID</label>
                <input type="text" class="form-control" id="order_id" value="{{ $order_id }}" disabled>
            </div>
            <form action="{{url('payment/verify') }}" method="POST">
                @csrf
                <script src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="{{ env('RAZORPAY_KEY') }}"
                    data-amount="{{ $amount }}"
                    data-currency="INR"
                    data-order_id="{{ $order_id }}"
                    data-buttontext="Pay Now"
                    data-name="Green Grovenest"
                    data-description="Order Payment"
                    data-theme.color="{{ $appSetting->primary }}">
                </script>
            </form>

        </div>
    </div>
<br>
@endsection

<style>

    .final {
                margin-top: 50px;
                display: grid;
                place-items: center;
            }

            .payment-container {
                background-color: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 30px;
                width: 100%;
                max-width: 500px;
            }

            h1 {
                font-size: 28px;
                margin-bottom: 30px;
                color: #343a40;
                text-align: center;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                font-weight: bold;
                color: #495057;
            }

            .form-group input[type="text"] {
                background-color: #e9ecef;
                border: 1px solid #ced4da;
                border-radius: 5px;
                padding: 10px;
                font-size: 16px;
                color: #495057;
            }

            .razorpay-payment-button {
                width: 100%;
                font-size: 18px;
                padding: 10px;
                background-color: {{ $appSetting->button }};

                border: none;
                border-radius: 5px;
                color: white;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .razorpay-payment-button:hover {
                background-color: {{ $appSetting->header_footer }} ;
            }
</style>