<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Faker\Extension\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommmentController extends Controller
{
    public function uploadComment(Request $request, $type, $id){
        $validatedData = $request->validate([
            'content' => 'required|string|max:500'
        ]);

        // Only If User is Authorized the Comment would be posted
        $check = Auth::check();
        if($check){   

            $commentable = getCommentsModel($type, $id);
            $commentable->comments()->create([
                    'user_id' => Auth::id(),
                    'content' => $validatedData['content'],
                ]);

                return response()->json(['message' => 'Comment added successfully'],201);
        }

        return response()->json(['error' => 'User Not Authenticated'], 500);
    }
public function updateComment(Request $request, $type, $id, $cmnt_id){

    $validatedData = $request->validate([
        'content' => 'required|string|max:500'
    ]);

    // Using this Helper Function, the Model of content type and id of that specific content will be returned   
    $commentable = getCommentsModel($type, $id);
    $comment = $commentable->comments()->findOrFail($cmnt_id);

        // Update the comment content
        $comment->update([
            'content' => $validatedData['content'],
        ]);
    
        // Return a response indicating the comment was updated
        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $comment,
        ], 200);
}

public function deleteComment($type, $id, $commentId)
{
    // Find the model (Post, Video, or Image)
    $commentable = getCommentsModel($type, $id);
    $comment = $commentable->comments()->findOrFail($commentId);

    // Delete the comment
    $comment->delete();

    return response()->json([
        'message' => 'Comment deleted successfully'
    ], 200);
}




}
