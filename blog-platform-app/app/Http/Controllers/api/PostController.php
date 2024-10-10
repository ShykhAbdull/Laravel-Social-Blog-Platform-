<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function store(Request $request){

        $user = Auth::user();
            
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string',
            ]);
            
        $post = new Post();

        $post->post_title = $validatedData['title'];
        $post->post_body = $validatedData['body'];
        $post->user_id = Auth::id();

        $post->save();

        return response()->json(['message' => 'Post created successfully', 
        'post' => $post
    ], 201);

        
    }

}
