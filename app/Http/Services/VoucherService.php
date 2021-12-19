<?php
declare(strict_types=1);

namespace App\Http\Services;

use Illuminate\Support\Collection;
use Carbon\Carbon;

use App\Models\Customer;
use App\Models\PurchaseTransaction;
use App\Models\Voucher;

class VoucherService
{
    /**
     * Voucher
     *
     * @var Voucher
     */
    public $voucher;

    /**
     * Constructor
     *
     * @param Voucher $voucher
     */
    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
        $voucherStatus = $this->voucher->status;
    }


    /**
     * Is vouched still locked?
     *
     * @param id customer_id
     *
     * @return boolean
     */
    public function isVoucherStillLocked($customer_id): bool
    {
        $voucher = $this->voucher;

        if ($voucher->locked_until < Carbon::now()) {

            /* if expired.
            * Remove this voucher relation to the customer
            */
            $voucher->customers()->detach($customer_id);

            return false;
        } else {
            return true;
        }
    }

    /**
     * Is vouched still locked?
     *
     * @param string status
     *
     * @return boolean
     */
    public function updateVoucherStatus($status): Voucher
    {
        $voucher = $this->voucher;
        
        $voucher->status = $status;
        $voucher->save();

        return $voucher;
    }
}
