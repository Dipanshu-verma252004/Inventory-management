@extends('layouts.master')

@section('title','Product Details')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h4>Product Details</h4>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">

            Back

        </a>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                @if($product->image)

                    <img
                        src="{{ asset('storage/'.$product->image) }}"
                        class="img-fluid rounded border">

                @else

                    <img
                        src="{{ asset('assets/img/no-image.png') }}"
                        class="img-fluid rounded border">

                @endif

            </div>

            <div class="col-md-8">

                <table class="table table-bordered">

                    <tr>

                        <th width="220">

                            Product Name

                        </th>

                        <td>

                            {{ $product->product_name }}

                        </td>

                    </tr>

                    <tr>

                        <th>Category</th>

                        <td>

                            {{ $product->category->name }}

                        </td>

                    </tr>

                    <tr>

                        <th>Brand</th>

                        <td>

                            {{ $product->brand->name }}

                        </td>

                    </tr>

                    <tr>

                        <th>Unit</th>

                        <td>

                            {{ $product->unit->name }}

                        </td>

                    </tr>

                    <tr>

                        <th>Supplier</th>

                        <td>

                            {{ $product->supplier->supplier_name }}

                        </td>

                    </tr>

                    <tr>

                        <th>SKU</th>

                        <td>

                            {{ $product->sku }}

                        </td>

                    </tr>

                    <tr>

                        <th>Barcode</th>

                        <td>

                            {{ $product->barcode }}

                        </td>

                    </tr>

                    <tr>

                        <th>Purchase Price</th>

                        <td>

                            ₹ {{ number_format($product->purchase_price,2) }}

                        </td>

                    </tr>

                    <tr>

                        <th>Selling Price</th>

                        <td>

                            ₹ {{ number_format($product->selling_price,2) }}

                        </td>

                    </tr>

                    <tr>

                        <th>Opening Stock</th>

                        <td>

                            {{ $product->opening_stock }}

                        </td>

                    </tr>

                    <tr>

                        <th>Minimum Stock</th>

                        <td>

                            {{ $product->minimum_stock }}

                        </td>

                    </tr>

                    <tr>

                        <th>Status</th>

                        <td>

                            @if($product->status)

                                <span class="badge bg-success">

                                    Active

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Inactive

                                </span>

                            @endif

                        </td>

                    </tr>

                    <tr>

                        <th>Description</th>

                        <td>

                            {{ $product->description }}

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection