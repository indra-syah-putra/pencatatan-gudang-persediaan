<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\Persediaan;

class TransaksiController extends Controller
{
    public function create()
    {
        $barangs = Barang::with('persediaan')->get();
        return view('transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:in,out',
            'product_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            $barang = Barang::find($validated['product_id']);
            $totalPrice = $barang->price_per_unit * $validated['quantity'];

            $persediaan = Persediaan::firstOrNew(
                ['product_id' => $validated['product_id']]
            );

            if ($validated['transaction_type'] == 'out') {
                if (($persediaan->quantity ?? 0) < $validated['quantity']) {
                    return back()->with('error', 'Stok tidak mencukupi!');
                }
                $persediaan->quantity -= $validated['quantity'];
            } else {
                $persediaan->quantity = ($persediaan->quantity ?? 0) + $validated['quantity'];
            }

            if (!$persediaan->exists) {
                $persediaan->fill([
                    'warehouse_location' => 'Gudang Utama',
                    'entry_date' => now(),
                ]);
            }
            $persediaan->save();

            Transaksi::create([
                'transaction_date' => $validated['transaction_date'],
                'transaction_type' => $validated['transaction_type'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'total_price' => $totalPrice,
            ]);

            return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan.');
        });
    }
}