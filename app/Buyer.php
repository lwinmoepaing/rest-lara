<?php

namespace App;

use App\Transaction;
use App\User;

// Scope
use App\Scopes\BuyerScope;

class Buyer extends User
{
    protected static function boot() {
        parent::boot();

        static::addGlobalScope(new BuyerScope);
    }

    // Buyer Has many Transactions
    // Has Many Relationship
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
