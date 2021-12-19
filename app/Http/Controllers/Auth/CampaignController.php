<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Campaign;

class CampaignController extends Controller
{
    public function campaigns()
    {
        $campagins = Campaign::where('is_active', true)
                                ->get();
        
        return response()->json([
            'success' => true,
            'data' => $campagins
        ]);
    }

    public function ongoingCampaigns()
    {
        $campagins = Campaign::whereDate('start_at', '<=', Carbon::now())
                                ->whereDate('end_at', '>=', Carbon::now())
                                ->where('is_active', true)
                                ->get();
        
        return response()->json([
            'success' => true,
            'data' => $campagins
        ]);
    }
}
