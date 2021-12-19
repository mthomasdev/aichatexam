<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\Customer;

class PurchaseTransaction extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    /**
     * Get total transaction from paramns
     *
     * @param  id customer_id,
     * @param  int days,
     *
     * @return int count
     */
    public static function getTotalTransactionFromPassedDays($authId, $days)
    {
        $result = PurchaseTransaction::where('customer_id', $authId)
                                        ->whereDate('transaction_at', '>=', Carbon::now()->subDays($days))
                                        ->count();
        return $result;
    }

    /**
     * Get sum of transaction from paramns
     *
     * @param  id customer_id,
     * @param  int days,
     *
     * @return int sum
     */
    public static function getSumTransactionFromPassedDays($authId, $days)
    {
        $result = PurchaseTransaction::where('customer_id', $authId)
                                        ->whereDate('transaction_at', '>=', Carbon::now()->subDays($days))
                                        ->sum('total_spent');
        return $result;
    }
}
