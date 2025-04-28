<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['user_id', 'cookie_id', 'product_id', 'options', 'quantity'];

    protected static function booted()
    {
         static::observe(CartObserver::class);

    }

    public function user()
    {

        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous',
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
