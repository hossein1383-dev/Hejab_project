<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class Product extends Model
{
    protected $table = 'products';

    protected $appends = ['is_sale'];
    protected $casts = [
        'date_on_sale_from' => 'datetime',
        'date_on_sale_to' => 'datetime',
    ];

    public function getIsSaleAttribute()
    {
        return $this->quantity > 0 && $this->sale_price !== 0 && $this->sale_price !== null && $this->date_on_sale_from < Carbon::now() && $this->date_on_sale_to > Carbon::now();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function scopeFilter($query)
    {
        if (request()->filled('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        if (request()->filled('category')) {
            $query->where('category_id', request('category'));
        }

        if (request()->filled('sortBy')) {
            switch (request('sortBy')) {
                case 'max':
                    $query->orderByDesc('price');
                    break;

                case 'min':
                    $query->orderBy('price');
                    break;

                case 'sale':
                    $query->where('sale_price', '!=', 0)->where('date_on_sale_from', '<=', now())->where('date_on_sale_to', '>=', now());
                    break;
                case 'bestseller':
                    $query->orderByDesc('sold_count');
                    break;
            }
        }

        return $query;
    }
}
