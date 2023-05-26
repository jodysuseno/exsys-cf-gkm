<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>Sistem Pakar CBR</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('valiadmin/assets/css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="index.html">UPT PUSKESMAS SEKARGADUNG</a>
  
      <!-- Sidebar toggle button-->
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
      <!-- <img src="{{ ('img/logo.png ') }}"> -->
        <li class="dropdown"><a class="app-nav__item text-decoration-none" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><span>{{ auth()->user()->nama }}</span>&nbsp;&nbsp;<i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            {{-- <li><a class="dropdown-item" href="#"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
            <li><a class="dropdown-item" href="#"><i class="fa fa-user fa-lg"></i> Profile</a></li> --}}
            <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>

    @include('layout.sidebar')
    @yield('container')
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('valiadmin/assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('valiadmin/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('valiadmin/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('valiadmin/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('valiadmin/assets/js/main.js') }}"></script>
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{ asset('valiadmin/assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('valiadmin/assets/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('valiadmin/assets/js/plugins/pace.min.js') }}"></script>
    <!-- Page specific javascripts-->
    
    <!-- Google analytics script-->
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
      	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      	ga('create', 'UA-72504830-1', 'auto');
      	ga('send', 'pageview');
      }
    </script>
  </body>
</html>