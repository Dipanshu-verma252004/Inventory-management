<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Supplier;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();
        $months = collect(range(5, 0))->map(function ($offset) {
            $date = now()->subMonths($offset)->startOfMonth();

            return [
                'key' => $date->format('Y-m'),
                'label' => $date->format('M Y'),
            ];
        });

        $purchasesByMonth = Purchase::whereDate('purchase_date', '>=', $months->first()['key'] . '-01')
            ->get()
            ->groupBy(fn ($purchase) => Carbon::parse($purchase->purchase_date)->format('Y-m'))
            ->map(fn ($purchases) => (float) $purchases->sum('total_amount'));

        $salesByMonth = Sale::whereDate('sale_date', '>=', $months->first()['key'] . '-01')
            ->get()
            ->groupBy(fn ($sale) => Carbon::parse($sale->sale_date)->format('Y-m'))
            ->map(fn ($sales) => (float) $sales->sum('total_amount'));

        $todaySaleItems = SaleItem::with('product:id,purchase_price')
            ->whereHas('sale', fn ($query) => $query->whereDate('sale_date', $today))
            ->get();

        $dashboard = [
            'totalProducts' => Product::count(),
            'totalCustomers' => Customer::count(),
            'totalSuppliers' => Supplier::count(),
            'totalPurchases' => (float) Purchase::sum('total_amount'),
            'totalSales' => (float) Sale::sum('total_amount'),
            'stockValue' => (float) Product::query()
                ->selectRaw('COALESCE(SUM(opening_stock * purchase_price), 0) as value')
                ->value('value'),
            'todayPurchase' => (float) Purchase::whereDate('purchase_date', $today)->sum('total_amount'),
            'todaySales' => (float) Sale::whereDate('sale_date', $today)->sum('total_amount'),
            'todayProfit' => (float) $todaySaleItems->sum(fn ($item) => $item->subtotal - ($item->quantity * ($item->product->purchase_price ?? 0))),
        ];

        $recentPurchases = Purchase::with('supplier')->latest('purchase_date')->latest('id')->take(5)->get();
        $recentSales = Sale::with('customer')->latest('sale_date')->latest('id')->take(5)->get();
        $lowStockProducts = Product::whereColumn('opening_stock', '<=', 'minimum_stock')
            ->orderBy('opening_stock')
            ->take(10)
            ->get();

        return view('dashboard', [
            'dashboard' => $dashboard,
            'chartLabels' => $months->pluck('label')->values(),
            'purchaseSeries' => $months->map(fn ($month) => $purchasesByMonth->get($month['key'], 0))->values(),
            'salesSeries' => $months->map(fn ($month) => $salesByMonth->get($month['key'], 0))->values(),
            'recentPurchases' => $recentPurchases,
            'recentSales' => $recentSales,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}
