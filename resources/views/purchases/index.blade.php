@extends('layouts.master')

@section('title','Purchases')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Purchase List</h4>

        <a href="{{ route('purchases.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Add Purchase
        </a>

    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('purchases.index') }}">

            <div class="row mb-3">

                <div class="col-md-3">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Purchase No / Invoice"
                        value="{{ request('search') }}">

                </div>

                <div class="col-md-2">

                    <select
                        name="supplier"
                        class="form-select">

                        <option value="">All Supplier</option>

                        @foreach($suppliers as $supplier)

                            <option
                                value="{{ $supplier->id }}"
                                {{ request('supplier') == $supplier->id ? 'selected' : '' }}>

                                {{ $supplier->supplier_name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-2">

                    <input
                        type="date"
                        name="from_date"
                        class="form-control"
                        value="{{ request('from_date') }}">

                </div>

                <div class="col-md-2">

                    <input
                        type="date"
                        name="to_date"
                        class="form-control"
                        value="{{ request('to_date') }}">

                </div>

                <div class="col-md-2">

                    <select
                        name="status"
                        class="form-select">

                        <option value="">Status</option>

                        <option value="1"
                            {{ request('status') == '1' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="0"
                            {{ request('status') == '0' ? 'selected' : '' }}>
                            Pending
                        </option>

                    </select>

                </div>

                <div class="col-md-1 d-grid">

                    <button class="btn btn-primary">
                        Search
                    </button>

                </div>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead>

                <tr>

                    <th>#</th>
                    <th>Purchase No</th>
                    <th>Supplier</th>
                    <th>Invoice</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th width="180">Action</th>

                </tr>

                </thead>

                <tbody>

                @forelse($purchases as $purchase)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $purchase->purchase_no }}</td>

                        <td>{{ $purchase->supplier->supplier_name }}</td>

                        <td>{{ $purchase->invoice_no }}</td>

                        <td>{{ $purchase->purchase_date }}</td>

                        <td>₹ {{ number_format($purchase->total_amount,2) }}</td>

                        <td>₹ {{ number_format($purchase->paid_amount,2) }}</td>

                        <td>₹ {{ number_format($purchase->due_amount,2) }}</td>

                        <td>

                            @if($purchase->status)

                                <span class="badge bg-success">
                                    Completed
                                </span>

                            @else

                                <span class="badge bg-warning">
                                    Pending
                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex gap-1">

                                <a href="{{ route('purchases.show',$purchase->id) }}"
                                   class="btn btn-info btn-sm">

                                    <i class="bx bx-show"></i>

                                </a>

                                <a href="{{ route('purchases.edit',$purchase->id) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bx bx-edit"></i>

                                </a>

                                <form action="{{ route('purchases.destroy',$purchase->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete Purchase?')">

                                        <i class="bx bx-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="10" class="text-center">

                            No Purchase Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $purchases->links() }}

        </div>

    </div>

</div>

@endsection