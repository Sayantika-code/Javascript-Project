@include('partials.header-link')

<body class="hold-transition skin-black-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="images/Blog.png"  alt=""></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>My Blog</b>Admin</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		  <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="images/user2-160x160.jpg" class="user-image rounded-circle" alt="User Image">
            </a>
            <ul class="dropdown-menu scale-up">
              <!-- User image -->
              <li class="user-header">
                <img src="images/user2-160x160.jpg" class="float-left rounded-circle" alt="User Image">

                <p>
                  Admin
                  <small class="mb-5">admin@gmail.com</small>                  
                </p>
              </li>            
              
              <!-- Menu Footer-->
              <li class="user-footer">               
                <div class="pull-right">
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                  <button  class="btn btn-block btn-danger"><i class="ion ion-power"></i> Log Out</button>
                </form>
                </div>
              </li>
            </ul>
          </li>          
        </ul>
      </div>
    </nav>
  </header>
  
  <!-- Left side column. contains the logo and sidebar -->
  
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
   
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image float-left">
          <img src="images/user2-160x160.jpg" class="rounded-circle" alt="User Image">
        </div>
        <div class="info float-left">
          <p>Blog Template</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>		  
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">         
        <li class="active">
          <a href="/admin/dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>                 
        <li class="active">
            <a href="/admin/bloggers">
                <i class="fa fa-user"></i> <span>Users</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
        </li>        
        <li class="active">
          <a href="/admin/posts">
          <i class="fa fa-newspaper-o"></i><span>Posts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>   
        <li class="active">
          <a href="/admin/comments">
          <i class="fa fa-comment" aria-hidden="true"></i><span>Comments</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>                   
      </ul>
    </section>
   
    <!-- /.sidebar -->    
  </aside>
      