@extends('layout.main')

@section('container')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <a href="#" style="text-decoration: none;">
        <div class="widget-small primary coloured-icon "><i class="icon fa fa-users fa-3x"></i>
          <div class="info">
            <h4>Users</h4>
            <p><b>{{ $cnt_user }}</b></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-lg-3">
      <a href="#" style="text-decoration: none;">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-list fa-3x"></i>
          <div class="info">
            <h4>Kasus</h4>
            <p><b>{{ $cnt_kasus }}</b></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-lg-3">
      <a href="#" style="text-decoration: none;">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-stethoscope fa-3x"></i>
          <div class="info">
            <h4>Gejala</h4>
            <p><b>{{ $cnt_gejala }}</b></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-lg-3">
      <a href="#" style="text-decoration: none;">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-heartbeat fa-3x"></i>
          <div class="info">
            <h4>Penyakit</h4>
            <p><b>{{ $cnt_penyakit }}</b></p>
          </div>
        </div>
      </a>
    </div>
  </div>
</main>
@endsection