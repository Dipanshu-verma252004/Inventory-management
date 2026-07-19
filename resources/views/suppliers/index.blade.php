@extends('layouts.master')

@section('title','Suppliers')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Supplier List</h4>

        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Add Supplier
        </a>

    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Supplier</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th width="180">Action</th>
                </tr>
                </thead>

                <tbody>

                @forelse($suppliers as $supplier)

                    <tr>

                        <td>{{ $loop->iteration + ($suppliers->currentPage()-1) * $suppliers->perPage() }}</td>

                        <td>{{ $supplier->supplier_name }}</td>

                        <td>{{ $supplier->company_name ?? '-' }}</td>

                        <td>{{ $supplier->phone }}</td>

                        <td>{{ $supplier->email ?? '-' }}</td>

                        <td>

                            @if($supplier->status)

                                <span class="badge bg-success">Active</span>

                            @else

                                <span class="badge bg-danger">Inactive</span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('suppliers.show',$supplier->id) }}" class="btn btn-info btn-sm">
                                <i class="bx bx-show"></i>
                            </a>

                            <a href="{{ route('suppliers.edit',$supplier->id) }}" class="btn btn-warning btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>

                            <form action="{{ route('suppliers.destroy',$supplier->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this supplier?')">

                                    <i class="bx bx-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">

                            No Supplier Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $suppliers->links() }}
        </div>

    </div>

</div>

@endsection