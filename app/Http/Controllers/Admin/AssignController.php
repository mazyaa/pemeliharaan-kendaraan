<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\User;
use App\Enums\RoleEnum;
use App\Repositories\KendaraanRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AssignController extends Controller
{
    public function __construct(
        protected KendaraanRepository $kendaraanRepo,
        protected UserRepository $userRepo
    ) {}

    public function index()
    {
        $filters = request()->only(['search']);
        $kendaraan = $this->kendaraanRepo->paginated($filters, (int) request('perPage', 10));
        $pengajuList = User::whereHas('role', function($q) {
            $q->where('name', RoleEnum::PENGAJU_KENDARAAN->value);
        })->where('is_active', true)->get();
        return view('admin.assign.index', compact('kendaraan', 'pengajuList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'pengaju_id' => 'required|exists:users,id',
        ]);

        $kendaraan = Kendaraan::findOrFail($validated['kendaraan_id']);

        // Check if this pengaju already has another vehicle assigned
        $existingAssignment = Kendaraan::where('pengaju_id', $validated['pengaju_id'])
            ->where('id', '!=', $kendaraan->id)
            ->first();
        if ($existingAssignment) {
            throw ValidationException::withMessages([
                'pengaju_id' => 'Pengaju ini sudah memiliki kendaraan ('
                    . $existingAssignment->plat_nomor . ' - '
                    . $existingAssignment->merk . ' ' . $existingAssignment->tipe
                    . '). Satu pengaju hanya dapat memiliki satu kendaraan.',
            ]);
        }

        // Check if this vehicle already has a different pengaju assigned
        if ($kendaraan->pengaju_id && $kendaraan->pengaju_id != $validated['pengaju_id']) {
            throw ValidationException::withMessages([
                'kendaraan_id' => 'Kendaraan ini sudah diassign ke pengaju lain.',
            ]);
        }

        $kendaraan->update(['pengaju_id' => $validated['pengaju_id']]);

        return redirect()->route('admin.assign.index')->with('success', 'Pengaju berhasil diassign ke kendaraan');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->update(['pengaju_id' => null]);
        return redirect()->route('admin.assign.index')->with('success', 'Assignment berhasil dihapus');
    }
}
