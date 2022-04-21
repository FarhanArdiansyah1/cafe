<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderp extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'cart';
    protected $fillable = ['product_id', 'quantity', 'order_id'];

    public function getorder(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function getproduct(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('quantity', 'like', $term)
                ->orWhere('product_id', 'like', $term);
        });
    }
}
