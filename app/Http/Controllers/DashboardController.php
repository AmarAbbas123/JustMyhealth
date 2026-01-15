<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = DB::table('leads')
            ->select('source', DB::raw('count(*) as total'))
            ->groupBy('source')
            ->get();

        $totalLeads = $data->sum('total');

        $labels = [];
        $values = [];

        foreach ($data as $row) {
            $labels[] = $row->source;
            $values[] = round(($row->total / $totalLeads) * 100, 2);
        }

        return view('dashboard', compact('labels', 'values'));
    }
}
