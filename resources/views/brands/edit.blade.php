@extends('layouts.master')

@section('title','Edit Brand')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h4>Edit Brand</h4>

        <a href="{{ route('brands.index') }}" class="btn btn-secondary">

            Back

        </a>

    </div>

    <div class="card-body">

        <form
            action="{{ route('brands.update',$brand->id) }}"
            method="POST">

            @csrf
            @method('PUT')

            @include('brands._form')

            <button class="btn btn-primary">
                <i class="bx bx-save"></i>

                Update Brand

            </button>

        </form>

    </div>

</div>

@endsection