@include('partials.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users       
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Users</li>
      </ol>
    </section>
<section class="content">      
<div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table Users</h3>
            </div>
            <!-- <div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add users</button></div> -->
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper"><div class="dataTables_length" id="example1_length"><label>Show <select name="example1_length" aria-controls="example1" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div id="example1_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="example1" data-has-listeners="true"></label></div><table id="example1" class="table table-bordered table-striped table-responsive dataTable" role="grid" aria-describedby="example1_info">
                <thead>
					<tr role="row">
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Sl No.</th>                     
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Name</th>                     
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Email ID</th>                     
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Status</th>                     
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">Create Date</th>
            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 186.047px;">actions</th>
          </tr>
				</thead>
				<tbody>
              @foreach ($users as $user)
                  <tr role="row" class="odd">
                      <td class="sorting_1">{{ $loop->iteration }}</td> 
                      <td>{{ $user->name }}</td>                                             
                      <td>{{ $user->email }}</td>                                             
                      <td>{{ $user->status }}</td>                                             
                      <td>{{ $user->created_at->format('Y/m/d') }}</td>   
                      <td>                     
                        <button class="status-btn" data-id="{{ $user->id }}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
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
    // Toggle User Status (Active to Blocked / Blocked to Active) via AJAX
    $('.status-btn').on('click', function () {
        var userId = $(this).data('id');  // Get the user ID
        var csrfToken = '{{ csrf_token() }}';  // CSRF token for security

        // Use SweetAlert for confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to change the user's status!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/bloggers/inactive/' + userId,  // URL to the route for changing the status
                    type: 'POST',
                    data: {
                        _token: csrfToken,  // CSRF token
                    },
                    success: function (response) {
                        Swal.fire(
                            'Updated!',
                            response.message,  // Success message
                            'success'
                        );

                        window.location.reload();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'There was an error updating the user status: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });
});


</script>