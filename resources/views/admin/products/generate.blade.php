@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Content Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-gray-900">Generate New Product</h1>
            </div>
            <div class="mt-4 md:mt-0">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="{{ route('admin.products.index') }}" class="ml-2 text-gray-500 hover:text-gray-700">Products</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2 text-gray-500">Generate Product</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">AI-Powered Product Generator</h3>
            <p class="mt-1 text-sm text-gray-600">Generate product details using AI and save them to your store.</p>
        </div>
        
        <div class="p-6">
            <form id="generateForm" action="{{ route('admin.openai.generate-product') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="category_id" name="category_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                            <option value="" disabled selected>Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="keywords" class="block text-sm font-medium text-gray-700 mb-1">Keywords</label>
                        <textarea id="keywords" name="keywords" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter product keywords (e.g., modern, comfortable, durable)" required></textarea>
                        <p class="mt-1 text-sm text-gray-500">Separate keywords with commas for better results</p>
                    </div>
                </div>
                
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd" />
                        </svg>
                        Generate Product
                    </button>
                </div>
            </form>
            
            <!-- Loading indicator -->
            <div id="loading" class="hidden mt-6 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-purple-500"></div>
                <p class="mt-2 text-sm text-gray-600">Generating product details...</p>
            </div>
            
            <!-- Result section -->
            <div id="result" class="hidden mt-8">
                <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Generated Product</h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <div id="productData" class="space-y-4"></div>
                            </div>
                            
                            <div>
                                <div id="imageContainer" class="hidden">
                                    <div class="bg-white p-2 border border-gray-200 rounded-lg shadow-sm">
                                        <img id="generatedImage" src="" alt="Generated Product Image" class="w-full h-auto rounded-md">
                                        <div class="mt-2 text-center">
                                            <button id="regenerateImage" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Regenerate Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="imageLoading" class="hidden text-center p-6 bg-white border border-gray-200 rounded-lg">
                                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-indigo-500"></div>
                                    <p class="mt-2 text-sm text-gray-600">Generating image...</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button id="saveProduct" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Save Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Setup CSRF token for all AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    let currentProduct = null;
    let currentImageUrl = null;
    let categoryId = null;
    
    const generateForm = document.getElementById('generateForm');
    const loadingElement = document.getElementById('loading');
    const resultElement = document.getElementById('result');
    const productDataElement = document.getElementById('productData');
    const imageContainerElement = document.getElementById('imageContainer');
    const imageLoadingElement = document.getElementById('imageLoading');
    const generatedImageElement = document.getElementById('generatedImage');
    const regenerateImageButton = document.getElementById('regenerateImage');
    const saveProductButton = document.getElementById('saveProduct');
    
    // Function to generate product image
    function generateImage(productName, productDescription) {
        imageContainerElement.classList.add('hidden');
        imageLoadingElement.classList.remove('hidden');
        
        fetch('{{ route("admin.openai.generate-image") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_name: productName,
                product_description: productDescription
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.image_url) {
                currentImageUrl = data.image_url;
                generatedImageElement.src = data.image_url;
                imageContainerElement.classList.remove('hidden');
            } else {
                alert('Error generating image: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error generating image. Please try again.');
        })
        .finally(() => {
            imageLoadingElement.classList.add('hidden');
        });
    }
    
    // Handle form submission
    generateForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        loadingElement.classList.remove('hidden');
        resultElement.classList.add('hidden');
        
        const formData = new FormData(generateForm);
        categoryId = formData.get('category_id');
        
        fetch(generateForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.product) {
                currentProduct = data.product;
                
                // Display product data
                productDataElement.innerHTML = `
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">Name</h4>
                        <p class="mt-1 text-gray-800">${currentProduct.name}</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">Description</h4>
                        <p class="mt-1 text-gray-800">${currentProduct.description}</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">Price</h4>
                        <p class="mt-1 text-2xl font-semibold text-indigo-600">$${parseFloat(currentProduct.price).toFixed(2)}</p>
                    </div>
                `;
                
                resultElement.classList.remove('hidden');
                
                // Generate image for the product
                generateImage(currentProduct.name, currentProduct.description);
            } else {
                alert('Error: ' + (data.error || 'Failed to generate product'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error generating product. Please try again.');
        })
        .finally(() => {
            loadingElement.classList.add('hidden');
        });
    });
    
    // Handle image regeneration
    regenerateImageButton.addEventListener('click', function() {
        if (currentProduct) {
            generateImage(currentProduct.name, currentProduct.description);
        }
    });
    
    // Handle product saving
    saveProductButton.addEventListener('click', function() {
        if (!currentProduct) {
            alert('Please generate a product first.');
            return;
        }
        
        fetch('{{ route("admin.openai.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: currentProduct.name,
                description: currentProduct.description,
                price: currentProduct.price,
                category_id: categoryId,
                image_url: currentImageUrl
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product saved successfully!');
                window.location.href = data.redirect || '{{ route("admin.products.index") }}';
            } else {
                alert('Error: ' + (data.error || 'Failed to save product'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving product. Please try again.');
        });
    });
});
</script>
@endpush
@endsection
