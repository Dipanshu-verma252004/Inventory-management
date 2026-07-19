@extends('layouts.master')

@section('title','Add Customer')

@section('content')

<form action="{{ route('customers.store') }}" method="POST">

    @csrf

    @include('customers._form')

</form>

@endsection