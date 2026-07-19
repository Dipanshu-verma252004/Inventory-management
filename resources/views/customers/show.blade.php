@extends('layouts.master')

@section('title','Customer Details')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Customer Details</h4>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="220">Customer Name</th>
                <td>{{ $customer->customer_name }}</td>
            </tr>

            <tr>
                <th>Mobile</th>
                <td>{{ $customer->mobile }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $customer->email ?: '-' }}</td>
            </tr>

            <tr>
                <th>GST Number</th>
                <td>{{ $customer->gst_no ?: '-' }}</td>
            </tr>

            <tr>
                <th>Address</th>
                <td>{{ $customer->address ?: '-' }}</td>
            </tr>

            <tr>
                <th>Status</th>

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

            </tr>

            <tr>

                <th>Created At</th>

                <td>

                    {{ $customer->created_at->format('d M Y h:i A') }}

                </td>

            </tr>

        </table>

    </div>

</div>

@endsection