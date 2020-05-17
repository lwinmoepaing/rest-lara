<?php

namespace App;

use App\Transaction;
use App\User;

class Buyer extends User
{
    //
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
