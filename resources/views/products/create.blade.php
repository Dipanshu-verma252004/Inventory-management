@extends('layouts.master')

@section('title','Add Product')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h4>Add Product</h4>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">

            Back

        </a>

    </div>

    <div class="card-body">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form
            action="{{ route('products.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            @include('products._form')

            <button class="btn btn-primary">

                <i class="bx bx-save"></i>

                Save Product

            </button>

        </form>

    </div>

</div>

@endsection