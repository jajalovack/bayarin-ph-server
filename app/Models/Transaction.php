<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Bill;
use App\Models\Paymentmethod;
use App\Models\Transactionstatus;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_id',
        'payor_id',
        'paymentmethod_id',
        'transactionstatus_id'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bill():BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }

    public function paymentmethod():BelongsTo
    {
        return $this->belongsTo(Paymentmethod::class);
    }

    public function transactionstatus():BelongsTo
    {
        return $this->belongsTo(Transactionstatus::class);
    }
}
