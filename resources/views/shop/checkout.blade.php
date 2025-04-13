@extends('layouts.shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h4 class="font-semibold text-lg text-gray-900">Checkout</h4>
                </div>
                <div class="p-6">
                    @guest
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Please <a href="{{ route('login') }}" class="font-medium underline text-blue-700 hover:text-blue-600">login</a> to continue with checkout.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('shop.place-order') }}" method="POST">
                            @csrf

                            <div class="mb-6">
                                <label for="client_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('client_name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror" 
                                       id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                                @error('client_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="client_address" class="block text-sm font-medium text-gray-700 mb-1">Delivery Address</label>
                                <textarea class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('client_address') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror" 
                                          id="client_address" name="client_address" rows="3" required>{{ old('client_address') }}</textarea>
                                @error('client_address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="client_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('client_phone') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror" 
                                       id="client_phone" name="client_phone" value="{{ old('client_phone') }}" required>
                                @error('client_phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Place Order
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h4 class="font-semibold text-lg text-gray-900">Order Summary</h4>
                </div>
                <div class="p-6">
                    @php $total = 0 @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h6 class="text-sm font-medium text-gray-900">{{ $details['name'] }}</h6>
                                    <p class="text-xs text-gray-500">Qty: {{ $details['quantity'] }}</p>
                                </div>
                                <span class="text-sm font-medium text-gray-900">${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    @endif

                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <div class="flex justify-between items-center">
                            <h5 class="text-base font-semibold text-gray-900">Total:</h5>
                            <h5 class="text-base font-semibold text-gray-900">${{ number_format($total, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
