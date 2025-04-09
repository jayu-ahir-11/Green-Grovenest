<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blogs extends Model
{
    use HasFactory;
    protected $connection = 'mongodb'; 
    protected $collection = 'blogs'; 
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
