@include('partials.header') 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard       
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </section>
    <div class="container mt-4">
    <div class="row">
        <!-- Total Posts Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Posts</h5>
                    <p class="card-text">{{ $totalPosts }}</p>
                </div>
            </div>
        </div>

        <!-- Total Comments Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Comments</h5>
                    <p class="card-text">{{ $totalComments }}</p>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <!-- Blocked Users Card -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Blocked Users</h5>
                    <p class="card-text">{{ $blockedUsers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Most Recent Posts Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Most Recent Posts</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($recentPosts as $post)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="#">{{ $post->title }}</a>
                                <span class="badge badge-primary badge-pill">{{ $post->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
  </div>
  <!-- /.content-wrapper -->
  @include('partials.footer')
