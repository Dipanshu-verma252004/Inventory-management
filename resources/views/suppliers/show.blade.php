@extends('layouts.master')

@section('title','Supplier Details')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Supplier Details</h4>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="250">Supplier Name</th>
                <td>{{ $supplier->supplier_name }}</td>
            </tr>

            <tr>
                <th>Company</th>
                <td>{{ $supplier->company_name }}</td>
            </tr>

            <tr>
                <th>Contact Person</th>
                <td>{{ $supplier->contact_person }}</td>
            </tr>

            <tr>
                <th>GST Number</th>
                <td>{{ $supplier->gst_number }}</td>
            </tr>

            <tr>
                <th>Phone</th>
                <td>{{ $supplier->phone }}</td>
            </tr>

            <tr>
                <th>Alternate Phone</th>
                <td>{{ $supplier->alternate_phone }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $supplier->email }}</td>
            </tr>

            <tr>
                <th>Website</th>
                <td>{{ $supplier->website }}</td>
            </tr>

            <tr>
                <th>Address</th>
                <td>{{ $supplier->address }}</td>
            </tr>

            <tr>
                <th>City</th>
                <td>{{ $supplier->city }}</td>
            </tr>

            <tr>
                <th>State</th>
                <td>{{ $supplier->state }}</td>
            </tr>

            <tr>
                <th>Country</th>
                <td>{{ $supplier->country }}</td>
            </tr>

            <tr>
                <th>Postal Code</th>
                <td>{{ $supplier->postal_code }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    @if($supplier->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
            </tr>

        </table>

    </div>

</div>

@endsection