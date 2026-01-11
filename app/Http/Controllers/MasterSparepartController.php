<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterSparepartController extends Controller
{
    /* ================= LIST ================= */
    public function index(Request $request)
    {
        $keyword = $request->q;

        $spareparts = Sparepart::when($keyword, function ($query) use ($keyword) {
            $query->where('kode_sparepart', 'like', "%$keyword%")
                ->orWhere('nama_sparepart', 'like', "%$keyword%");
        })
            ->orderBy('nama_sparepart')
            ->paginate(10)
            ->withQueryString(); // PENTING

        return view('sparepart.index', compact('spareparts', 'keyword'));
    }


    /* ================= CREATE FORM ================= */
    public function create()
    {
        return view('sparepart.create');
    }

    /* ================= STORE ================= */
    public function store(Request $request)
    {
        $request->validate(
            [
                'kode_sparepart' => [
                    'required',
                    Rule::unique('spareparts', 'kode_sparepart')
                ],
                'nama_sparepart' => 'required',
                'stok'           => 'required|integer|min:0',
                'satuan'         => 'required'
            ],
            [
                'kode_sparepart.unique' => 'Kode sparepart sudah terdaftar',
                'kode_sparepart.required' => 'Kode sparepart wajib diisi',
                'nama_sparepart.required' => 'Nama sparepart wajib diisi',
            ]
        );

        Sparepart::create([
            'kode_sparepart' => $request->kode_sparepart,
            'nama_sparepart' => $request->nama_sparepart,
            'stok'           => $request->stok,
            'satuan'         => $request->satuan
        ]);

        return redirect()
            ->route('sparepart.index')
            ->with('success', 'Sparepart berhasil ditambahkan');
    }

    /* ================= EDIT FORM ================= */
    public function edit(Sparepart $sparepart)
    {
        return view('sparepart.edit', compact('sparepart'));
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, Sparepart $sparepart)
    {
        $request->validate(
            [
                'kode_sparepart' => [
                    'required',
                    Rule::unique('spareparts', 'kode_sparepart')->ignore($sparepart->id)
                ],
                'nama_sparepart' => 'required',
                'stok'           => 'required|integer|min:0',
                'satuan'         => 'required'
            ],
            [
                'kode_sparepart.unique' => 'Kode sparepart sudah digunakan',
            ]
        );

        $sparepart->update([
            'kode_sparepart' => $request->kode_sparepart,
            'nama_sparepart' => $request->nama_sparepart,
            'stok'           => $request->stok,
            'satuan'         => $request->satuan
        ]);

        return redirect()
            ->route('sparepart.index')
            ->with('success', 'Data sparepart berhasil diperbarui');
    }

    /* ================= DELETE ================= */
    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();

        return back()->with('success', 'Sparepart berhasil dihapus');
    }
}
