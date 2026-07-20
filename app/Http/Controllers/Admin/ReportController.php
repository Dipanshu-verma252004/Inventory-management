<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function stock(Request $request)
    {
        $query = Product::with([
            'category',
            'brand',
            'unit'
        ]);

        if ($request->filled('search')) {

            $query->where('product_name', 'like', '%' . $request->search . '%');

        }

        if ($request->filled('category_id')) {

            $query->where('category_id', $request->category_id);

        }

        if ($request->filled('brand_id')) {

            $query->where('brand_id', $request->brand_id);

        }

        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::where('status', 1)->get();

        $brands = Brand::where('status', 1)->get();

        return view('reports.stock', compact(
            'products',
            'categories',
            'brands'
        ));
    }

    public function purchase(Request $request)
    {
        $query = Purchase::with('supplier');

        if ($request->filled('supplier_id')) $query->where('supplier_id', $request->supplier_id);
        if ($request->filled('from_date')) $query->whereDate('purchase_date', '>=', $request->from_date);
        if ($request->filled('to_date')) $query->whereDate('purchase_date', '<=', $request->to_date);

        $totals = (clone $query)->selectRaw('COALESCE(SUM(total_amount), 0) as total, COALESCE(SUM(paid_amount), 0) as paid, COALESCE(SUM(due_amount), 0) as due')->first();
        $purchases = $query->latest('purchase_date')->paginate(20)->withQueryString();
        $suppliers = Supplier::where('status', 1)->orderBy('supplier_name')->get();

        return view('reports.purchase', compact('purchases', 'suppliers', 'totals'));
    }

    public function sales(Request $request)
    {
        $query = Sale::with('customer');

        if ($request->filled('customer_id')) $query->where('customer_id', $request->customer_id);
        if ($request->filled('from_date')) $query->whereDate('sale_date', '>=', $request->from_date);
        if ($request->filled('to_date')) $query->whereDate('sale_date', '<=', $request->to_date);

        $totals = (clone $query)->selectRaw('COALESCE(SUM(total_amount), 0) as total, COALESCE(SUM(paid_amount), 0) as paid, COALESCE(SUM(due_amount), 0) as due')->first();
        $sales = $query->latest('sale_date')->paginate(20)->withQueryString();
        $customers = Customer::where('status', 1)->orderBy('customer_name')->get();

        return view('reports.sales', compact('sales', 'customers', 'totals'));
    }

    public function lowStock()
    {
        $products = Product::with(['category', 'brand', 'unit'])
            ->whereColumn('opening_stock', '<=', 'minimum_stock')
            ->orderBy('opening_stock')
            ->paginate(20);

        return view('reports.low_stock', compact('products'));
    }

    public function profit(Request $request)
    {
        $query = Sale::with(['customer', 'items.product']);

        if ($request->filled('from_date')) $query->whereDate('sale_date', '>=', $request->from_date);
        if ($request->filled('to_date')) $query->whereDate('sale_date', '<=', $request->to_date);

        $profitTotals = (object) ['revenue' => 0, 'cost' => 0, 'profit' => 0];

        foreach ((clone $query)->get() as $sale) {
            $sale->cost_amount = $sale->items->sum(fn ($item) => $item->quantity * ($item->product?->purchase_price ?? 0));
            $sale->profit_amount = $sale->total_amount - $sale->cost_amount;
            $profitTotals->revenue += $sale->total_amount;
            $profitTotals->cost += $sale->cost_amount;
            $profitTotals->profit += $sale->profit_amount;
        }

        $sales = $query->latest('sale_date')->paginate(20)->withQueryString();

        foreach ($sales as $sale) {
            $sale->cost_amount = $sale->items->sum(fn ($item) => $item->quantity * ($item->product?->purchase_price ?? 0));
            $sale->profit_amount = $sale->total_amount - $sale->cost_amount;
        }

        return view('reports.profit', compact('sales', 'profitTotals'));
    }
}
