<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('content')
@extends('layouts.header')

<div class="container">
    <h1>Products</h1>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" width="200" height="200">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">${{ $product->price }}</p>
                    <a class="btn btn-primary" href="{{ route('goToPayment', [$product->id]) }}">
                        Buy Now</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection