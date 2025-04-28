<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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

    protected static function boot()
    {
        parent::boot();

        // إضافة الجلوبال سكوپ الخاص بالمخزن

        static::addGlobalScope('store', new StoreScope());

        // توليد `slug` تلقائيًا عند إنشاء المنتج

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    
    public function category()  {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    
    public function store()  {
        return $this->belongsTo(Store::class,'store_id','id');
    }

    //many to many relation with product model
    public function tags(){
        return $this->belongsToMany(
            tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id',

        );
        
    }
    //local scope for active products
   
    public function scopeActive(Builder $builder)
    {
        return $builder->where('status', 'active');

    }

   public function getImageUrlAttribute()  {
    if(!$this->image){
        return 'https://www.incathlab.com/images/products/default_product.png';
    }
    if (Str::startsWith($this->image, ['http://', 'https://'])) {
        return 'https://www.incathlab.com/images/products/default_product.png';
    }
    
    return asset('storage/' . $this->image);

}

public function getSalePercentAttribute()
{
    if (!$this->compare_price) {
        return 0;
    }
    return round(100 - (100 * $this->price / $this->compare_price), 1);
}

}
