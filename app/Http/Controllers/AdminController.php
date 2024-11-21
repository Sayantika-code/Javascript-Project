<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{        
    public function dashboard()
    {
        $totalPosts = Post::count();
        $totalComments = Comment::count();
        $totalUsers = User::count();
        $blockedUsers = User::where('status', 'Blocked')->count();        
        $recentPosts = Post::orderBy('created_at', 'desc')->limit(5)->get();
    
        return view('admin.index', compact('totalPosts', 'totalComments', 'totalUsers', 'blockedUsers', 'recentPosts'));
    }
    public function post()
    {         
        $posts = Post::with('user')->get();      
        return view('admin.post', compact('posts'));
    }
    public function updatePosts(Request $request, $id)
    {
        // Find the post by ID
        $post = Post::findOrFail($id);

        // Validate incoming data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',     
        ]);

        // Update the post data
        $post->title = $validatedData['title'];
        $post->photo = $validatedData['photo'] ?? $post->photo;       

        // Save the updated post
        $post->save();

        // Return a success response
        return response()->json(['message' => 'Post updated successfully']);
    }

    public function deletePosts($id)
    {
        // Find the post by ID
        $post = Post::find($id);

        // Check if the post exists
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
        }

        // Delete the post
        $post->delete();

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Post deleted successfully.']);
    }

    public function comment()
    {         
        $comments = Comment::with(['user', 'post'])->get();
     
        return view('admin.comment', compact('comments'));
    }
    public function deleteComments($id)
    {
        // Find the post by ID
        $comment = Comment::find($id);

        // Check if the post exists
        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'comment not found.'], 404);
        }

        // Delete the comment
        $comment->delete();

        // Return a success response
        return response()->json(['success' => true, 'message' => 'comment deleted successfully.']);
    }

    public function user()
    {
        $users = User ::where('user_type','user')->get();
        return view('admin.user',compact('users'));
    }

    public function incactiveUser($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Toggle the status between 'active' and 'blocked'
        $user->status = ($user->status == 'Active') ? 'Blocked' : 'Active';
        $user->save();

        return response()->json([
            'message' => 'User status updated successfully',
            'status' => $user->status,
        ]);
    }
}
