<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function generate(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('generate_image_form');
        }

        $prompt = $request->input('prompt');
        Log::info('Received prompt: ' . $prompt);

        try {
            $response = Http::post('https://8fb7-34-125-234-236.ngrok-free.app/generate', [
                'prompt' => $prompt,
            ]);
            Log::info('API response: ' . $response->body());

            if ($response->failed()) {
                Log::error('Failed to generate image');
                return response()->json(['error' => 'Failed to generate image'], 500);
            }

            $data = $response->json();
            $imageData = base64_decode($data['image']);
            $imageName = 'generated_image.png';
            $path = public_path('images/' . $imageName);
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0777, true);
            }
            file_put_contents($path, $imageData);
            Log::info('Image saved at: ' . $path);

            $imageUrl = asset('images/' . $imageName);
            return response()->json(['image_path' => $imageUrl]);

        } catch (\Exception $e) {
            Log::error('Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Exception occurred: ' . $e->getMessage()], 500);
        }
    }
}
