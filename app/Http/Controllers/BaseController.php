<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth; 

class BaseController extends Controller
{
    public function index()
    {
        $posts = Post::withCount('comments')->get();
        return view('index', compact('posts'));
    }   

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $post = new Post();
            $post->title = $request->title;
            $post->user_id = $request -> user_id;
            $post->description = $request->description;

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/photos', $filename);
                $post->photo = $path;
            }

            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'Post added successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the post. Please try again.',
            ]);
        }
    }
    public function postUpdate(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        if ($post->user_id != auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
        
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        
        if ($request->hasFile('photo')) {            
            if ($post->photo && Storage::exists('public/' . $post->photo)) {
                Storage::delete('public/' . $post->photo);
            }           
            $path = $request->file('photo')->store('posts', 'public');
            $post->photo = $path;
        }
        
        $post->save();

        return response()->json(['success' => 'Post updated successfully', 'post' => $post]);
    }

    public function postDelete($id)
    {
        $post = Post::findOrFail($id);
    
        // Authorization Check
        if ($post->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Delete Post Image
        if ($post->photo && Storage::exists('public/' . $post->photo)) {
            Storage::delete('public/' . $post->photo);
        }
    
        // Delete Post
        $post->delete();
    
        return response()->json(['success' => 'Post deleted successfully']);
    }

    public function addComment(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'comment' => 'required|string|max:500',
            'user_id' => 'required|exists:user,id',
            'id' => 'required|exists:posts,id', 
        ]);

        // Create the new comment
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->id; 
        $comment->comment = $request->comment;
        $comment->save(); 

        // Return a response
        return response()->json(['success' => 'Comment added successfully']);
    }

    public function editComment(Request $request, $id)
    {
         // Validate the comment content
         $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        // Find the comment by ID
        $comment = Comment::findOrFail($id);

        // Check if the logged-in user is the author of the comment
        if ($comment->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update the comment
        $comment->update([
            'comment' => $request->comment,
        ]);

        return response()->json(['success' => 'Comment updated successfully']);
    }
    public function deleteComment($id)
    {
        // Find the comment by ID
        $comment = Comment::findOrFail($id);

        // Check if the logged-in user is the author of the comment
        if ($comment->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);  // Unauthorized if the user is not the author
        }

        // Delete the comment
        $comment->delete();

        // Return a success response
        return response()->json(['success' => 'Comment deleted successfully']);
    }

        
}
