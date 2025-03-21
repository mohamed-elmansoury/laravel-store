<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'price',
        'compare_price',
        'options',
        'rating',
        'featured',
        'status',
    ];

    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
    }

    
    public function category()  {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    
    public function store()  {
        return $this->belongsTo(Store::class,'store_id','id');
    }
}
