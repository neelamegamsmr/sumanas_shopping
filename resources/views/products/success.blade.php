<!-- resources/views/checkout.blade.php -->

@extends('layouts.app')

@section('content')
@extends('layouts.header')

<div style="text-align: center;margin-top: 10px;">
    <!-- Product details -->
    <!-- Success message container (hidden by default) -->
    <div id="success-message" class="success-message">
        Payment Successful
    </div>
    <p>Your payment has been processed successfully.</p>
    <div class="text-center">
        <a href="{{ route('products.index') }}" class="btn btn-lg btn-primary btn-block" style="font-size: 10px;margin-top: 10px;">Go to product list</a>
    </div>
</div>
@endsection