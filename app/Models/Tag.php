<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected $fillable=['name','slug'];

            

    public function products(){
        return $this->belongsToMany(
            Product::class,     // Related Model
            'product_tag',      // Pivot table name
            'tag_id',           // FK in pivot table for the current model
            'product_id',       // FK in pivot table for the related model
            'id',               // PK current model
            'id'                 // PK related  model 
        );
    }
}
