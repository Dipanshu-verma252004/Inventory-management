@extends('layouts.master')

@section('title','Add Supplier')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Add Supplier</h4>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>

    </div>

    <div class="card-body">

        <form action="{{ route('suppliers.store') }}" method="POST">

            @csrf

            @include('suppliers._form')

            <button class="btn btn-primary">
                <i class="bx bx-save"></i> Save Supplier
            </button>

        </form>

    </div>

</div>

@endsection