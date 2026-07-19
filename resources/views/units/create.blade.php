@extends('layouts.master')

@section('title', 'Add Unit')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Add Unit</h4>

        <a href="{{ route('units.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>

    </div>

    <div class="card-body">

        <form action="{{ route('units.store') }}" method="POST">

            @csrf

            @include('units._form')

            <button class="btn btn-primary">
                <i class="bx bx-save"></i> Save Unit
            </button>

        </form>

    </div>

</div>

@endsection