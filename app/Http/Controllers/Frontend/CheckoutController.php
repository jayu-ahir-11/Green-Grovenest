<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Cart; // Add this import
use App\Models\Order; // Add this if using Order model
use Illuminate\Support\Facades\Mail;
use App\Mail\PlaceOrderMailable;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        return view("frontend.checkout.index");
    }

    public function paymentPage($order_id)
    {
        $razorpayOrder = session()->get('razorpay_order');
        
        if (!$razorpayOrder || $razorpayOrder['razorpay_order_id'] !== $order_id) {
            return redirect()->route('checkout')->with('error', 'Invalid payment session. Please try again.');
        }
    
        return view('frontend.checkout.payment', [
            'order_id' => $order_id,
            'amount' => $razorpayOrder['order_data']['finalAmount'] * 100,
            'name' => $razorpayOrder['order_data']['fullname'],
            'email' => $razorpayOrder['order_data']['email'],
            'contact' => $razorpayOrder['order_data']['phone']
        ]);
    }
    
public function verifyPayment(Request $request)
{
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    $sessionData = session()->get('razorpay_order');

    if (!$sessionData) {
        return redirect()->route('checkout')->with('error', 'Session expired. Please try again.');
    }

    try {
        // Verify payment signature
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];
        
        $api->utility->verifyPaymentSignature($attributes);

        // Create the order
        $order = Order::create([
            'user_id' => auth()->id(),
            'tracking_no' => 'greengrovenest-' . Str::random(10),
            'fullname' => $sessionData['order_data']['fullname'],
            'email' => $sessionData['order_data']['email'],
            'phone' => $sessionData['order_data']['phone'],
            'pincode' => $sessionData['order_data']['pincode'],
            'address' => $sessionData['order_data']['address'],
            'status_message' => 'in progress',
            'payment_mode' => 'Razorpay',
            'payment_id' => $request->razorpay_payment_id,
            'original_price' => $sessionData['order_data']['totalAmount'],
            'discount_price' => $sessionData['order_data']['discountAmount'],
            'total_amount' => $sessionData['order_data']['finalAmount'],
        ]);

        // Create order items and clear cart
        $cartItems = Cart::whereIn('id', $sessionData['cart_ids'])
                        ->where('user_id', auth()->id())
                        ->get();
                        
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_color_id' => $item->product_color_id,
                'quantity' => $item->quantity,
                'price' => $item->product->selling_price
            ]);

            // Update inventory with string quantities
        if ($item->product_color_id) {
            $currentQty = (int)$item->productColor->quantity; // Convert to int
            $newQty = $currentQty - (int)$item->quantity; // Perform math
            $item->productColor()->update(['quantity' => (string)$newQty]); // Store back as string
        } else {
            $currentQty = (int)$item->product->quantity; // Convert to int
            $newQty = $currentQty - (int)$item->quantity; // Perform math
            $item->product()->update(['quantity' => (string)$newQty]); // Store back as string
        }

        }


        Cart::where('user_id', auth()->user()->id)->delete();

            try{
                $order = Order::findOrFail($order->id);
                Mail::to("$order->email")->send(new PlaceOrderMailable($order));
            }
            catch(\Exception $e){
                $this->dispatch('message',[
                    'text' => 'Invoice Cannot be send'.$e->getMessage(),
                    'type' => 'error',
                    'status' => 200
                ]);
            }
            return redirect()->to('thank-you')->with('message', 'Payment Successful! Order Placed.');
        } catch (\Exception $e) {
            return redirect()->to('/checkout')->with('message', 'Payment Failed! ' . $e->getMessage());
        }
}

}
