@extends('layouts.master')

@section('title','Edit Sale')

@section('content')

<form action="{{ route('sales.update',$sale->id) }}" method="POST">

    @csrf
    @method('PUT')

    @include('sales._form')

</form>

@endsection