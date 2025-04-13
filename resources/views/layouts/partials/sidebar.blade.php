<!-- Admin Sidebar -->
<div class="min-h-screen w-64 bg-gray-800 text-white fixed left-0 top-0 z-30 transition-all duration-300 transform" 
     x-data="{ open: true }" 
     :class="{'translate-x-0': open, '-translate-x-full': !open}">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-700">
        <div class="flex items-center">
            <span class="text-xl font-bold text-white">{{ config('app.name', 'NIShop') }}</span>
        </div>
        <button @click="open = !open" class="lg:hidden text-gray-300 hover:text-white">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    
    <!-- Sidebar Content -->
    <div class="py-4">
        <ul class="space-y-2 px-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                    <div class="flex items-center">
                        <i class="fas fa-box mr-3"></i>
                        <span>Products</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open" class="mt-2 space-y-1 px-2" style="display: none;">
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="flex items-center pl-8 pr-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.products.index') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-list mr-3"></i>
                            <span>All Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.create') }}" class="flex items-center pl-8 pr-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.products.create') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-plus mr-3"></i>
                            <span>Add Product</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                    <div class="flex items-center">
                        <i class="fas fa-tags mr-3"></i>
                        <span>Categories</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open" class="mt-2 space-y-1 px-2" style="display: none;">
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center pl-8 pr-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.categories.index') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-list mr-3"></i>
                            <span>All Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.create') }}" class="flex items-center pl-8 pr-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.categories.create') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-plus mr-3"></i>
                            <span>Add Category</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    <span>Orders</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-users mr-3"></i>
                    <span>Users</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md {{ request()->routeIs('admin.settings') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-cog mr-3"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Sidebar Footer -->
    <div class="absolute bottom-0 w-full border-t border-gray-700">
        <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
            <i class="fas fa-store mr-3"></i>
            <span>View Shop</span>
        </a>
    </div>
</div>

<!-- Mobile sidebar toggle -->
<div class="lg:hidden fixed bottom-4 left-4 z-40">
    <button x-data="{ open: false }" @click="open = !open; $dispatch('toggle-sidebar', {open})" class="bg-indigo-600 text-white p-3 rounded-full shadow-lg hover:bg-indigo-700 focus:outline-none">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
</div>
