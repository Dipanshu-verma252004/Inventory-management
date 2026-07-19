@extends('layouts.master')

@section('title', 'Sale Details')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Invoice: {{ $sale->invoice_no }}</h4>
        <div><a href="{{ route('sales.print', $sale) }}" class="btn btn-dark">Print</a> <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back</a></div>
    </div>
    <div class="card-body">
        <div class="row mb-4"><div class="col-md-6"><strong>Customer:</strong> {{ $sale->customer->customer_name }}<br><strong>Sale No:</strong> {{ $sale->sale_no }}</div><div class="col-md-6 text-md-end"><strong>Date:</strong> {{ \Illuminate\Support\Carbon::parse($sale->sale_date)->format('d M Y') }}<br><strong>Status:</strong> {{ $sale->status ? 'Completed' : 'Pending' }}</div></div>
        <div class="table-responsive"><table class="table table-bordered"><thead><tr><th>#</th><th>Product</th><th class="text-end">Price</th><th class="text-end">Qty</th><th class="text-end">Subtotal</th></tr></thead><tbody>@foreach($sale->items as $item)<tr><td>{{ $loop->iteration }}</td><td>{{ $item->product->product_name }}</td><td class="text-end">{{ number_format($item->selling_price, 2) }}</td><td class="text-end">{{ $item->quantity }}</td><td class="text-end">{{ number_format($item->subtotal, 2) }}</td></tr>@endforeach</tbody></table></div>
        <div class="ms-auto" style="max-width: 320px"><div class="d-flex justify-content-between"><strong>Total</strong><span>{{ number_format($sale->total_amount, 2) }}</span></div><div class="d-flex justify-content-between"><strong>Paid</strong><span>{{ number_format($sale->paid_amount, 2) }}</span></div><div class="d-flex justify-content-between"><strong>Due</strong><span>{{ number_format($sale->due_amount, 2) }}</span></div></div>
    </div>
</div>
@endsection
