<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buyer;
use App\Product;

// Soft Deletes
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{

    // use softdeletes
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    //
    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id'
    ];

    public function buyer() {
        return $this->belongsTo(Buyer::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
