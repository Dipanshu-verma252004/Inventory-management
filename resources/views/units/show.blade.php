@extends('layouts.master')

@section('title', 'Unit Details')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Unit Details</h4>

        <a href="{{ route('units.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>

    </div>

    <div class="card-body">

        <p><strong>Unit Name :</strong> {{ $unit->name }}</p>

        <p><strong>Short Name :</strong> {{ $unit->short_name }}</p>

        <p><strong>Status :</strong>
            @if($unit->status)
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-danger">Inactive</span>
            @endif
        </p>

        <p><strong>Description :</strong> {{ $unit->description ?? '-' }}</p>

    </div>

</div>

@endsection