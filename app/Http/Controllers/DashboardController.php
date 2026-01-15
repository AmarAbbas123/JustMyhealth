<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all leads grouped by region
        $regions = DB::table('leads')
            ->select('region')
            ->distinct()
            ->pluck('region');

        $charts = [];

        foreach($regions as $region){
            $data = DB::table('leads')
                ->where('region', $region)
                ->get();

            $labels = $data->pluck('source');
            $values = $data->pluck('value');

            $charts[] = [
                'region' => $region,
                'labels' => $labels,
                'values' => $values
            ];
        }

        return view('dashboard', compact('charts'));
    }
}
