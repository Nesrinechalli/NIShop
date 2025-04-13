<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Category;
use GuzzleHttp\Client;

class OpenAIController extends Controller
{
    public function showForm()
    {
        $categories = Category::all();
        return view('products.generate', compact('categories'));
    }

    public function generateProduct(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'keywords' => 'required|string'
            ]);

            $category = Category::find($validated['category_id']);
            if (!$category) {
                return Response::json([
                    'error' => 'Category not found'
                ], 404);
            }

            // Prepare the prompt
            $prompt = "Generate a product for the {$category->name} category with these features: {$validated['keywords']}. " .
                     "Format the response as a valid JSON object with exactly these fields:\n" .
                     "{\n" .
                     "  \"name\": \"product name here\",\n" .
                     "  \"description\": \"detailed product description here\",\n" .
                     "  \"price\": number\n" .
                     "}\n" .
                     "Make the description detailed and marketing-focused. For the price, ensure it is reasonable and competitive - " .
                     "research typical market prices for similar products in this category. The price should reflect real-world " .
                     "pricing and be affordable for the average consumer. Do not overprice or underprice. " .
                     "Return ONLY the JSON object, no other text.";

            // Check if this is an AJAX request
            if ($request->ajax()) {
                // Call Google Gemini API
                $response = Http::withoutVerifying()->withHeaders([
                    'Content-Type' => 'application/json',
                ])->post('https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key=' . env('GOOGLE_API_KEY'), [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $prompt
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'topK' => 40,
                        'topP' => 0.8,
                        'maxOutputTokens' => 1000,
                    ]
                ]);

                $data = $response->json();

                // Log API response for debugging
                Log::info('AI Response: ' . json_encode($data));

                // Check for API errors first
                if (isset($data['error'])) {
                    Log::error('Gemini API Error: ' . json_encode($data['error']));
                    return Response::json([
                        'error' => 'AI API Error: ' . ($data['error']['message'] ?? 'Unknown error')
                    ], 400);
                }

                // Check if response contains expected fields
                if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return Response::json([
                        'error' => 'AI response is missing expected data',
                        'raw_response' => json_encode($data)
                    ], 400);
                }

                // Get the response text and clean it up
                $assistantReply = $data['candidates'][0]['content']['parts'][0]['text'];
                $assistantReply = preg_replace('/```json\s*|\s*```/', '', trim($assistantReply));
                
                // Parse the JSON from the response
                $productData = json_decode($assistantReply, true);

                if (!is_array($productData)) {
                    // Try to extract JSON if wrapped in other text
                    preg_match('/\{.*\}/s', $assistantReply, $matches);
                    $productData = isset($matches[0]) ? json_decode($matches[0], true) : null;

                    if (!is_array($productData)) {
                        return Response::json([
                            'error' => 'Failed to parse AI response as JSON',
                            'raw_response' => $assistantReply
                        ], 400);
                    }
                }

                // Validate required fields
                if (!isset($productData['name']) || !isset($productData['description']) || !isset($productData['price'])) {
                    return Response::json([
                        'error' => 'AI response missing required fields',
                        'data' => $productData
                    ], 400);
                }

                return Response::json([
                    'success' => true,
                    'product' => $productData
                ]);
            } else {
                // For non-AJAX requests, render the form view
                $categories = Category::all();
                return view('products.generate', compact('categories'));
            }

        } catch (\Exception $e) {
            Log::error('Product generation error: ' . $e->getMessage());
            if ($request->ajax()) {
                return Response::json([
                    'error' => 'Failed to generate product: ' . $e->getMessage()
                ], 500);
            } else {
                return back()->with('error', 'Failed to generate product: ' . $e->getMessage());
            }
        }
    }

    public function generateImage(Request $request)
    {
        try {
            $request->validate([
                'prompt' => 'required|string'
            ]);

            // Call Hugging Face API for image generation with SSL verification disabled
            $response = Http::withoutVerifying() // Disable SSL verification
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('HF_API_KEY'),
                    'Content-Type' => 'application/json'
                ])->post('https://api-inference.huggingface.co/models/stabilityai/stable-diffusion-3-medium-diffusers', [
                    'inputs' => $request->prompt
                ]);

            if ($response->successful()) {
                // For this model, the response is a binary image
                $imageData = $response->body();
                
                // Check if the response is actually an image
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($imageData);
                
                if (strpos($mimeType, 'image/') === false) {
                    Log::error('Invalid image data received. MIME type: ' . $mimeType);
                    Log::error('Response body: ' . substr($imageData, 0, 1000));
                    return response()->json([
                        'error' => 'Invalid image data received from API'
                    ], 500);
                }

                // Generate a unique filename
                $filename = uniqid() . '.png';
                $path = 'products/' . $filename;
                
                // Ensure the products directory exists
                $directory = storage_path('app/public/products');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }
                
                // Store the image
                if (!Storage::disk('public')->put($path, $imageData)) {
                    Log::error('Failed to save image to storage');
                    return response()->json([
                        'error' => 'Failed to save image'
                    ], 500);
                }

                // Double check the file exists
                if (!Storage::disk('public')->exists($path)) {
                    Log::error('File was not saved correctly');
                    return response()->json([
                        'error' => 'Failed to verify saved image'
                    ], 500);
                }

                // Get the full URL for the image using the storage URL
                $imageUrl = url('storage/' . $path);

                return response()->json([
                    'success' => true,
                    'filename' => $path,
                    'url' => $imageUrl
                ]);
            } else {
                $error = $response->body();
                Log::error('Hugging Face API Error: ' . $error);
                return response()->json([
                    'error' => 'Failed to generate image: ' . $error
                ], $response->status());
            }

        } catch (\Exception $e) {
            Log::error('Image generation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Failed to generate image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'image' => 'required|string'
            ]);

            // Create the product
            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $request->image,
                'status' => 1 // Active by default
            ]);

            if (!$product) {
                throw new \Exception('Failed to create product');
            }

            return response()->json([
                'success' => true,
                'message' => 'Product saved successfully',
                'product' => $product
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to save product: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to save product: ' . $e->getMessage()
            ], 500);
        }
    }
}
