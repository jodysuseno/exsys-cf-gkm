<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <!-- <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
    <div>
      <p class="app-sidebar__user-name">John Doe</p>
      <p class="app-sidebar__user-designation">Frontend Developer</p>
    </div>
  </div> -->
  <ul class="app-menu">
    <li><a class="app-menu__item" href="{{ route('dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
    @if (auth()->user()->role == 'admin')
    <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Data User</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{ route('admin_index') }}"><i class="icon fa fa-user"></i> Data Admin</a></li>
        <li><a class="treeview-item" href="{{ route('pakar_index') }}"><i class="icon fa fa-user-md"></i> Data Pakar</a></li>
        <li><a class="treeview-item" href="{{ route('perawat_index') }}"><i class="icon fa fa-user-md"></i> Data Perawat</a></li>
      </ul>
    </li>
    @endif
    <li><a class="app-menu__item" href="{{ route('pasien.index') }}"><i class="app-menu__icon fa fa-wheelchair"></i><span class="app-menu__label">Data Pasien</span></a></li>
    <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-stethoscope"></i><span class="app-menu__label">Data Gejala</span></a></li>
    <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-heartbeat"></i><span class="app-menu__label">Data Penyakit</span></a></li>
    <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-lightbulb-o"></i><span class="app-menu__label">Basis Pengetahuan</span></a></li>
    <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Konsultasi Evaluasi</span></a></li>
  </ul>
</aside>