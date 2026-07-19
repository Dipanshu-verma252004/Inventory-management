@extends('layouts.master')

@section('title','Products')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">Product List</h4>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Add Product
        </a>

    </div>

    <div class="card-body">

    <form method="GET" class="mb-3">

    <div class="row">

        <div class="col-md-4">
            <input
                type="text"
                name="search"
                class="form-control"
                 placeholder="Search Product / SKU / Barcode"
                value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All Category</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="col-md-3">
            <select name="brand" class="form-select">
                <option value="">All Brand</option>

                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}"
                        {{ request('brand') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <i class="bx bx-search"></i> Search
            </button>
        </div>

    </div>

</form>


        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead>

                <tr>

                    <th>#</th>

                    <th>Image</th>

                    <th>Product</th>

                    <th>Category</th>

                    <th>Brand</th>

                    <th>Unit</th>

                    <th>Supplier</th>

                    <th>Purchase</th>

                    <th>Selling</th>

                    <th>Stock</th>

                    <th>Status</th>

                    <th width="180">Action</th>

                </tr>

                </thead>

                <tbody>

                @forelse($products as $product)

                    <tr>

                        <td>

                            {{ $loop->iteration + (($products->currentPage()-1) * $products->perPage()) }}

                        </td>

                        <td>

                            @if($product->image)

                                <img src="{{ asset('storage/'.$product->image) }}"
                                     width="60"
                                     height="60"
                                     class="rounded border">

                            @else

                                <img src="{{ asset('assets/img/no-image.png') }}"
                                     width="60"
                                     height="60">

                            @endif

                        </td>

                        <td>

                            <strong>{{ $product->product_name }}</strong>

                            <br>

                            <small>{{ $product->sku }}</small>

                        </td>

                        <td>

                            {{ $product->category->name }}

                        </td>

                        <td>

                            {{ $product->brand->name }}

                        </td>

                        <td>

                            {{ $product->unit->short_name }}

                        </td>

                        <td>

                            {{ $product->supplier->supplier_name }}

                        </td>

                        <td>

                            ₹ {{ number_format($product->purchase_price,2) }}

                        </td>

                        <td>

                            ₹ {{ number_format($product->selling_price,2) }}

                        </td>

                        <td>

                            {{ $product->opening_stock }}

                        </td>

                        <td>

                           @if($product->opening_stock <= $product->minimum_stock)
                                <span class="badge bg-danger">
                                    {{ $product->opening_stock }}
                                </span>
                            @else
                                <span class="badge bg-success">
                                    {{ $product->opening_stock }}
                                </span>
                            @endif
                            </td>
                            

                        <td>
                            <div class="d-flex gap-1">

                                <a href="{{ route('products.show', $product->id) }}"
                                class="btn btn-info btn-sm">
                                    <i class="bx bx-show"></i>
                                </a>

                                <a href="{{ route('products.edit', $product->id) }}"
                                class="btn btn-warning btn-sm">
                                    <i class="bx bx-edit"></i>
                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this product?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        <i class="bx bx-trash"></i>
                                    </button>

                                </form>

                            </div>
                        </td>

                @empty

                    <tr>

                        <td colspan="12" class="text-center">

                            No Product Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $products->links() }}

        </div>

    </div>

</div>

@endsection