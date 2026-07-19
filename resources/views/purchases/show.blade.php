@extends('layouts.master')

@section('title','Purchase Details')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Purchase Details</h4>

        <div>

            <a href="{{ route('purchases.print',$purchase->id) }}"
                class="btn btn-primary">

                <i class="bx bx-printer"></i>

                Print

            </a>

            <a href="{{ route('purchases.index') }}"
                class="btn btn-secondary">

                Back

            </a>

        </div>

    </div>

    <div class="card-body">

        <div class="row mb-4">

            <div class="col-md-6">

                <h5>Purchase Information</h5>

                <table class="table table-borderless">

                    <tr>
                        <th width="180">Purchase No</th>
                        <td>{{ $purchase->purchase_no }}</td>
                    </tr>

                    <tr>
                        <th>Invoice No</th>
                        <td>{{ $purchase->invoice_no }}</td>
                    </tr>

                    <tr>
                        <th>Purchase Date</th>
                        <td>{{ date('d M Y',strtotime($purchase->purchase_date)) }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>

                            @if($purchase->status)

                                <span class="badge bg-success">Completed</span>

                            @else

                                <span class="badge bg-warning">Pending</span>

                            @endif

                        </td>

                    </tr>

                </table>

            </div>

            <div class="col-md-6">

                <h5>Supplier Details</h5>

                <table class="table table-borderless">

                    <tr>

                        <th width="150">Supplier</th>

                        <td>{{ $purchase->supplier->supplier_name }}</td>

                    </tr>

                    <tr>

                        <th>Phone</th>

                        <td>{{ $purchase->supplier->mobile }}</td>

                    </tr>

                    <tr>

                        <th>Email</th>

                        <td>{{ $purchase->supplier->email }}</td>

                    </tr>

                </table>

            </div>

        </div>

        <table class="table table-bordered">

            <thead class="table-light">

                <tr>

                    <th>#</th>

                    <th>Product</th>

                    <th width="120">Qty</th>

                    <th width="150">Purchase Price</th>

                    <th width="150">Subtotal</th>

                </tr>

            </thead>

            <tbody>

                @foreach($purchase->items as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->product->product_name }}</td>

                    <td>{{ $item->quantity }}</td>

                    <td>{{ number_format($item->purchase_price,2) }}</td>

                    <td>{{ number_format($item->subtotal,2) }}</td>

                </tr>

                @endforeach

            </tbody>

        </table>

        <div class="row justify-content-end">

            <div class="col-md-4">

                <table class="table table-bordered">

                    <tr>

                        <th>Total</th>

                        <td>{{ number_format($purchase->total_amount,2) }}</td>

                    </tr>

                    <tr>

                        <th>Paid</th>

                        <td>{{ number_format($purchase->paid_amount,2) }}</td>

                    </tr>

                    <tr>

                        <th>Due</th>

                        <td>{{ number_format($purchase->due_amount,2) }}</td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection