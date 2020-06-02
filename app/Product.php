<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Seller;
use App\Transaction;

// Soft Deletes
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    // use softdeletes
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // hidden fields
    protected $hidden = [
        'pivot'
    ];

    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    public function isAvaliable () {
        return $this->status === Product::AVAILABLE_PRODUCT;
    }

    public function seller() {
        return $this->belongsTo(Seller::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function categories () {
        return $this->belongsToMany(Category::class);
    }
}
