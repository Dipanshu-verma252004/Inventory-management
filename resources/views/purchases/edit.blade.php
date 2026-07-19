@extends('layouts.master')

@section('title','Edit Purchase')

@section('content')

<form
action="{{ route('purchases.update',$purchase->id) }}"
method="POST">

@csrf

@method('PUT')

@include('purchases._form')

</form>

@endsection