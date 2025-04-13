@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Admin Dashboard</h2>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-md overflow-hidden">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h6 class="text-xs font-bold uppercase tracking-wider text-blue-100 mb-1">Orders</h6>
                        <h2 class="text-3xl font-bold text-white mb-1">{{ $totalOrders ?? 0 }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-full w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-2xl text-white"></i>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-blue-100 hover:text-white text-sm flex items-center mt-3">
                    View Details <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-md overflow-hidden">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h6 class="text-xs font-bold uppercase tracking-wider text-green-100 mb-1">Revenue</h6>
                        <h2 class="text-3xl font-bold text-white mb-1">${{ number_format($totalRevenue ?? 0, 2) }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-full w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-2xl text-white"></i>
                    </div>
                </div>
                <div class="text-green-100 text-sm flex items-center mt-3">
                    <i class="fas fa-chart-line mr-1"></i>
                    Total Revenue
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-cyan-500 to-blue-500 rounded-lg shadow-md overflow-hidden">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h6 class="text-xs font-bold uppercase tracking-wider text-blue-100 mb-1">Products</h6>
                        <h2 class="text-3xl font-bold text-white mb-1">{{ $totalProducts ?? 0 }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-full w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-box text-2xl text-white"></i>
                    </div>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-blue-100 hover:text-white text-sm flex items-center mt-3">
                    Manage Products <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg shadow-md overflow-hidden">
            <div class="p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h6 class="text-xs font-bold uppercase tracking-wider text-yellow-100 mb-1">Categories</h6>
                        <h2 class="text-3xl font-bold text-white mb-1">{{ $totalCategories ?? 0 }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-full w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-tags text-2xl text-white"></i>
                    </div>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="text-yellow-100 hover:text-white text-sm flex items-center mt-3">
                    Manage Categories <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-800">Recent Orders</h5>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentOrders ?? [] as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order['id'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order['customer_name'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($order['total'], 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $color = $statusColors[$order['status']] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                        {{ $order['status'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order['created_at']->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center">No recent orders</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-800">Top Products</h5>
                </div>
                <div>
                    <ul class="divide-y divide-gray-200">
                        @forelse($topProducts ?? [] as $product)
                        <li class="px-6 py-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-medium text-gray-800">{{ $product['name'] }}</h6>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $product['orders_count'] }} orders
                                    </p>
                                </div>
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    ${{ number_format($product['revenue'], 2) }}
                                </span>
                            </div>
                        </li>
                        @empty
                        <li class="px-6 py-4 text-sm text-gray-500 text-center">
                            No products found
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
