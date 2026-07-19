@extends('layouts.master')

@section('title','Sales')

@section('content')

<div class="card">

<div class="card-header d-flex justify-content-between">

<h4>Sales</h4>

<a href="{{ route('sales.create') }}"
class="btn btn-primary">

New Sale

</a>

<a href="{{ route('sales.report') }}" class="btn btn-secondary ms-2">Sales Report</a>

</div>

<div class="card-body">

@if(session('success'))

<div class="alert alert-success">{{ session('success') }}</div>

@endif

<form method="GET">

<div class="row">

<div class="col-md-3">

<input
type="text"
name="search"
class="form-control"
placeholder="Sale No / Invoice"
value="{{ request('search') }}">

</div>

<div class="col-md-2">

<select
name="customer_id"
class="form-select">

<option value="">Customer</option>

@foreach($customers as $customer)

<option
value="{{ $customer->id }}"
{{ request('customer_id') == $customer->id ? 'selected' : '' }}>

{{ $customer->customer_name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-2">

<select
name="status"
class="form-select">

<option value="">Status</option>

<option value="1" {{ request('status') === '1' ? 'selected' : '' }}>

Active

</option>

<option value="0" {{ request('status') === '0' ? 'selected' : '' }}>

Inactive

</option>

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

<div class="col-md-1">

<button
class="btn btn-primary w-100">

Go

</button>

</div>

</div>

</form>

<hr>

<div class="table-responsive">

<table class="table table-bordered">

<thead>

<tr>

<th>#</th>

<th>Sale No</th>

<th>Customer</th>

<th>Date</th>

<th>Total</th>

<th>Paid</th>

<th>Due</th>

<th>Action</th>

</tr>

</thead>

<tbody>

@forelse($sales as $sale)

<tr>

<td>{{ $sales->firstItem() + $loop->index }}</td>

<td>{{ $sale->sale_no }}</td>

<td>{{ $sale->customer->customer_name }}</td>

<td>{{ $sale->sale_date }}</td>

<td>{{ number_format($sale->total_amount,2) }}</td>

<td>{{ number_format($sale->paid_amount,2) }}</td>

<td>{{ number_format($sale->due_amount,2) }}</td>

<td>

<a
href="{{ route('sales.show',$sale) }}"
class="btn btn-info btn-sm">

View

</a>

<a
href="{{ route('sales.edit',$sale) }}"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="{{ route('sales.print',$sale) }}"
class="btn btn-dark btn-sm">

Print

</a>

<form
action="{{ route('sales.destroy',$sale) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Sale?')">

Delete

</button>

</form>

</td>

</tr>

@empty

<tr><td colspan="8" class="text-center">No sales found.</td></tr>

@endforelse

</tbody>

</table>

</div>

{{ $sales->links() }}

</div>

</div>

@endsection
