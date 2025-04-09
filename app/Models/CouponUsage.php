<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class CouponUsage extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'coupon_usages';
    protected $fillable = [
        'user_id',
        'coupon_id',
        'order_id',
    ];


            // In User model
        public function couponUsages()
        {
            return $this->hasMany(CouponUsage::class);
        }

        // In Coupon model
        public function usages()
        {
            return $this->hasMany(CouponUsage::class);
        }

        // In Order model
        public function couponUsage()
        {
            return $this->hasOne(CouponUsage::class);
        }
}
