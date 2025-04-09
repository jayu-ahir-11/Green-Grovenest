<?php

namespace App\Http\Livewire\Frontend\Checkout;

use App\Models\cart;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PlaceOrderMailable;
use App\Models\Coupons;
use MongoDB\BSON\UTCDateTime;
use Razorpay\Api\Api;
use App\Models\UserDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class CheckoutShow extends Component
{
    public $carts,$totalProductAmount = 0; 
    
    public $fullname, $email ,$phone ,$pincode,$address,$payment_mode = null,$payment_id = null,$couponCode,$discountAmount = 0, $finalAmount = 0;

    public function rules(){
        return [
            "fullname"=> "required|string|max:121",
            "email"=> "required|email|max:121",
            "phone"=> "required|string|max:10|min:10",
            "pincode"=> "required|string|max:6|min:6",
            "address"=> "required|string|max:500",

        ];
    }
    public function placeOrder()
    {
        $this->validate();
    
        $this->totalProductAmount();
    
        if (!$this->fullname || !$this->email || !$this->phone || !$this->pincode || !$this->address) {
            session()->flash('error', 'Please fill in all required fields correctly.');
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please fill in all required fields correctly.',
                'type' => 'error',
                'status' => 400
            ]);
            return null;
        }
    
        $order = Order::create([
            'user_id'        => auth()->user()->id,
            'tracking_no'    => 'greengrovenest-' . Str::random(10),
            'fullname'       => $this->fullname,
            'email'          => $this->email,
            'phone'          => $this->phone,
            'pincode'        => $this->pincode,
            'address'        => $this->address,
            'status_message' => 'in progress',
            'payment_mode'   => $this->payment_mode,
            'payment_id'     => $this->payment_id,
            'original_price' => round($this->totalProductAmount),
            'discount_price' => round($this->discountAmount),
            'total_amount'   => round($this->finalAmount),
        ]);
    
        // Store user details
        $user = auth()->user();
        UserDetails::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $this->phone,
                'pin_code' => $this->pincode,
                'address' => $this->address,
            ]
        );
    
        foreach ($this->carts as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_color_id' => $cartItem->product_color_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->selling_price
            ]);
        }
    
        return $order; // ✅ This is the key fix
    }
    
    
    

    public function codOrder()
    {
        $this->payment_mode = 'Cash on Delivery'; 
        $order = $this->placeOrder(); // now $order is the returned order object
    
        if ($order) {
    
            cart::where('user_id', auth()->user()->id)->delete();
    
            try {
                Mail::to($order->email)->send(new PlaceOrderMailable($order));
            } catch (\Exception $e) {
                \Log::error("Mail sending failed: " . $e->getMessage());
                session()->flash('message', "Mail sending failed: " . $e->getMessage());
            }
            
    
            session()->flash('message', 'Order placed Successfully');
            $this->dispatchBrowserEvent('message', [
                'text' => 'Order Placed Successfully',
                'type'=> 'success',
                'status' => 200 
            ]);
            return redirect()->to('thank-you');  
        } else {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Something went wrong',
                'type'=> 'error',
                'status' => 500
            ]);
        }
    }
    


    public function totalProductAmount()
    {
        $this->totalProductAmount = 0;
        $this->carts = cart::where('user_id', auth()->user()->id)->get();

        foreach ($this->carts as $cartItem) {
            $this->totalProductAmount += $cartItem->product->selling_price * $cartItem->quantity;
        }

        // Apply coupon discount if a coupon is entered
        if ($this->couponCode) {
            $this->applyCoupon();
        } else {
            $this->discountAmount = 0;
        }

        // Calculate final amount after discount
        $this->finalAmount = $this->totalProductAmount - $this->discountAmount;

        return $this->finalAmount;
    }

    
    public function applyCoupon()
    {
        try {
            // Get current date in MongoDB UTCDateTime format
            $currentDate = new UTCDateTime(now()->timestamp * 1000);
    
            // Find the coupon details
            $coupon = Coupons::where('code', $this->couponCode)
                ->where('is_active', "0") // 0 for active
                ->where('valid_from', '<=', $currentDate)
                ->where('valid_until', '>=', $currentDate)
                ->first();
    
            if ($coupon) {
                // Calculate discount
                $this->discountAmount = ($this->totalProductAmount * floatval($coupon->discount_percentage)) / 100;
    
                // Apply "upto" limit if defined
                if ($coupon->upto_price && $this->discountAmount > floatval($coupon->upto_price)) {
                    $this->discountAmount = floatval($coupon->upto_price);
                }
    
                // Notify the user
                session()->flash('message', "Coupon Applied! You saved ₹" . number_format($this->discountAmount, 2));
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Coupon Applied Successfully!',
                    'type' => 'success',
                    'status' => 200
                ]);
            } else {
                // Invalid or expired coupon
                $this->discountAmount = 0;
                session()->flash('message', "Invalid or Expired Coupon");
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Invalid or Expired Coupon',
                    'type' => 'error',
                    'status' => 400
                ]); 
            }
        } catch (\Exception $e) {
            // Catch any errors and display message
            session()->flash('message', "Something went wrong! Please try again.");
            $this->dispatchBrowserEvent('message', [
                'text' => 'Error: ' . $e->getMessage(),
                'type' => 'error',
                'status' => 500
            ]);
        }
    }
    
    public function onlineOrder()
    {
        $this->payment_mode = 'Razorpay';
        $this->validate();
        
        $this->totalProductAmount();
        $amount = (int) $this->finalAmount;
    
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        try {
            $orderData = [
                'receipt' => 'order_rcptid_' . Str::random(10),
                'amount' => $amount * 100,
                'currency' => 'INR',
                'payment_capture' => 1
            ];
    
            $razorpayOrder = $api->order->create($orderData);
            
            // Store complete order data in session
            session()->put('razorpay_order', [
                'razorpay_order_id' => $razorpayOrder->id,
                'order_data' => [
                    'fullname' => $this->fullname,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'pincode' => $this->pincode,
                    'address' => $this->address,
                    'totalAmount' => $this->totalProductAmount,
                    'discountAmount' => $this->discountAmount,
                    'finalAmount' => $this->finalAmount,
                    'payment_mode' => 'Razorpay',
                    'coupon_code' => $this->couponCode ?? null
                ],
                'cart_ids' => $this->carts->pluck('id')->toArray(),
                'redirect_to' => route('thank-you') // Use named route
            ]);
    
            return redirect()->route('payment.page', ['order_id' => $razorpayOrder->id]);
    
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Error creating Razorpay order: ' . $e->getMessage(),
                'type' => 'error',
                'status' => 500
            ]);
            return null;
        }
    }

    

    public function render()
    {
        $this->fullname = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->phone = auth()->user()->userDetail->phone ?? '';
        $this->pincode = auth()->user()->userDetail->pin_code ?? '';
        $this->address = auth()->user()->userDetail->address ?? '';
        // $this->reset('couponCode');

 


        $this->totalProductAmount = $this->totalProductAmount();
        return view('livewire.frontend.checkout.checkout-show',[
            'totalProductAmount' => $this->totalProductAmount

            

        ]);




    }
}
