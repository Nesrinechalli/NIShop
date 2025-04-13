@extends('layouts.shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            @if($product->image_url)
                <img src="{{ $product->image_url }}" class="w-full h-auto object-cover rounded-lg shadow-md" alt="{{ $product->name }}">
            @else
                <div class="bg-gray-200 rounded-lg shadow-md aspect-w-1 aspect-h-1 flex items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-6xl"></i>
                </div>
            @endif
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
            <p class="text-sm text-gray-500 mt-1">Category: {{ $product->category->name }}</p>
            <h2 class="text-2xl font-bold text-indigo-600 mt-4">${{ number_format($product->price, 2) }}</h2>
            
            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-900">Description</h4>
                <p class="mt-2 text-gray-600">{{ $product->description }}</p>
            </div>
            
            <form action="{{ route('shop.cart.add', $product) }}" method="POST" class="mt-8">
                @csrf
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
