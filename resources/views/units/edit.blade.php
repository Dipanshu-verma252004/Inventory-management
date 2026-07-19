@extends('layouts.master')

@section('title', 'Edit Unit')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Edit Unit</h4>

        <a href="{{ route('units.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>

    </div>

    <div class="card-body">

        <form action="{{ route('units.update',$unit->id) }}" method="POST">

            @csrf
            @method('PUT')

            @include('units._form')

            <button class="btn btn-primary">
                <i class="bx bx-save"></i> Update Unit
            </button>

        </form>

    </div>

</div>

@endsection