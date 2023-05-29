@extends('layout.main')

@section('container')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1></i> Dashboard</h1>
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
            <h4>DATA PENYAKIT</h4>
            <p><b>{{ $cnt_penyakit }}</b></p>
          </div>
        </div>
      </a>
    </div>
  </div>
  <div class="row">
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
    <div class="col-sm-12 col-md-12 col-lg-6">
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
    <div class="col-sm-12 col-md-12 col-lg-6">
      <div class="tile">
        <h3 class="tile-title">Diagram Jumlah User</h3>
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
        <h3 class="tile-title">Diagram Jumlah Kasus</h3>
        <div class="embed-responsive embed-responsive-16by9">
          <canvas class="embed-responsive-item" id="barChart" width="437" height="246" style="width: 437px; height: 246px;"></canvas>
        </div>
      </div>
    </div>
  </div>  
  @endif
</main>
<!-- Page specific javascripts-->
<script src="{{ asset('valiadmin/assets/js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('valiadmin/assets/js/plugins/chart.js') }}"></script>
<script type="text/javascript">
  @if (auth()->user()->role == "admin")
  var user = {
    labels: ["Admin", "Pakar", "Perawat"],
    datasets: [
      {
        label: "User",
        fillColor: "#009688",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(220,220,220,1)",
        data: [{{ $cnt_user_admin }}, {{ $cnt_user_pakar }}, {{ $cnt_user_perawat }}]
      }
    ]
  };

  var ctxbbarChartUser = $("#barChart").get(0).getContext("2d");
  var barChart = new Chart(ctxbbarChartUser).Bar(user);
  @else

  var kasus = {
    labels: [
      @foreach ($penyakit as $item)
      "{{ $item->nama }}",
      @endforeach
    ],
    datasets: [
      {
        label: "User",
        fillColor: "#009688",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(220,220,220,1)",
        data: [
          @foreach ($penyakit as $item)
          {{ $kasus->where('penyakit_id', $item->id)->count() }},
          @endforeach
        ]
      }
    ]
  };

  var ctxbbarChartKasus = $("#barChart").get(0).getContext("2d");
  var barChart = new Chart(ctxbbarChartKasus).Bar(kasus);

  @endif
</script>
@endsection