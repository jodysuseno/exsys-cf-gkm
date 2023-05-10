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
        <div class="widget-small info coloured-icon"><i class="icon fa fa-book fa-3x"></i>
          <div class="info">
            <h4>DATA PAKAR</h4>
            <p><b>{{ $cnt_user_pakar }}</b></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-lg-3">
      <a href="#" style="text-decoration: none;">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-commenting fa-3x"></i>
          <div class="info">
            <h4>DATA PERAWAT</h4>
            <p><b>{{ $cnt_user_perawat }}</b></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-lg-3">
      <a href="#" style="text-decoration: none;">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-newspaper-o fa-3x"></i>
          <div class="info">
            <h4>DATA PASIEN</h4>
            <p><b>{{ $cnt_pasien }}</b></p>
          </div>
        </div>
      </a>
    </div>
  </div>
  @if (auth()->user()->role == 'admin')
  <div class="row">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">DATA USER</h3>
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="sampleTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Role</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($user as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->email }}</td>
                  <td>{{ $item->role }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6">Data Tidak Tersedia</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Diagaram Jumlah User</h3>
        <div class="embed-responsive embed-responsive-16by9">
          <canvas class="embed-responsive-item" id="barChart" width="437" height="246" style="width: 437px; height: 246px;"></canvas>
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="row">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">DATA KASUS</h3>
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="sampleTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Pasien</th>
                  <th>Tanggal Pemeriksaan</th>
                  <th>Nama Perawat</th>
                  <th>Diagnosa</th>
                  <th>Similarity</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($kasus as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->pasien->nama}}</td>
                  <td>{{ date_format(date_create($item->created_at), 'd/m/Y') }}</td>
                  <td>{{ $item->user->nama }}</td>
                  <td>{{ $item->penyakit->nama }}</td>
                  <td>{{ $item->similarity }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6">Data Tidak Tersedia</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Diagaram Jumlah Kasus</h3>
        <div class="embed-responsive embed-responsive-16by9">
          <canvas class="embed-responsive-item" id="barChart" width="437" height="246" style="width: 437px; height: 246px;"></canvas>
        </div>
      </div>
    </div>
  </div>  
  @endif
</main>
@endsection