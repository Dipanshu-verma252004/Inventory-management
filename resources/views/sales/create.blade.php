@extends('layouts.master')

@section('title','Create Sale')

@section('content')

<form action="{{ route('sales.store') }}" method="POST">

    @csrf

    @include('sales._form')

</form>

@endsection