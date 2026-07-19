@extends('layouts.master')

@section('title', 'Category Details')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Category Details</h4>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Back
                </a>
            </div>

            <div class="card-body">
                <p><strong>Name:</strong> {{ $category->name }}</p>
                <p><strong>Slug:</strong> {{ $category->slug }}</p>
                <p><strong>Status:</strong> {{ $category->status ? 'Active' : 'Inactive' }}</p>
                <p><strong>Description:</strong> {{ $category->description ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
