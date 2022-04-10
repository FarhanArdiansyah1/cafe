<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'customer_table', 'user_id', 'total'];

    public function products()
    {
    	return $this->belongsToMany(Product::class);
    }

    public function getuser(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getorderproduct(){
        return $this->belongsTo(Orderp::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('customer_table', 'like', $term)
                ->orWhere('customer_name', 'like', $term)
                ->orWhere('created_at', 'like', $term)
                ->orWhereHas('getuser', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                });
        });
    }
}
