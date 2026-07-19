@extends('layouts.master')

@section('title','Brand Details')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h4>Brand Details</h4>

        <a href="{{ route('brands.index') }}" class="btn btn-secondary">

        Back

        </a>

    </div>

    <div class="card-body">

        <p><strong>Name :</strong> {{ $brand->name }}</p>

        <p><strong>Slug :</strong> {{ $brand->slug }}</p>

        <p><strong>Status :</strong>

            @if($brand->status)

                Active

            @else

                Inactive

            @endif

        </p>

        <p><strong>Description :</strong>

            {{ $brand->description }}

        </p>

    </div>

</div>

@endsection