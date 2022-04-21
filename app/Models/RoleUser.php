<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'role_user';
    protected $fillable = ['role_id', 'user_id'];

    public function getuser(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getrole(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }


    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query
                ->orWhereHas('getuser', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                })->orWhereHas('getuser', function ($query) use ($term) {
                    $query->where('email', 'like', $term);
                })->orWhereHas('getrole', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                });
        });
    }
}
