<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Bill;

class Category extends Model
{
    use HasFactory;

    public function bills():HasMany
    {
        return $this->hasMany(Bill::class);
    }
}
