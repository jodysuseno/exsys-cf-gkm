<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('medicio/img/logo-kotapas.png') }}" style="width:100%; padding-left:50px; padding-right:50px;" alt="User Image">
    <!-- <div>
      <p class="app-sidebar__user-name">John Doe</p>
      <p class="app-sidebar__user-designation">Frontend Developer</p>
    </div> -->
  </div>
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
    <li><a class="app-menu__item" href="{{ route('pasien.index') }}"><i class="app-menu__icon fa fa-wheelchair"></i><span class="app-menu__label">Data Pasien</span></a></li>
    @elseif(auth()->user()->role == 'pakar')
    <li><a class="app-menu__item" href="{{ route('pasien.index') }}"><i class="app-menu__icon fa fa-wheelchair"></i><span class="app-menu__label">Data Pasien</span></a></li>
    <li><a class="app-menu__item" href="{{ route('penyakit.index') }}"><i class="app-menu__icon fa fa-heartbeat"></i><span class="app-menu__label">Data Penyakit</span></a></li>
    {{-- <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-stethoscope"></i><span class="app-menu__label">Gejala dan Rekam Medis</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{ route('gejala.index') }}"><i class="icon fa fa-stethoscope"></i> Data Gejala</a></li>
        <li><a class="treeview-item" href="{{ route('bobot_gejala.index') }}"><i class="icon fa fa-stethoscope"></i> Data Bobot Gejala</a></li>
        <hr class="mt-1 mb-1 bg-secondary">
        <li><a class="treeview-item" href="{{ route('kompleksitas.index') }}"><i class="icon fa fa-stethoscope"></i> Data Rekam Medis</a></li>
      </ul>
    </li> --}}
    <li><a class="app-menu__item" href="{{ route('gejala.index') }}"><i class="app-menu__icon fa fa-stethoscope"></i><span class="app-menu__label">Data Gejala</span></a></li>
    <li><a class="app-menu__item" href="{{ route('bobot_gejala.index') }}"><i class="app-menu__icon fa fa-stethoscope"></i><span class="app-menu__label">Data Bobot Gejala</span></a></li>
    <li><a class="app-menu__item" href="{{ route('kompleksitas.index') }}"><i class="app-menu__icon fa fa-stethoscope"></i><span class="app-menu__label">Data Rekam Medis</span></a></li>

    <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-lightbulb-o"></i><span class="app-menu__label">Basis Pengetahuan</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{ route('kasus.index') }}"><i class="icon fa fa-lightbulb-o"></i> Kasus</a></li>
        <li><a class="treeview-item" href="{{ route('data_revise') }}"><i class="icon fa fa-lightbulb-o"></i> Kasus revise</a></li>
      </ul>
    </li>
    @elseif(auth()->user()->role == 'perawat')
    <li><a class="app-menu__item" href="{{ route('pasien.index') }}"><i class="app-menu__icon fa fa-wheelchair"></i><span class="app-menu__label">Data Pasien</span></a></li>
    {{-- <li><a class="app-menu__item" href="{{ route('data_revise') }}"><i class="app-menu__icon fa fa-lightbulb-o"></i><span class="app-menu__label">Kasus revise</span></a></li> --}}
    {{-- <li><a class="app-menu__item" href="{{ route('kasus.index') }}"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Kasus</span></a></li> --}}
    <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-lightbulb-o"></i><span class="app-menu__label">Basis Pengetahuan</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{ route('kasus.index') }}"><i class="icon fa fa-lightbulb-o"></i> Kasus</a></li>
        <li><a class="treeview-item" href="{{ route('data_revise') }}"><i class="icon fa fa-lightbulb-o"></i> Kasus revise</a></li>
      </ul>
    </li>
    <li><a class="app-menu__item" href="{{ route('sistem_pakar') }}"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Konsultasi Evaluasi</span></a></li>
    @endif
  </ul>
</aside>