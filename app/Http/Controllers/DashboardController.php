<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service) {}

    public function index()
    {
        $stats = $this->service->getAdminStats();
        $chartData = $this->service->getChartData();
        $recentPengajuan = $this->service->getRecentPengajuan(5);

        return view('dashboard', compact('stats', 'chartData', 'recentPengajuan'));
    }
}