<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterJenisPemeliharaan;
use Illuminate\Http\Request;

class JenisPemeliharaanController extends Controller
{
    public function index()
    {
        $search = request('search');
        $query = MasterJenisPemeliharaan::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $jenis = $query->latest()->paginate((int) request('perPage', 10))->withQueryString();
        return view('admin.jenis-pemeliharaan.index', compact('jenis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'nama' => 'required|string|max:200',
            'interval_hari' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        MasterJenisPemeliharaan::create($validated);
        return redirect()->route('admin.jenis-pemeliharaan.index')->with('success', 'Jenis pemeliharaan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'nama' => 'required|string|max:200',
            'interval_hari' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string|max:500',
            'is_active' => 'sometimes|boolean',
        ]);

        $jenis = MasterJenisPemeliharaan::findOrFail($id);
        $jenis->update($validated);
        return redirect()->route('admin.jenis-pemeliharaan.index')->with('success', 'Jenis pemeliharaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenis = MasterJenisPemeliharaan::findOrFail($id);
        $jenis->delete();
        return redirect()->route('admin.jenis-pemeliharaan.index')->with('success', 'Jenis pemeliharaan berhasil dihapus');
    }
}
