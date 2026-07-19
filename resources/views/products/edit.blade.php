@extends('layouts.master')

@section('title','Edit Product')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h4>Edit Product</h4>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">

            Back

        </a>

    </div>

    <div class="card-body">

        <form
            action="{{ route('products.update',$product->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            @method('PUT')

            @include('products._form')

            <button class="btn btn-primary">

                <i class="bx bx-save"></i>

                Update Product

            </button>

        </form>

    </div>

</div>

@endsection