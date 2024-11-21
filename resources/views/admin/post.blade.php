@include('partials.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Posts       
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Posts</li>
      </ol>
    </section>
<section class="content">      
<div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table Posts</h3>
            </div>
            <!-- <div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Post</button></div> -->
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper"><div class="dataTables_length" id="example1_length"><label>Show <select name="example1_length" aria-controls="example1" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div id="example1_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="example1" data-has-listeners="true"></label></div><table id="example1" class="table table-bordered table-striped table-responsive dataTable" role="grid" aria-describedby="example1_info">
                <thead>
					<tr role="row">
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Name</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Title</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Description</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Photo</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Create Date</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">actions</th>
          </tr>
				</thead>
				<tbody>
              @foreach ($posts as $post)
                  <tr role="row" class="odd">
                      <td class="sorting_1">{{ $post->user->name }}</td> 
                      <td>{{ $post->title }}</td> 
                      <td>{{ $post->description }}</td> 
                      <td><img src="{{ asset('storage/app/' . $post->photo) }}"></td> 
                      <td>{{ $post->created_at->format('Y/m/d') }}</td>   
                      <td>
                      <button class="edit-btn" data-id="{{ $post->id }}" data-toggle="modal" data-target="#editModal{{ $post->id }}">
                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </button>
                        <button class="delete-btn" data-id="{{ $post->id }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                  </tr>
                  <!-- Modal for Edit Post -->
                  <div class="modal" id="editModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-post-id="{{ $post->id }}">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel">Edit Post</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <form id="editPostForm">
                                      <input type="hidden" id="post-id" name="id" value="{{ $post->id }}">
                                      @csrf
                                      <div class="form-group">
                                          <label for="edit-title">Title</label>
                                          <input type="text" class="form-control" id="edit-title" name="title" value="{{ old('title', $post->title) }}">
                                      </div>
                                      <div class="form-group">
                                      <div class="form-group">
                                        <label for="postDescription">Description</label>
                                        <textarea class="form-control" id="postDescription" rows="4" name="description" placeholder="Enter description" required>{{ old('description', $post->description) }}</textarea>
                                    </div>                                     
                                      <div class="form-group">
                                          <label for="edit-photo">Recent Photo</label>
                                          <img src="{{ asset('storage/app/' . $post->photo) }}">
                                      </div>
                                      <div class="form-group">
                                          <label for="edit-photo">Photo</label>
                                          <input type="text" class="form-control" id="edit-photo" name="photo">
                                      </div>
                                      <button type="submit" class="btn btn-primary">Save changes</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
                    @endforeach
                </tbody>                              			
              </table>
            </div>
            <!-- /.box-body -->
          </div>
<section>       
</div>   
@include('partials.footer')
<script>
  $(document).ready(function () {
    // Delete Post via AJAX
    $('.delete-btn').on('click', function () {
    var postId = $(this).data('id');  
    var csrfToken = '{{ csrf_token() }}';
    // Use SweetAlert for confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/posts/delete/' + postId,  
                type: 'POST',
                data: {
                  _token: csrfToken,   
                },
                success: function (response) {
                    Swal.fire(
                        'Deleted!',
                        response.message, 
                        'success'
                    );
                    // Optionally remove the post row from the table
                    $('button[data-id="' + postId + '"]').closest('tr').remove();
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'Error deleting post: ' + error,
                        'error'
                    );
                }
            });
        }
    });
});
   
$('#editPostForm').on('submit', function (e) {
    e.preventDefault();  

    // Get the post ID from the closest modal
    var postId = $(this).closest('.modal').data('post-id');
     
    var formData = new FormData(this);  

    // Send the AJAX POST request to update the post
    $.ajax({
        url: '/admin/posts/update/' + postId,  
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            Swal.fire(
                'Updated!',
                'The post has been updated successfully.',
                'success'
            );
            // Optionally update the post in the table or close the modal
            $('#editModal' + postId).modal('hide');
            
        },
            error: function (xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'There was an error updating the post: ' + error,
                    'error'
                );
            }
        });
    });


});

</script>