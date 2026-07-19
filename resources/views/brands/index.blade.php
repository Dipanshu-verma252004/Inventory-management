@extends('layouts.master')

@section('title', 'Brands')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">Brand List</h4>

        <a href="{{ route('brands.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Add Brand
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
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($brands as $brand)

                    <tr>

                        <td>
                            {{ $loop->iteration + ($brands->currentPage()-1) * $brands->perPage() }}
                        </td>

                        <td>{{ $brand->name }}</td>

                        <td>{{ $brand->slug }}</td>

                        <td>
                            @if($brand->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td>{{ $brand->description ?? '-' }}</td>

                        <td>
                            <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-info btn-sm">
                                <i class="bx bx-show"></i>
                            </a>

                            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>

                            <form action="{{ route('brands.destroy', $brand->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this Brand?')">

                                    <i class="bx bx-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No Brand Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $brands->links() }}

        </div>

    </div>

</div>

@endsection