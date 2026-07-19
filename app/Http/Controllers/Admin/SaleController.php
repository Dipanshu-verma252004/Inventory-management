<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Http\Requests\SaleRequest;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer']);

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('sale_no', 'like', "%{$request->search}%")
                ->orWhere('invoice_no', 'like', "%{$request->search}%");

            });

        }

        if ($request->filled('customer_id')) {

            $query->where('customer_id', $request->customer_id);

        }

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        if ($request->filled('from_date')) {

            $query->whereDate('sale_date', '>=', $request->from_date);

        }

        if ($request->filled('to_date')) {

            $query->whereDate('sale_date', '<=', $request->to_date);

        }

        $sales = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $customers = Customer::where('status',1)->get();

        return view('sales.index', compact(
            'sales',
            'customers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('status', 1)->orderBy('customer_name')->get();
        $products = Product::where('status', 1)->orderBy('product_name')->get();

        return view('sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleRequest $request)
    {
        DB::transaction(function () use ($request) {

            [$items, $total] = $this->prepareItems($request);
            $paidAmount = (float) ($request->paid_amount ?? 0);

            if ($paidAmount > $total) {
                throw ValidationException::withMessages([
                    'paid_amount' => 'Paid amount cannot be greater than total amount.',
                ]);
            }

            $sale = Sale::create([

                'customer_id' => $request->customer_id,

                'sale_no' => $this->generateNumber('SAL'),

                'invoice_no' => $request->invoice_no ?: $this->generateNumber('INV'),

                'sale_date' => $request->sale_date,

                'total_amount' => $total,

                'paid_amount' => $paidAmount,

                'due_amount' => $total - $paidAmount,

                'status' => $request->status,

            ]);

            foreach ($items as $item) {

                SaleItem::create([

                    'sale_id' => $sale->id,

                    'product_id' => $item['product']->id,

                    'quantity' => $item['quantity'],

                    'selling_price' => $item['selling_price'],

                    'subtotal' => $item['subtotal'],

                ]);

                $item['product']->decrement('opening_stock', $item['quantity']);
            }
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load([

            'customer',

            'items.product'

        ]);

        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sale = Sale::with('items')->findOrFail($id);
        $customers = Customer::where('status', 1)->orderBy('customer_name')->get();
        $products = Product::where('status', 1)->orderBy('product_name')->get();

        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleRequest $request, Sale $sale)
    {
        DB::transaction(function () use ($request, $sale) {

                foreach ($sale->items as $item) {

                    $item->product->increment(
                        'opening_stock',
                        $item->quantity
                    );
                }

                $sale->items()->delete();

                [$items, $total] = $this->prepareItems($request);
                $paidAmount = (float) ($request->paid_amount ?? 0);

                if ($paidAmount > $total) {
                    throw ValidationException::withMessages([
                        'paid_amount' => 'Paid amount cannot be greater than total amount.',
                    ]);
                }

                $sale->update([
                    'customer_id' => $request->customer_id,
                    'invoice_no' => $request->invoice_no ?: $sale->invoice_no,
                    'sale_date' => $request->sale_date,
                    'total_amount' => $total,
                    'paid_amount' => $paidAmount,
                    'due_amount' => $total - $paidAmount,
                    'status' => $request->status,
                ]);

                foreach ($items as $item) {

                    SaleItem::create([

                        'sale_id' => $sale->id,

                        'product_id' => $item['product']->id,

                        'quantity' => $item['quantity'],

                        'selling_price' => $item['selling_price'],

                        'subtotal' => $item['subtotal'],

                    ]);

                    $item['product']->decrement('opening_stock', $item['quantity']);
                }

        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {

            foreach ($sale->items as $item) {

                $item->product->increment(
                    'opening_stock',
                    $item->quantity
                );
            }

            $sale->items()->delete();

            $sale->delete();
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale Deleted Successfully.');
    }

    public function print(Sale $sale)
    {
        $sale->load([

            'customer',

            'items.product'

        ]);

        return view('sales.print', compact('sale'));
    }

    public function report(Request $request)
    {
        $query = Sale::with('customer');

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('sale_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('sale_date', '<=', $request->to_date);
        }

        $totals = (clone $query)->selectRaw('COALESCE(SUM(total_amount), 0) as total, COALESCE(SUM(paid_amount), 0) as paid, COALESCE(SUM(due_amount), 0) as due')->first();
        $sales = $query->latest('sale_date')->paginate(20)->withQueryString();
        $customers = Customer::where('status', 1)->orderBy('customer_name')->get();

        return view('sales.report', compact('sales', 'customers', 'totals'));
    }

    private function prepareItems(SaleRequest $request): array
    {
        $items = [];
        $total = 0;
        $reservedQuantities = [];

        foreach ($request->product_id as $index => $productId) {
            $product = Product::whereKey($productId)->lockForUpdate()->firstOrFail();
            $quantity = (int) $request->quantity[$index];
            $reservedQuantity = $reservedQuantities[$product->id] ?? 0;
            $availableQuantity = $product->opening_stock - $reservedQuantity;

            if ($quantity > $availableQuantity) {
                throw ValidationException::withMessages([
                    "quantity.$index" => "Only {$availableQuantity} unit(s) of {$product->product_name} are available.",
                ]);
            }

            $reservedQuantities[$product->id] = $reservedQuantity + $quantity;
            $sellingPrice = (float) $request->selling_price[$index];
            $subtotal = round($quantity * $sellingPrice, 2);
            $total += $subtotal;
            $items[] = compact('product', 'quantity', 'sellingPrice', 'subtotal');
        }

        return [collect($items)->map(fn ($item) => [
            'product' => $item['product'],
            'quantity' => $item['quantity'],
            'selling_price' => $item['sellingPrice'],
            'subtotal' => $item['subtotal'],
        ]), round($total, 2)];
    }

    private function generateNumber(string $prefix): string
    {
        do {
            $number = $prefix . '-' . now()->format('YmdHis') . '-' . random_int(100, 999);
        } while (Sale::where($prefix === 'SAL' ? 'sale_no' : 'invoice_no', $number)->exists());

        return $number;
    }
}
