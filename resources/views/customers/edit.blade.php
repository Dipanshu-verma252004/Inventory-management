@extends('layouts.master')

@section('title','Edit Customer')

@section('content')

<form action="{{ route('customers.update',$customer->id) }}" method="POST">

    @csrf
    @method('PUT')

    @include('customers._form')

</form>

@endsection