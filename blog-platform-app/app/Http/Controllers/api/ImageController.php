<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Validate that a file is present
        $validatedData = $request->validate([
            'image_name' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Handle the file upload
        if ($request->hasFile('image_path')) {
            //Image_name that came after passing the validation rules comes into
            $image_name = $validatedData['image_name'];
            // Store in the 'storage/app/public/images' directory
            $imagePath = $request->file('image_path')->store('images','public');

            // Save the image path to the database
            Image::create([
                'user_id' => Auth::id(),
                'image_path' => $imagePath,
                'image_name' => $image_name,
            ]);
    
            return response()->json([
            'success' => 'Image uploaded successfully', 
            'name' => $image_name,
            'path' => $imagePath,
        ],201);
        }
    
        return response()->json(['error' => 'Image upload failed'], 500);
    }

}

