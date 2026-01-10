<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;


class MasterSparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::latest()->paginate(10);
        return view('sparepart.index', compact('spareparts'));
    }

    public function create()
    {
        return view('sparepart.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_sparepart' => 'required',
            'nama_sparepart' => 'required',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required'
        ]);

        Sparepart::create($request->all());

        return redirect()
            ->route('sparepart.index')
            ->with('success','Sparepart berhasil ditambahkan');
    }

    public function edit(Sparepart $sparepart)
    {
        return view('sparepart.edit', compact('sparepart'));
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $request->validate([
            'kode_sparepart' => 'required'.$sparepart->id,
            'nama_sparepart' => 'required',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required'
        ]);

        $sparepart->update($request->all());

        return redirect()
            ->route('sparepart.index')
            ->with('success','Sparepart diperbarui');
    }

    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();
        return back()->with('success','Sparepart dihapus');
    }
}
