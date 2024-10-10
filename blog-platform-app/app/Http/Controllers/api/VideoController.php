<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function uploadVideo(Request $request){

        $validatedData = $request->validate([
            'video_name' => 'required|string|max:255',
            'video_path' => 'required|mimes:mp4,mov,avi,mkv|max:102400',
        ]);

        $check = Auth::check();

        if($check ) {
        $videoName = $validatedData['video_name'];
        $videoPath = $request->file('video_path')->store('videos','public');

        Video::create([
            'user_id' => Auth::id(),
            'video_name' => $videoName,
            'video_path' => $videoPath
        ]);

        return response()->json([
            'message' => 'Video Uploaded  Successfully',
            'Video Name ' => $videoName,
            'Video Path' => $videoPath
        ],201);

    }
    return response()->json(['error' => 'User Not Authenticated'], 401);
} 

}
