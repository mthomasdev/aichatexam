<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Campaign;
use App\Models\Customer;

class Voucher extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customers()
    {
        return $this->belongsToMany(Customer::class)->withTimestamps();
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
