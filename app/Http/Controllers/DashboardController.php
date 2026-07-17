<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Barang::count();
        $barangs = Barang::with('persediaan')->latest()->get();
        $lowStockCount = $barangs->filter(fn($item) => ($item->persediaan?->quantity ?? 0) <= $item->min_stock)->count();

        return view('dashboard', compact('barangs', 'totalItems', 'lowStockCount'));
    }
}
