@extends('layouts.master')

@section('title', 'Add Brand')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Add Brand</h4>

        <a href="{{ route('brands.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card-body">

        <form action="{{ route('brands.store') }}" method="POST">

            @csrf

            @include('brands._form')

            <button class="btn btn-primary">
                <i class="bx bx-save"></i>
                Save Brand
            </button>

        </form>

    </div>

</div>

@endsection