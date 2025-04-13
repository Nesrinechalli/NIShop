@extends('layouts.shop')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-1/4">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-indigo-600 text-white px-4 py-2 font-semibold">Categories</div>
                <div class="divide-y divide-gray-200">
                    <a href="{{ route('shop.index') }}" 
                       class="block px-4 py-2 {{ !isset($category) ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        All Products
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('shop.category', $cat) }}" 
                           class="block px-4 py-2 {{ isset($category) && $category->id == $cat->id ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-full md:w-3/4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <h5 class="text-lg font-semibold mb-2 text-gray-900">{{ $product->name }}</h5>
                            <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($product->description, 100) }}</p>
                            <p class="text-indigo-600 font-bold text-lg mb-4">${{ number_format($product->price, 2) }}</p>
                            <div class="flex justify-between items-center">
                                <a href="{{ route('shop.product.show', $product) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200 transition-colors">
                                    <span>View Details</span>
                                </a>
                                <form action="{{ route('shop.cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>Add to Cart</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
