@extends('layouts.master')

@section('title', 'Units')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">Unit List</h4>

        <a href="{{ route('units.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Add Unit
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
                        <th>Unit Name</th>
                        <th>Short Name</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($units as $unit)

                    <tr>

                        <td>{{ $loop->iteration + ($units->currentPage()-1) * $units->perPage() }}</td>

                        <td>{{ $unit->name }}</td>

                        <td>{{ $unit->short_name }}</td>

                        <td>
                            @if($unit->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td>{{ $unit->description ?? '-' }}</td>

                        <td>

                            <a href="{{ route('units.show',$unit->id) }}" class="btn btn-info btn-sm">
                                <i class="bx bx-show"></i>
                            </a>

                            <a href="{{ route('units.edit',$unit->id) }}" class="btn btn-warning btn-sm">
                                <i class="bx bx-edit"></i>
                            </a>

                            <form action="{{ route('units.destroy',$unit->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this Unit?')">

                                    <i class="bx bx-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No Unit Found
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $units->links() }}
        </div>

    </div>

</div>

@endsection