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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Validate query parameters
        $request->validate([
            'search_name' => 'nullable|string|max:255',
            'max_quantity' => 'nullable|numeric|min:0',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
        ]);

        // Get total items count
        $totalItems = Item::count();
        
        // Get total quantity of items
        $totalQuantity = Item::sum('quantity');
        
        // Get total inventory value
        $totalValue = Item::select(DB::raw('SUM(quantity * price) as value'))->first()->value ?? 0;
        
        // Build advanced query
        $query = Item::query();

        // Apply search filters if provided
        if ($request->filled('search_name')) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }

        if ($request->filled('max_quantity')) {
            $query->where('quantity', '<=', $request->max_quantity);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // If no search parameters, get recent items; otherwise, get filtered results
        if (!$request->filled(['search_name', 'max_quantity', 'min_price', 'max_price'])) {
            $recentItems = $query->orderBy('created_at', 'desc')->take(5)->get();
        } else {
            $recentItems = $query->orderBy('created_at', 'desc')->get();
        }
        
        return view('dashboard', [
            'totalItems' => $totalItems,
            'totalQuantity' => $totalQuantity,
            'totalValue' => $totalValue,
            'recentItems' => $recentItems,
        ]);
    }
}