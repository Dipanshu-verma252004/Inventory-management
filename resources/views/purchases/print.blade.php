@extends('layouts.master')

@section('title','Print Purchase')

@section('content')

<div id="printArea">

    <h2 class="text-center">

        Purchase Invoice

    </h2>

    <hr>

    <p>

        Purchase No :

        {{ $purchase->purchase_no }}

    </p>

    <p>

        Supplier :

        {{ $purchase->supplier->supplier_name }}

    </p>

    <p>

        Invoice :

        {{ $purchase->invoice_no }}

    </p>

    <p>

        Date :

        {{ date('d-m-Y',strtotime($purchase->purchase_date)) }}

    </p>

    <table class="table table-bordered">

        <thead>

        <tr>

            <th>Product</th>

            <th>Qty</th>

            <th>Price</th>

            <th>Subtotal</th>

        </tr>

        </thead>

        <tbody>

        @foreach($purchase->items as $item)

        <tr>

            <td>{{ $item->product->product_name }}</td>

            <td>{{ $item->quantity }}</td>

            <td>{{ number_format($item->purchase_price,2) }}</td>

            <td>{{ number_format($item->subtotal,2) }}</td>

        </tr>

        @endforeach

        </tbody>

    </table>

    <h4 class="text-end">

        Total :

        ₹ {{ number_format($purchase->total_amount,2) }}

    </h4>

</div>

<button
class="btn btn-primary"
onclick="window.print()">

<a
href="{{ route('purchases.print',$purchase->id) }}"
class="btn btn-primary">

<i class="bx bx-printer"></i>

Print

</a>
</button>

@endsection