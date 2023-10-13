<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Transaction;

class Transactionstatus extends Model
{
    use HasFactory;

    public function transactions():HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
