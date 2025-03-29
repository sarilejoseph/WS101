<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
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
     * Generate a printable inventory report
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function print()
    {
        $items = Item::all();
        $totalCost = $items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        
        $now = now();
        
        return view('inventory.print', [
            'items' => $items,
            'totalCost' => $totalCost,
            'printDate' => $now->format('F d, Y'),
            'printTime' => $now->format('h:i A')
        ]);
    }
}