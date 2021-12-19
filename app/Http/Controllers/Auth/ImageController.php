<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Services\ImageRecognitionService;
use App\Http\Services\VoucherService;


use App\Models\Customer;
use App\Models\Voucher;

class ImageController extends Controller
{
    public function validateImage(Request $request, ImageRecognitionService $imageService)
    {
        $campaign_id = $request->campaign_id;
        $authId = Auth::id();
        $fakeImageFile = $request->has_fake_image;

        if (empty($campaign_id)) {
            return response()->json([
                'status' => 'error',
                'data' => 'campaign_id = 1'
            ], 200);
        }

        if (empty($fakeImageFile)) {
            return response()->json([
                    'status' => 'error',
                    'data' => 'has_fake_image = 1'
                ], 200);
        }

        $isImageValid = $imageService->validateImage($fakeImageFile);

        if (! $isImageValid) {
            return response()->json([
                    'status' => 'error',
                    'data' => 'image not recognize.'
                ], 200);
        }

        $voucher = Voucher::where('campaign_id', $campaign_id)
                            ->where('status', 'available')
                            ->whereHas('customers', function ($query) use ($authId) {
                                $query->where('customers.id', $authId);
                            })
                            ->orderBy('locked_until', 'DESC')
                            ->first();
         
        if (empty($voucher)) {
            return response()->json([
                    'status' => 'error',
                    'data' => 'No locked voucher for this user.'
                ], 200);
        }
        $voucherService = new VoucherService($voucher);


        if ($voucherService->isVoucherStillLocked($authId)) {
            $updateVoucher = $voucherService->updateVoucherStatus('used');
            return response()->json([
                    'status' => 'success',
                    'data' => $updateVoucher
                ], 200);
        } else {
            return response()->json([
                    'status' => 'error',
                    'data' => 'Voucher expired ('.$voucher->locked_until.') : 10 mins allocation exceeds.'
                ], 200);
        }
    }
}
