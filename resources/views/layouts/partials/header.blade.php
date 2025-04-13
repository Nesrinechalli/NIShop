<!-- resources/views/layout_frontEnd/header.blade.php -->

<!-- Navbar -->
<nav class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('shop.index') }}" class="flex-shrink-0 flex items-center">
                    <i class="fas fa-shopping-bag text-white text-2xl mr-2"></i>
                    <span class="text-white font-semibold text-xl">{{ config('app.name', 'NIShop') }}</span>
                </a>
                <div class="hidden md:ml-6 md:flex md:space-x-4">
                    <a href="{{ route('shop.index') }}" class="text-white hover:bg-indigo-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-store mr-1"></i>
                        <span>Shop</span>
                    </a>
                    <a href="{{ route('shop.cart') }}" class="text-white hover:bg-indigo-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center relative">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        <span>Cart</span>
                        @if(session('cart'))
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ count((array) session('cart')) }}
                            </span>
                        @endif
                    </a>
                    @auth
                        <a href="{{ route('shop.orders') }}" class="text-white hover:bg-indigo-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center">
                            <i class="fas fa-box mr-1"></i>
                            <span>My Orders</span>
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Search Form -->
            <div class="hidden md:flex md:items-center">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-white opacity-70"></i>
                    </div>
                    <input class="bg-indigo-500 bg-opacity-50 text-white placeholder-white placeholder-opacity-70 rounded-md py-2 pl-10 pr-4 w-64 focus:outline-none focus:ring-2 focus:ring-white" type="search" placeholder="Search products..." aria-label="Search">
                </div>
            </div>

            <!-- Right navbar links -->
            <div class="hidden md:flex md:items-center">
                @guest
                    <a class="text-white hover:bg-indigo-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt mr-1"></i>
                        <span>{{ __('Login') }}</span>
                    </a>
                    <a class="text-white hover:bg-indigo-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center ml-3" href="{{ route('register') }}">
                        <i class="fas fa-user-plus mr-1"></i>
                        <span>{{ __('Register') }}</span>
                    </a>
                @else
                    @if(Auth::user()->isAdmin())
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" class="text-white hover:bg-indigo-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center">
                                    <i class="fas fa-user-shield mr-1"></i>
                                    <span>Admin Panel</span>
                                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                </button>
                            </div>
                            <div x-show="open" 
                                 @click.away="open = false"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt mr-2"></i>
                                    <span>Dashboard</span>
                                </a>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('admin.products.index') }}">
                                    <i class="fas fa-box mr-2"></i>
                                    <span>Products</span>
                                </a>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('admin.categories.index') }}">
                                    <i class="fas fa-tags mr-2"></i>
                                    <span>Categories</span>
                                </a>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('admin.orders.index') }}">
                                    <i class="fas fa-shopping-bag mr-2"></i>
                                    <span>Orders</span>
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" class="text-white hover:bg-indigo-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium flex items-center">
                                <i class="fas fa-user mr-1"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>
                        </div>
                        <div x-show="open" 
                             @click.away="open = false"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('shop.orders') }}">
                                <i class="fas fa-box mr-2"></i>
                                <span>My Orders</span>
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>{{ __('Logout') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Open main menu</span>
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="mobile-menu hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('shop.index') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                <i class="fas fa-store mr-1"></i>
                <span>Shop</span>
            </a>
            <a href="{{ route('shop.cart') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium relative">
                <i class="fas fa-shopping-cart mr-1"></i>
                <span>Cart</span>
                @if(session('cart'))
                    <span class="absolute top-2 right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ count((array) session('cart')) }}
                    </span>
                @endif
            </a>
            @auth
                <a href="{{ route('shop.orders') }}" class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-box mr-1"></i>
                    <span>My Orders</span>
                </a>
            @endauth
            @guest
                <a class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt mr-1"></i>
                    <span>{{ __('Login') }}</span>
                </a>
                <a class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium" href="{{ route('register') }}">
                    <i class="fas fa-user-plus mr-1"></i>
                    <span>{{ __('Register') }}</span>
                </a>
            @else
                @if(Auth::user()->isAdmin())
                    <div class="border-t border-indigo-500 pt-2 mt-2">
                        <p class="px-3 text-xs font-semibold text-white uppercase tracking-wider">Admin</p>
                        <a class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt mr-1"></i>
                            <span>Dashboard</span>
                        </a>
                        <a class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium" href="{{ route('admin.products.index') }}">
                            <i class="fas fa-box mr-1"></i>
                            <span>Products</span>
                        </a>
                        <a class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium" href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags mr-1"></i>
                            <span>Categories</span>
                        </a>
                        <a class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium" href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-shopping-bag mr-1"></i>
                            <span>Orders</span>
                        </a>
                    </div>
                @endif
                <div class="border-t border-indigo-500 pt-2 mt-2">
                    <p class="px-3 text-xs font-semibold text-white uppercase tracking-wider">Account</p>
                    <a class="text-white hover:bg-indigo-500 block px-3 py-2 rounded-md text-base font-medium" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>
<!-- /.navbar -->

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>
