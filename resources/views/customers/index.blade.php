@extends('layouts.master')

@section('title','Customers')

@section('content')

<div class="card">

<div class="card-header d-flex justify-content-between">

<h4>Customers</h4>

<a
href="{{ route('customers.create') }}"
class="btn btn-primary">

<i class="bx bx-plus"></i>

Add Customer

</a>

</div>

<div class="card-body">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<form method="GET">

<div class="row mb-3">

<div class="col-md-4">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Customer"
value="{{ request('search') }}">

</div>

<div class="col-md-3">

<select
name="status"
class="form-select">

<option value="">All Status</option>

<option value="1"
{{ request('status')==='1'?'selected':'' }}>

Active

</option>

<option value="0"
{{ request('status')==='0'?'selected':'' }}>

Inactive

</option>

</select>

</div>

<div class="col-md-2">

<button
class="btn btn-primary w-100">

Search

</button>

</div>

<div class="col-md-2">

<a
href="{{ route('customers.index') }}"
class="btn btn-secondary w-100">

Reset

</a>

</div>

</div>

</form>

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>#</th>

<th>Name</th>

<th>Mobile</th>

<th>Email</th>

<th>Status</th>

<th width="180">Action</th>

</tr>

</thead>

<tbody>

@forelse($customers as $customer)

<tr>

<td>{{ $customers->firstItem() + $loop->index }}</td>

<td>{{ $customer->customer_name }}</td>

<td>{{ $customer->mobile }}</td>

<td>{{ $customer->email }}</td>

<td>

@if($customer->status)

<span class="badge bg-success">

Active

</span>

@else

<span class="badge bg-danger">

Inactive

</span>

@endif

</td>

<td>

<div class="d-flex gap-1">

<a
href="{{ route('customers.show',$customer->id) }}"
class="btn btn-info btn-sm">

<i class="bx bx-show"></i>

</a>

<a
href="{{ route('customers.edit',$customer->id) }}"
class="btn btn-warning btn-sm">

<i class="bx bx-edit"></i>

</a>

<form
action="{{ route('customers.destroy',$customer->id) }}"
method="POST">

@csrf
@method('DELETE')

<button
class="btn btn-danger btn-sm"
onclick="return confirm('Delete Customer?')">

<i class="bx bx-trash"></i>

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>

<td colspan="6" class="text-center">

No Customer Found

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

{{ $customers->links() }}

</div>

</div>

@endsection
