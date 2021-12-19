<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;


use App\Models\Voucher;
use App\Models\PurchaseTransaction;
use App\Models\Customer;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function purchaseTransactions()
    {
        return $this->hasMany(PurchaseTransaction::class);
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class)->withTimestamps();
    }


    /**
     * Check user voucher
     *
     * @param  id customer_id,
     * @param  id campaign_id,
     *
     * @return int sum
     */
    public static function checkUserHasVoucher($authId, $campaign_id)
    {
        $result = Customer::where('id', $authId)
                                    ->whereHas('vouchers', function ($query) use ($campaign_id) {
                                        $query->where('campaign_id', $campaign_id);
                                        $query->where('status', 'used');
                                        $query->orWhere('locked_until', '>', Carbon::now());
                                    })->count();

        return $result;
    }
}
