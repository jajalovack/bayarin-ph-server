<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Biller;
use App\Models\Category;
use App\Models\Billstatus;
use App\Models\Transaction;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function biller():BelongsTo
    {
        return $this->belongsTo(Biller::class);
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function billstatus():BelongsTo
    {
        return $this->belongsTo(Billstatus::class);
    }

    public function transactions():HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
