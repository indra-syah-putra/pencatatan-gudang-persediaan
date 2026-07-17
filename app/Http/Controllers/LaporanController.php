<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $validMonths = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        if (!in_array($month, $validMonths)) {
            $month = date('m');
        }

        $barangs = Barang::with('persediaan')->get();

        $allTransactions = Transaksi::select(
                'product_id',
                'transaction_type',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('YEAR(transaction_date) as tx_year'),
                DB::raw('MONTH(transaction_date) as tx_month')
            )
            ->where(function ($q) use ($month, $year) {
                $q->whereYear('transaction_date', '<', $year)
                  ->orWhere(function ($q) use ($month, $year) {
                      $q->whereYear('transaction_date', $year)
                        ->whereMonth('transaction_date', '<=', $month);
                  });
            })
            ->groupBy('product_id', 'transaction_type', 'tx_year', 'tx_month')
            ->get()
            ->groupBy('product_id');

        $reports = [];

        foreach ($barangs as $barang) {
            $txByProduct = $allTransactions->get($barang->id, collect());

            $stokAwal = 0;
            $masuk = 0;
            $keluar = 0;

            foreach ($txByProduct as $tx) {
                $isBeforeMonth = $tx->tx_year < $year || ($tx->tx_year == $year && $tx->tx_month < $month);
                $isCurrentMonth = $tx->tx_year == $year && $tx->tx_month == $month;

                if ($tx->transaction_type === 'in') {
                    if ($isBeforeMonth) $stokAwal += $tx->total_quantity;
                    if ($isCurrentMonth) $masuk += $tx->total_quantity;
                } else {
                    if ($isBeforeMonth) $stokAwal -= $tx->total_quantity;
                    if ($isCurrentMonth) $keluar += $tx->total_quantity;
                }
            }

            if ($stokAwal < 0) $stokAwal = 0;

            $stokAkhir = $stokAwal + $masuk - $keluar;
            if ($stokAkhir < 0) $stokAkhir = 0;

            $nilaiStok = $stokAkhir * $barang->price_per_unit;

            $reports[] = [
                'barang' => $barang,
                'stok_awal' => $stokAwal,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'stok_akhir' => $stokAkhir,
                'nilai_stok' => $nilaiStok,
            ];
        }

        $monthIndo = match($month) {
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
            default => 'Januari',
        };

        return view('laporan.index', compact('reports', 'month', 'year', 'monthIndo'));
    }
}
