<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {

        // Total semua order
        $totalOrders = Order::count();

        // Order pending
        $pendingOrders = Order::where('status', 'pending')->count();

        // Total pendapatan hanya dari order yang sudah dibayar
        $totalRevenue = Order::where('status', '!=', 'pending')
                             ->where('status', '!=', 'cancelled')
                             ->sum('total_amount');

        // Total produk yang aktif
        $totalProducts = Product::where('is_active', true)->count();

        // Total customer yang terdaftar
        $totalCustomers = User::where('role', 'customer')->count();

        // --
        $recentOrders = Order::with('user')
                             ->latest()
                             ->take(5)
                             ->get();

        // Produk yang stoknya <= 10
        $lowStockProducts = Product::where('stock', '<=', 10)
                                   ->where('is_active', true)
                                   ->orderBy('stock', 'asc')
                                   ->take(5)
                                   ->get();

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}