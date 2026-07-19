<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Http\Requests\PurchaseRequest;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
   public function index(Request $request)
    {

        $query = Purchase::with('supplier');

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('purchase_no', 'like', '%' . $request->search . '%')

                    ->orWhere('invoice_no', 'like', '%' . $request->search . '%');

            });

        }

        if ($request->filled('supplier')) {

            $query->where('supplier_id', $request->supplier);

        }

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        if ($request->filled('from_date')) {

            $query->whereDate(
                'purchase_date',
                '>=',
                $request->from_date
            );

        }

        if ($request->filled('to_date')) {

            $query->whereDate(
                'purchase_date',
                '<=',
                $request->to_date
            );

        }

        $purchases = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $suppliers = Supplier::where('status',1)->get();

        return view(
            'purchases.index',
            compact(
                'purchases',
                'suppliers'
            )
        );

    }

    public function create()
    {
        $suppliers = Supplier::where('status',1)->get();

        $products = Product::where('status',1)->get();

        return view('purchases.create', compact(
            'suppliers',
            'products'
        ));
    }

    public function store(PurchaseRequest $request)
    {
        DB::transaction(function () use ($request) {

            // Purchase Number
            $purchaseNo = 'PUR-' . date('YmdHis');

            // Purchase Create
            $purchase = Purchase::create([

                'supplier_id'   => $request->supplier_id,
                'purchase_no'   => $purchaseNo,
                'invoice_no'    => $request->invoice_no,
                'purchase_date' => $request->purchase_date,
                'total_amount'  => $request->total_amount,
                'paid_amount'   => $request->paid_amount ?? 0,
                'due_amount'    => $request->due_amount,
                'status'        => $request->status,

            ]);

            // Purchase Items
            foreach ($request->product_id as $key => $productId) {

                PurchaseItem::create([

                    'purchase_id'    => $purchase->id,
                    'product_id'     => $productId,
                    'quantity'       => $request->quantity[$key],
                    'purchase_price' => $request->purchase_price[$key],
                    'subtotal'       => $request->quantity[$key] * $request->purchase_price[$key],

                ]);

                // Stock Update
                $product = Product::find($productId);

                $product->opening_stock += $request->quantity[$key];

                $product->save();
            }

        });

        return redirect()
                ->route('purchases.index')
                ->with('success', 'Purchase Created Successfully.');
    }

    public function show(string $id)
    {
        $purchase = Purchase::with([
            'supplier',
            'items.product'
        ])->findOrFail($id);

        return view('purchases.show', compact('purchase'));
    }

    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {

            $purchase = Purchase::with('items')->findOrFail($id);

            foreach ($purchase->items as $item) {

                Product::where('id', $item->product_id)
                    ->decrement('opening_stock', $item->quantity);

            }

            $purchase->items()->delete();

            $purchase->delete();

        });

        return redirect()
                ->route('purchases.index')
                ->with('success','Purchase Deleted Successfully.');
    }

    public function edit(string $id)
    {
        $purchase = Purchase::with('items')->findOrFail($id);

        $suppliers = Supplier::where('status',1)->get();

        $products = Product::where('status',1)->get();

        return view(
            'purchases.edit',
            compact(
                'purchase',
                'suppliers',
                'products'
            )
        );
    }

    public function update(PurchaseRequest $request, string $id)
    {
        DB::transaction(function () use ($request, $id) {

            $purchase = Purchase::with('items')->findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | Reverse Old Stock
            |--------------------------------------------------------------------------
            */

            foreach ($purchase->items as $item) {

                Product::where('id', $item->product_id)
                    ->decrement('opening_stock', $item->quantity);

            }

            /*
            |--------------------------------------------------------------------------
            | Delete Old Purchase Items
            |--------------------------------------------------------------------------
            */

            $purchase->items()->delete();

            /*
            |--------------------------------------------------------------------------
            | Update Purchase
            |--------------------------------------------------------------------------
            */

            $purchase->update([

                'supplier_id'   => $request->supplier_id,

                'invoice_no'    => $request->invoice_no,

                'purchase_date' => $request->purchase_date,

                'total_amount'  => $request->total_amount,

                'paid_amount'   => $request->paid_amount,

                'due_amount'    => $request->due_amount,

                'status'        => $request->status,

            ]);

            /*
            |--------------------------------------------------------------------------
            | Insert New Purchase Items
            |--------------------------------------------------------------------------
            */

            foreach ($request->product_id as $key => $productId) {

                PurchaseItem::create([

                    'purchase_id'    => $purchase->id,

                    'product_id'     => $productId,

                    'quantity'       => $request->quantity[$key],

                    'purchase_price' => $request->purchase_price[$key],

                    'subtotal'       => $request->quantity[$key] * $request->purchase_price[$key],

                ]);

                /*
                |--------------------------------------------------------------------------
                | Increase New Stock
                |--------------------------------------------------------------------------
                */

                Product::where('id', $productId)
                    ->increment('opening_stock', $request->quantity[$key]);

            }

        });

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase Updated Successfully.');
    }

    public function print($id)
    {
        $purchase = Purchase::with([
            'supplier',
            'items.product'
        ])->findOrFail($id);

        return view(
            'purchases.print',
            compact('purchase')
        );
    }

}