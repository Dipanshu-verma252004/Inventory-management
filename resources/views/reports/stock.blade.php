
@extends('layouts.master')

@section('title', 'Stock Report')

@section('content')

<div class="card"><div class="card-header d-flex justify-content-between align-items-center"><h4 class="mb-0">Stock Report</h4><a href="{{ route('reports.stock') }}" class="btn btn-outline-secondary btn-sm">Reset</a></div><div class="card-body">
<form method="GET" class="row g-2 mb-4"><div class="col-md-4"><input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search product"></div><div class="col-md-3"><select name="category_id" class="form-select"><option value="">All Categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->category_name }}</option>@endforeach</select></div><div class="col-md-3"><select name="brand_id" class="form-select"><option value="">All Brands</option>@foreach($brands as $brand)<option value="{{ $brand->id }}" @selected(request('brand_id') == $brand->id)>{{ $brand->brand_name }}</option>@endforeach</select></div><div class="col-md-2 d-grid"><button class="btn btn-primary">Filter</button></div></form>
<div class="table-responsive"><table class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>#</th>

<th>Product</th>

<th>Category</th>

<th>Brand</th>

<th>Unit</th>

<th>Purchase</th>

<th>Selling</th>

<th>Current Stock</th>

<th>Minimum</th>

<th>Stock Value</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@forelse($products as $product)

<tr>

<td>{{ $products->firstItem() + $loop->index }}</td>

<td>{{ $product->product_name }}</td>

<td>{{ $product->category?->category_name ?? '-' }}</td>

<td>{{ $product->brand?->brand_name ?? '-' }}</td>

<td>{{ $product->unit?->unit_name ?? '-' }}</td>

<td>{{ number_format($product->purchase_price,2) }}</td>

<td>{{ number_format($product->selling_price,2) }}</td>

<td>{{ $product->opening_stock }}</td>

<td>{{ $product->minimum_stock }}</td>

<td>

{{ number_format($product->opening_stock * $product->purchase_price,2) }}

</td>

<td>

@if($product->opening_stock==0)

<span class="badge bg-danger">

Out Of Stock

</span>

@elseif($product->opening_stock<=$product->minimum_stock)

<span class="badge bg-warning">

Low Stock

</span>

@else

<span class="badge bg-success">

In Stock

</span>

@endif

</td>

</tr>

@empty<tr><td colspan="11" class="text-center text-muted">No products found.</td></tr>@endforelse

</tbody>

</table></div><div class="mt-3">{{ $products->links() }}</div></div></div>

@endsection
