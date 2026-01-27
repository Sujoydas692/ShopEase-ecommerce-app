<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function details()
    {
        return $this->hasMany(ProductDetails::class);
    }

    public function sliders()
    {
        return $this->hasMany(ProductSlider::class);
    }

     public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeProductFilter($query, $request)
    {
        if ($request->filled('category_id')){
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('brand_id')){
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('remarks')){
            $query->where('remarks', $request->remarks);
        }
    }
}
