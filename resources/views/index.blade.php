<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog Home Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            background: #fff;
            border-right: 1px solid #ddd;
            padding: 20px;
            height: 100vh;
            position: fixed;
            width: 250px; /* Adjusted for better layout */
            overflow-y: auto;
        }
        .sidebar img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .content {
            margin-left: 270px; /* Adjusted to accommodate sidebar */
            padding: 20px;
        }
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .top-bar input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .top-bar .btn {
            background: #ffc107;
            color: #000;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
        }
        .post {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .post-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }
        .post-header .author {
            font-weight: bold;
        }
        .post-content img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-top: 15px;
        }
        .post-actions {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-top: 10px;
        }
        .post-actions span {
            margin-right: 15px;
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #666;
        }
        .post-actions span i {
            margin-right: 5px;
        }
        /* modal */
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
        }
        /* Styling the comment box */
        .comment-box {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Comment text styling */
        .comments {
            font-size: 14px;
            color: #333;
            margin: 0;
        }

        /* Styling the edit and delete links */
        .comment-actions {
            margin-top: 5px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .comment-actions a {
            font-size: 12px;
            color: #007bff;
            text-decoration: none;
            margin-right: 5px;
        }

        .comment-actions a:hover {
            text-decoration: underline;
        }

        .comment-actions span {
            font-size: 12px;
            color: #999;
        }
        .modal-backdrop.show {
            opacity: 0 !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">

        <div class="post-header">
        <img width="150" height="150" src="https://img.icons8.com/bubbles/100/user.png" alt="user"/>
        @if (auth()->check() && auth()->user()->user_type === "User")
            <div>
                <div class="author">{{ auth()->user()->name }}</div>
            </div>
        @else
            <div class="author">No User</div>
        @endif


        </div>
        @if(auth()->check() && auth()->user()->user_type === "User")
            <button class="btn btn-primary btn-block mb-3" data-toggle="modal" data-target="#profileModal{{ auth()->user()->id ?? '' }}  ">
                Open Profile
            </button>
        <!-- Profile Modal -->
        <div class="modal fade" id="profileModal{{ auth()->user()->id ?? '' }}" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profileModalLabel">Add Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">                   
                    <div class="profile-info">
                        <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>                        
                        <p><strong>Joined:</strong> {{ auth()->user()->created_at->format('d/m/Y') }}</p>                        
                    </div>                   
                </div>
                </div>
            </div>
        </div>
        @else
        <a href="/login"><button class="btn btn-primary btn-block mb-3">Open Profile</button></a>
        @endif
        <a href="/register"><button class="btn btn-success btn-block mb-3">Create Profile</button></a>       
        <!-- Log Out Button -->
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-block btn-danger mt-3"><i class="ion ion-power"></i> Log Out</button>
        </form>
    </div>

    <!-- Content -->
    <div class="content">
        
        <div class="top-bar">
        @if (auth()->check() && auth()->user()->user_type === "User")
            <input type="text" placeholder="What do you want to ask or share?" class="form-control" data-toggle="modal" data-target="#addPostModal" >
        @else
            <input type="text" placeholder="What do you want to ask or share?" class="form-control" id="addPostTrigger">
        @endif    
        </div>

        <!-- Add Post Modal -->
        <div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="addPostModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPostModalLabel">Add Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addPostForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? '' }}">
                            <div class="form-group">
                                <label for="postTitle">Title</label>
                                <input type="text" class="form-control" id="postTitle" name="title" placeholder="Enter title" required>
                            </div>
                            <div class="form-group">
                                <label for="postDescription">Description</label>
                                <textarea class="form-control" id="postDescription" rows="4" name="description" placeholder="Enter description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="postPhoto">Photo</label>
                                <input type="file" class="form-control-file" id="postPhoto" name="photo" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Add Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @foreach($posts as $post)
        <div class="post">
            <div class="post-header">
            <img width="100" height="100" src="https://img.icons8.com/bubbles/100/user.png" alt="user"/>
                <div>
                    <div class="author">{{$post->user->name}}</div>
                    <div class="date text-muted">{{$post->created_at}}</div>
                </div>
                <div class="dropdown ml-auto">                    
                    @if(auth()->user() && auth()->user()->id == $post->user_id)
                        <button class="btn btn-link" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item" data-toggle="modal" data-target="#editPostModal{{$post->id}}" data-id="{{ $post->id }}" data-title="{{ $post->title }}" data-description="{{ $post->description }}" data-photo="{{ $post->photo }}">Edit</button>
                            <form class="deletePost" data-post-id="{{ $post->id }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

            </div>
            <div class="post-body">
                <h5>{{$post->title}}</h5>
                <p>{{$post->description}}</p>
                <div class="post-content">
                @if($post->photo)
                    <img src="{{ asset('storage/app/' . $post->photo) }}" alt="Post Image" class="img-fluid">
                @else
                    <img src="https://via.placeholder.com/700x400" >
                @endif
                   
                </div>
            </div>
            <div class="post-actions">                
                <span  data-toggle="modal" data-target="#addCommentModal{{$post->id}}" data-post-id="{{$post->id}}"><i class="fa fa-comment"></i> {{ $post->comments_count }}</span>
                @foreach($post->comments as $comment)
                    <div class="comment-box">                    
                        <p class="comments">{{ $comment->comment }}</p> 
                        @if(auth()->user() && auth()->user()->id == $post->user_id)                   
                        <div class="comment-actions">
                            <a href="#" class="edit-comment" data-toggle="modal" data-target="#editCommentModal{{ $comment->id }}" data-comment-id="{{ $comment->id }}">Edit</a>
                            <span>|
                                </span>
                            <form class="delete-comment" data-comment-id="{{ $comment->id }}">
                            @csrf    
                                <a href="#">Delete</a>
                            </form>
                        </div>
                        @endif
                    </div>

                    <!-- Edit Comment Modal -->
                    <div class="modal fade" id="editCommentModal{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="editCommentModalLabel{{ $comment->id }}" aria-hidden="true" data-comment-id="{{ $comment->id }}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCommentModalLabel{{ $comment->id }}">Edit Comment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="editCommentForm" id="editCommentForm{{ $comment->id }}">
                                    <input type="hidden" id="comment-id{{ $comment->id }}" name="id" value="{{ $comment->id }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="editCommentContent">Comment</label>
                                            <textarea class="form-control" id="editCommentContent{{ $comment->id }}" name="comment" rows="4" required>{{ old('comment', $comment->comment) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- Comments Modal -->
            <div class="modal fade" id="addCommentModal{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="addCommentModalLabel" aria-hidden="true" data-post-id="{{$post->id}}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCommentModalLabel">Add Comment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="addCommentForm">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? '' }}">
                        <input type="hidden" id="post-id" name="id" value="{{ $post->id }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="commentContent">Comment</label>
                                    <textarea class="form-control" id="commentContent" name="comment" rows="4" placeholder="Write your comment here..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Add Comment</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Post Modal -->
        <div class="modal fade" id="editPostModal{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel" aria-hidden="true" data-post-id="{{ $post->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="editPostForm" enctype="multipart/form-data">
                            <input type="hidden" id="post-id" name="id" value="{{ $post->id }}">
                            @csrf
                            <div class="form-group">
                                <label for="editPostTitle">Title</label>
                                <input type="text" class="form-control" id="editPostTitle" name="title" value="{{ old('title', $post->title) }}" placeholder="Enter title" required>
                            </div>
                            <div class="form-group">
                                <label for="editPostDescription">Description</label>
                                <textarea class="form-control" id="editPostDescription" rows="4" name="description"  placeholder="Enter description" required>{{ old('description', $post->description) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="editPostPhoto">Recent Photo</label>
                                <img src="{{ asset('storage/app/' . $post->photo) }}" alt="Post Image" class="img-fluid">
                            </div>
                            <div class="form-group">
                                <label for="editPostPhoto">Photo</label>
                                <input type="file" class="form-control-file" name="photo" id="editPostPhoto" accept="image/*">
                            </div>                            
                            <button type="submit" class="btn btn-success btn-block">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>      
        @endforeach
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        $(document).ready(function () {
            $('#addPostTrigger').on('click', function () {
                $.ajax({
                    url: '{{ route("login") }}', 
                    type: 'GET',
                    success: function (response) {
                        if (response.isAuthenticated) {
                            $('#addPostModal').modal('show');
                        } else {
                            toastr.warning('You need to log in to add a post.');
                            window.location.href = '/login'; // Redirect to the login page
                        }
                    },
                    error: function () {
                        toastr.error('Something went wrong. Please try again.');
                    }
                });
            });
        });
        $('#addPostForm').on('submit', function (event) {
            event.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route("posts.store") }}', 
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                        setTimeout(() => {
                            window.location.reload(); 
                        }, 1500);
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            toastr.error(value[0], 'Validation Error');
                        });
                    } else {
                        toastr.error('Something went wrong. Please try again.', 'Error');
                    }
                }
            });
        });

    $('.editPostForm').on('submit', function (event) {
        event.preventDefault();        
    
    var formData = new FormData(this);
    var postId = $(this).closest('.modal').data('post-id');

        $.ajax({
            url: '/post/update/' + postId,  
            method: 'POST',  
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    setTimeout(() => {
                            window.location.reload(); 
                        }, 1500);  
                } else {
                    toastr.error('Something went wrong.', 'Error');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Unable to update post', 'Error');
            }
        });
    });

    // Delete post function
    $('.deletePost').on('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            var form = $(this); 
            var postId = form.data('post-id');            

            if (confirm('Are you sure you want to delete this post?')) {
                $.ajax({
                    url: '/post/delete/' + postId,  
                    method: 'POST',
                    data: form.serialize(), 
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.success, 'Success');
                            setTimeout(() => {
                            window.location.reload(); 
                        }, 1500);
                        } else {
                            toastr.error('Failed to delete the post', 'Error');
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 403) {
                            toastr.error(xhr.responseJSON.error, 'Unauthorized');
                        } else {
                            toastr.error('An error occurred while deleting the post.', 'Error');
                        }
                    }
                });
            }
        });


    //add comment
    $('.addCommentForm').on('submit', function (event) {
    event.preventDefault(); 
    
    var formData = new FormData(this); 
    
        $.ajax({
            url: '/comments/add', 
            method: 'POST',
            data: formData, 
            processData: false, 
            contentType: false, 
            success: function (response) {
                if (response.success) {
                    toastr.success(response.success, 'Success');
                    $('#addCommentModal').modal('hide'); 
                    location.reload(); 
                } else {
                    toastr.error('Failed to add comment', 'Error');
                }
            },
            error: function (xhr, status, error) {
                toastr.error('An error occurred while adding the comment.', 'Error');
            }
        });
    });

    //edit     
    $('.editCommentForm').on('submit', function (event) {
    event.preventDefault();
            
        var commentId = $(this).find('input[name="id"]').val();
        
        $.ajax({
            url: '/comments/edit/' + commentId,  
            method: 'POST',
            data: $(this).serialize(),  
            success: function (response) {
                if (response.success) {
                    toastr.success(response.success, 'Success');
                    $('#editCommentModal' + commentId).modal('hide'); 
                    location.reload(); 
                } else {
                    toastr.error('Failed to update comment', 'Error');
                }
            },
            error: function (xhr) {
                toastr.error('An error occurred while updating the comment.', 'Error');
            }
        });
    });
    //delete
    $('.delete-comment').on('click', function () {
    var commentId = $(this).data('comment-id'); 

        if (confirm('Are you sure you want to delete this comment?')) {
            $.ajax({
                url: '/comments/delete/' + commentId,  
                method: 'POST', 
                data: $(this).serialize(),               
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.success, 'Success');
                        location.reload(); 
                    } else {
                        toastr.error('Failed to delete comment', 'Error');
                    }
                },
                error: function (xhr) {
                    toastr.error('An error occurred while deleting the comment.', 'Error');
                }
            });
        }
    });


    
    });
</script>

</body>
</html>
