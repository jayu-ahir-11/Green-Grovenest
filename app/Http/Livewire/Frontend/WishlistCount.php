<?php

namespace App\Http\Livewire\Frontend;


use App\Models\wishlists;
use Auth;
use Livewire\Component;


class WishlistCount extends Component
{
    public $wishlistCount;

   // wishlistAddedUpdated
   protected $listeners = ['wishlistAddedUpdated' => 'checkWishlistCount'];

    public function checkWishlistCount()
    {
    
         if(Auth::check()){
             return $this->wishlistCount = wishlists::where('user_id', auth()->user()->id)->count();
         }
         else{
            return $this->wishlistCount = 0;
         }
    }
    public function render()
    {
        $this->wishlistCount =  $this->checkWishlistCount();
        return view('livewire.frontend.wishlist-count',[
            'wishlistCount' => $this->wishlistCount
        ]);

    }
}
