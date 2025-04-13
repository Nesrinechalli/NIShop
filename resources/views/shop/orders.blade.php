@extends('layouts.shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">My Orders</h1>
    
    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <span class="font-medium text-gray-900">Order #{{ $order->id }}</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->is_delivered ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $order->is_delivered ? 'Delivered' : 'Pending' }}
                        </span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h5 class="text-lg font-medium text-gray-900 mb-3">Order Details</h5>
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-600"><span class="font-medium text-gray-900">Date:</span> {{ $order->created_at->format('M d, Y H:i') }}</p>
                                    <p class="text-sm text-gray-600"><span class="font-medium text-gray-900">Total Amount:</span> ${{ number_format($order->total_price, 2) }}</p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium text-gray-900">Delivery Status:</span> 
                                        <span class="{{ $order->is_delivered ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ $order->is_delivered ? 'Delivered' : 'Pending' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div>
                                <h5 class="text-lg font-medium text-gray-900 mb-3">Shipping Information</h5>
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-600"><span class="font-medium text-gray-900">Name:</span> {{ $order->client_name }}</p>
                                    <p class="text-sm text-gray-600"><span class="font-medium text-gray-900">Address:</span> {{ $order->client_address }}</p>
                                    <p class="text-sm text-gray-600"><span class="font-medium text-gray-900">Phone:</span> {{ $order->client_phone }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h5 class="text-lg font-medium text-gray-900 mb-3">Product Details</h5>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600"><span class="font-medium text-gray-900">Product:</span> {{ $order->product->name }}</p>
                                <p class="text-sm text-gray-600"><span class="font-medium text-gray-900">Quantity:</span> {{ $order->quantity }}</p>
                                <p class="text-sm text-gray-600"><span class="font-medium text-gray-900">Price per unit:</span> ${{ number_format($order->total_price / $order->quantity, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        You haven't placed any orders yet. <a href="{{ route('shop.index') }}" class="font-medium underline text-blue-700 hover:text-blue-600">Start shopping</a>
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
