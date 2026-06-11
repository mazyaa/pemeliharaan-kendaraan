<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SpkService;

class SpkController extends Controller
{
    public function __construct(protected SpkService $service) {}

    public function index()
    {
        $filters = request()->only(['search']);
        $spk = $this->service->paginated($filters, (int) request('perPage', 10));
        return view('admin.spk.index', compact('spk'));
    }
}
