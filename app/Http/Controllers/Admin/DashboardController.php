<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $sellerCount = User::where('role', 'seller')->count();
        $layananCount = User::where('role', 'layanan')->count();
        $adminCount = User::whereIn('role', ['admin', 'superadmin'])->count();
        $activeUserCount = User::where('is_active', true)->count();
        $inactiveUserCount = User::where('is_active', false)->count();

        $menuCount = Menu::count();
        $lapakBuka = User::where('role', 'seller')->where('lapak_buka', true)->count();
        $serviceCount = Service::count();
        $serviceTersedia = Service::where('status', 'tersedia')->count();
        $serviceSibuk = Service::where('status', 'sibuk')->count();

        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'userCount',
            'sellerCount',
            'layananCount',
            'adminCount',
            'activeUserCount',
            'inactiveUserCount',
            'menuCount',
            'lapakBuka',
            'serviceCount',
            'serviceTersedia',
            'serviceSibuk',
            'recentUsers'
        ));
    }
}
