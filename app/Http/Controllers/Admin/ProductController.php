<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with([
            'category',
            'brand',
            'unit',
            'supplier'
        ]);

        // Search
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('product_name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%')
                ->orWhere('barcode', 'like', '%' . $request->search . '%');

            });

        }

        // Category Filter
        if ($request->filled('category')) {

            $query->where('category_id', $request->category);

        }

        // Brand Filter
        if ($request->filled('brand')) {

            $query->where('brand_id', $request->brand);

        }

        $products = $query->latest()->paginate(10);

        $categories = Category::where('status',1)->get();

        $brands = Brand::where('status',1)->get();

        return view(
            'products.index',
            compact(
                'products',
                'categories',
                'brands'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status',1)->get();

        $brands = Brand::where('status',1)->get();

        $units = Unit::where('status',1)->get();

        $suppliers = Supplier::where('status',1)->get();

        return view('products.create',compact(
            'categories',
            'brands',
            'units',
            'suppliers'
        ));
    }

    /**
     * Store a newly created resource.
     */
    public function store(ProductRequest $request)
{
    try {

        $data = $request->validated();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('products','public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success','Saved');

    } catch (\Exception $e) {

        dd($e->getMessage());

    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with([
            'category',
            'brand',
            'unit',
            'supplier'
        ])->findOrFail($id);

        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::where('status',1)->get();

        $brands = Brand::where('status',1)->get();

        $units = Unit::where('status',1)->get();

        $suppliers = Supplier::where('status',1)->get();

        return view('products.edit',compact(
            'product',
            'categories',
            'brands',
            'units',
            'suppliers'
        ));
    }

    /**
     * Update resource.
     */
    public function update(ProductRequest $request,string $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validated();

        if($request->hasFile('image')){

            if($product->image && Storage::disk('public')->exists($product->image)){

                Storage::disk('public')->delete($product->image);

            }

            $data['image'] = $request
                ->file('image')
                ->store('products','public');

        }

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success','Product Updated Successfully.');
    }

    /**
     * Delete resource.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if($product->image && Storage::disk('public')->exists($product->image)){

            Storage::disk('public')->delete($product->image);

        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success','Product Deleted Successfully.');
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}