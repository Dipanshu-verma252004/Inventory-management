@extends('layouts.master')

@section('title', 'Add Category')

@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Add Category</h4>

                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Back
                </a>
            </div>

            <div class="card-body">

                <form action="{{ route('categories.store') }}" method="POST">

                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>

                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Enter Category Name">

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Status</label>

                            <select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="form-label">Description</label>

                            <textarea
                                name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Enter Description">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Save Category
                    </button>

                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection