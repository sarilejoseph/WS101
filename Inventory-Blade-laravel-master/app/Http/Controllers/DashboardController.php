<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get total items count
        $totalItems = Item::count();
        
        // Get total quantity of items
        $totalQuantity = Item::sum('quantity');
        
        // Get total inventory value
        $totalValue = Item::select(DB::raw('SUM(quantity * price) as value'))->first()->value ?? 0;
        
        // Get 5 most recently added items
        $recentItems = Item::orderBy('created_at', 'desc')->take(5)->get();
        
        return view('dashboard', [
            'totalItems' => $totalItems,
            'totalQuantity' => $totalQuantity,
            'totalValue' => $totalValue,
            'recentItems' => $recentItems,
        ]);
    }
}