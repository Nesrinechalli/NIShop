<!-- Main Footer -->
<footer class="bg-gray-800 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h5 class="text-lg font-semibold mb-4">About Us</h5>
                <p class="text-gray-300 mb-4">Your trusted online store for quality products. We provide the best shopping experience with a wide range of products and excellent customer service.</p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fab fa-linkedin fa-lg"></i>
                    </a>
                </div>
            </div>
            <div>
                <h5 class="text-lg font-semibold mb-4">Quick Links</h5>
                <ul class="space-y-2">
                    <li><a href="{{ route('shop.index') }}" class="text-gray-300 hover:text-white transition-colors">Shop</a></li>
                    <li><a href="{{ route('shop.cart') }}" class="text-gray-300 hover:text-white transition-colors">Cart</a></li>
                    @auth
                        <li><a href="{{ route('shop.orders') }}" class="text-gray-300 hover:text-white transition-colors">My Orders</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition-colors">Register</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h5 class="text-lg font-semibold mb-4">Contact Info</h5>
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-2 text-gray-400"></i>
                        <span class="text-gray-300">123 Street, City, Country</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone mt-1 mr-2 text-gray-400"></i>
                        <span class="text-gray-300">+1 234 567 890</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-envelope mt-1 mr-2 text-gray-400"></i>
                        <span class="text-gray-300">info@example.com</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-2 md:mb-0">
                    Copyright &copy; 2025 <a href="#" class="text-indigo-400 hover:text-indigo-300">{{ config('app.name', 'NIShop') }}</a>. All rights reserved.
                </p>
                <p class="text-gray-500 text-sm">Version 1.0</p>
            </div>
        </div>
    </div>
</footer>