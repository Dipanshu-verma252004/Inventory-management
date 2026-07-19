@extends('layouts.master')

@section('title','Edit Supplier')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Edit Supplier</h4>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>

    </div>

    <div class="card-body">

        <form action="{{ route('suppliers.update',$supplier->id) }}" method="POST">

            @csrf
            @method('PUT')

            @include('suppliers._form')

            <button class="btn btn-primary">
                <i class="bx bx-save"></i> Update Supplier
            </button>

        </form>

    </div>

</div>

@endsection