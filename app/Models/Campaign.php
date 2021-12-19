<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Voucher;

class Campaign extends Model
{
    use HasFactory;
    
    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
