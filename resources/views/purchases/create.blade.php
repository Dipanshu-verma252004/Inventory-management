@extends('layouts.master')

@section('title','Add Purchase')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h4>Add Purchase</h4>

        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">

            Back

        </a>

    </div>

    <div class="card-body">

        <form
            action="{{ route('purchases.store') }}"
            method="POST">

            @csrf

            @include('purchases._form')
        </form>

    </div>

</div>
@endsection
