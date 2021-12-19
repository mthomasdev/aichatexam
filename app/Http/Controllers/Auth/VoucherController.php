<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Customer;
use App\Models\PurchaseTransaction;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function getVoucher(Request $request)
    {
        $campaign_id = $request->campaign_id;
        $authId = Auth::id();

        if (empty($campaign_id)) {
            return response()->json([
                'status' => 'error',
                'data' => 'campaign_id is required.'
            ], 200);
        }

        $totalTransactionsCriteria = PurchaseTransaction::getTotalTransactionFromPassedDays($authId, 30);
       
        $sumTransactionsCriteria = PurchaseTransaction::getSumTransactionFromPassedDays($authId, 30);

        $customerVoucherCount = Customer::checkUserHasVoucher($authId, $campaign_id);
       
        $criteria = [];

        $criteria1 = [
            'desc'          => 'Complete 3 purchase transactions within the last 30 days.',
            'value'         => $totalTransactionsCriteria,
            'is_eligable'   => $totalTransactionsCriteria >= 3 ? true : false
        ];

        $criteria2 = [
            'desc'          => 'Total transactions equal or more than $100.',
            'value'         => $sumTransactionsCriteria,
            'is_eligable'   => $sumTransactionsCriteria >= 100 ? true : false

        ];

        $criteria3 = [
            'desc'          => 'Each customer is allowed to redeem 1 cash voucher only.',
            'value'         => $customerVoucherCount,
            'is_eligable'   => $customerVoucherCount == 0 ? true : false

        ];
     

        array_push($criteria, $criteria1);
        array_push($criteria, $criteria2);
        array_push($criteria, $criteria3);

        $isUserEligible = false;

        if ($totalTransactionsCriteria >= 3 && $sumTransactionsCriteria >= 100  && $customerVoucherCount == 0) {
            $isUserEligible = true;

            $assignVoucher = $this->assignVoucherToUser(); //Assign a voucher to user and lock for 10 mins

            $return = [
                'status'    => 'success',
                'payload'   => [
                    'voucher'           => $assignVoucher,
                    'is_user_eligible'  => $isUserEligible,
                    'data'              => $criteria
                ]
               
            ];
        } else {
            $return = [
                'status' => 'success',
                'payload'   => [
                    'is_user_eligible'  => $isUserEligible,
                    'data' => $criteria
                ]
                
            ];
        }

        return response()->json($return, 200);
    }

    private function assignVoucherToUser()
    {
        $authId = Auth::id();

        $validUntil = Carbon::now()->addMinutes(10);
        $randomVoucher = tap(Voucher::where('status', '=', 'available')
                                ->orWhere('locked_until', '<', Carbon::now())
                                ->inRandomOrder()
                                ->first())
                                ->update([
                                    'locked_until' =>  $validUntil
                                ]);
        $customer = Customer::find($authId);
        $customer->vouchers()->attach($randomVoucher->id);

        return [
            'code'          => $randomVoucher->code,
            'locked_until'  => $validUntil->format('Y-m-d h:i:s')
        ];
    }
}
