<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

// SoftDelete
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    // use softdeletes
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    //
    protected $fillable = [
        'name',
        'description'
    ];

    public function products() {
        return $this->belongsToMany(Product::class);
    }
}
