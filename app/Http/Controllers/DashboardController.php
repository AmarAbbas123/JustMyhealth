<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $deviceType = DB::table('sys_device_details_history')
            ->select('DeviceType as label', DB::raw('COUNT(*) as total'))
            ->groupBy('DeviceType')
            ->get();

        $deviceOS = DB::table('sys_device_details_history')
            ->select('DeviceOS as label', DB::raw('COUNT(*) as total'))
            ->groupBy('DeviceOS')
            ->get();

        $browser = DB::table('sys_device_details_history')
            ->select('DeviceBrowser as label', DB::raw('COUNT(*) as total'))
            ->groupBy('DeviceBrowser')
            ->get();

        $userAction = DB::table('sys_device_details_history')
            ->select('UserAction as label', DB::raw('COUNT(*) as total'))
            ->groupBy('UserAction')
            ->get();

        return view('dashboard', compact(
            'deviceType','deviceOS','browser','userAction'
        ));
    }
}
