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
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Dashboard</a>
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

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form id="generateForm" action="{{ route('admin.openai.generate-product') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <!-- Category Selection -->
                    <div>
                        <label for="categorySelect" class="block text-sm font-medium text-gray-700">Category</label>
                        <select id="categorySelect" name="category_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="" disabled selected>Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Keywords Input -->
                    <div>
                        <label for="keywordsInput" class="block text-sm font-medium text-gray-700">Keywords</label>
                        <textarea id="keywordsInput" name="keywords" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter product keywords (e.g., modern, comfortable, durable)"></textarea>
                        <p class="mt-2 text-sm text-gray-500">Separate keywords with commas for better results</p>
                    </div>

                    <!-- Generate Button -->
                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            Generate Product
                        </button>
                    </div>
                </div>
            </form>

            <!-- Result Section -->
            <div id="result" class="mt-8 hidden">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Generated Product</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <div id="productData" class="space-y-4"></div>
                            </div>
                            <div>
                                <div id="imageContainer" class="hidden">
                                    <img id="generatedImage" src="" alt="Generated Product Image" class="w-full h-auto rounded-lg shadow-md mb-4">
                                    <button id="regenerateImage" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Regenerate Image
                                    </button>
                                </div>
                                <div id="imageLoading" class="hidden">
                                    <div class="flex flex-col items-center justify-center p-4">
                                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-500"></div>
                                        <p class="mt-2 text-sm text-gray-500">Generating image...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button id="saveProduct" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
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
$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let currentProduct = null;
    let currentImagePath = null;

    function generateImage(productName) {
        $('#imageContainer').hide();
        $('#imageLoading').show();

        $.ajax({
            url: "{{ route('admin.openai.image') }}",
            method: 'POST',
            data: {
                prompt: `Professional product photo of ${productName}, white background, high quality, commercial style`
            },
            success: function(response) {
                console.log('Image generation response:', response);
                if (response.success) {
                    currentImagePath = response.filename;
                    $('#generatedImage').attr('src', response.url);
                    $('#imageContainer').show();
                } else {
                    console.error('Image generation error:', response.error);
                    alert('Error generating image: ' + response.error);
                }
            },
            error: function(xhr) {
                console.error('AJAX error:', xhr.responseText);
                alert('Error: ' + (xhr.responseJSON?.error || 'Failed to generate image'));
            },
            complete: function() {
                $('#imageLoading').hide();
            }
        });
    }

    $('#generateForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log('Product generation response:', response);
                if (response.success) {
                    currentProduct = response.product;
                    $('#productData').html(`
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Name</h3>
                                <p class="mt-1 text-lg font-semibold text-gray-900">${currentProduct.name}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Description</h3>
                                <p class="mt-1 text-gray-900">${currentProduct.description}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Price</h3>
                                <p class="mt-1 text-2xl font-bold text-indigo-600">$${currentProduct.price.toFixed(2)}</p>
                            </div>
                        </div>
                    `);
                    $('#result').show();
                    
                    // Generate image for the product
                    generateImage(currentProduct.name);
                } else {
                    console.error('Product generation error:', response.error);
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr) {
                console.error('AJAX error:', xhr.responseText);
                alert('Error: ' + (xhr.responseJSON?.error || 'Failed to generate product'));
            }
        });
    });

    $('#regenerateImage').on('click', function() {
        if (currentProduct) {
            generateImage(currentProduct.name);
        }
    });

    $('#saveProduct').on('click', function() {
        if (!currentProduct || !currentImagePath) {
            alert('Please wait for both product and image generation to complete.');
            return;
        }

        const productData = {
            category_id: $('#categorySelect').val(),
            name: currentProduct.name,
            description: currentProduct.description,
            price: currentProduct.price,
            image: currentImagePath
        };

        $.ajax({
            url: "{{ route('admin.openai.store') }}",
            method: 'POST',
            data: productData,
            success: function(response) {
                console.log('Save product response:', response);
                if (response.success) {
                    alert('Product saved successfully!');
                    window.location.href = "{{ route('admin.products.index') }}";
                } else {
                    console.error('Save product error:', response.error);
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr) {
                console.error('AJAX error:', xhr.responseText);
                alert('Error: ' + (xhr.responseJSON?.error || 'Failed to save product'));
            }
        });
    });
});
</script>
@endpush
@endsection
