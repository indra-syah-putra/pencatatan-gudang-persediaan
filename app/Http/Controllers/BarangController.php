<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->paginate(10);
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|unique:barangs,code',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'unit_of_measure' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric',
            'min_stock' => 'required|integer',
        ]);

        Barang::create($validated);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    // --- EDIT & UPDATE ---
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        
        $validated = $request->validate([
            'code' => ['nullable', 'string', 'max:100', Rule::unique('barangs', 'code')->ignore($barang->id)->withoutTrashed()],
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'unit_of_measure' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric',
            'min_stock' => 'required|integer',
        ]);

        $barang->update($validated);
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    // --- HAPUS ---
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus.');
    }
}