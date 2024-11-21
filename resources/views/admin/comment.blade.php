@include('partials.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Comments       
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Comments</li>
      </ol>
    </section>
<section class="content">      
<div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table Comments</h3>
            </div>
            <!-- <div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Comment</button></div> -->
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper"><div class="dataTables_length" id="example1_length"><label>Show <select name="example1_length" aria-controls="example1" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div id="example1_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="example1" data-has-listeners="true"></label></div><table id="example1" class="table table-bordered table-striped table-responsive dataTable" role="grid" aria-describedby="example1_info">
                <thead>
					<tr role="row">
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Name</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Title</th>            
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Comments</th>            
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Create Date</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">actions</th>
          </tr>
				</thead>
				<tbody>
              @foreach ($comments as $comment)
                  <tr role="row" class="odd">
                      <td class="sorting_1">{{ $comment->user->name }}</td> 
                      <td>{{ $comment->post->title }}</td>                       
                      <td>{{ $comment->comment }}</td>                       
                      <td>{{ $comment->created_at->format('Y/m/d') }}</td>   
                      <td>                     
                        <button class="delete-btn" data-id="{{ $comment->id }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                  </tr>                  
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
    var commentId = $(this).data('id');  
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
                url: '/admin/comments/delete/' + commentId,  
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
                    // Optionally remove the comment row from the table
                    $('button[data-id="' + commentId + '"]').closest('tr').remove();
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'Error deleting comment: ' + error,
                        'error'
                    );
                }
            });
        }
    });
});
   

});

</script>