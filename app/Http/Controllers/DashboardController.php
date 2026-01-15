<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Load dashboard
    public function index()
    {
        $data = DB::table('leads')->get();
        $labels = $data->pluck('source');
        $values = $data->pluck('value');

        return view('dashboard', compact('labels', 'values', 'data'));
    }

    // Update lead value via AJAX
    public function updateLead(Request $request)
    {
        DB::table('leads')
            ->where('id', $request->id)
            ->update(['value' => $request->value]);

        return response()->json(['success' => true]);
    }

    // Add new lead source via AJAX
    public function addLead(Request $request)
    {
        $request->validate([
            'source' => 'required|string|max:50',
            'value' => 'required|integer|min:0'
        ]);

        $id = DB::table('leads')->insertGetId([
            'source' => $request->source,
            'value' => $request->value
        ]);

        return response()->json(['success' => true, 'id' => $id]);
    }
}
