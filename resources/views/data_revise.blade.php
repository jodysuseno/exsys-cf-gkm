@extends('layout.main')

@section('container')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-user"></i> {{ $title }}</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="sampleTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Pasien</th>
                  <th>Tanggal Pemeriksaan</th>
                  <th>Nama Perawat</th>
                  <th>Gejala Yang dialami</th>
                  <th>Similarity</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($kasus as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->pasien->nama}}</td>
                  <td>{{ date_format(date_create($item->created_at), 'd/m/Y') }}</td>
                  <td>{{ $item->user->nama }}</td>
                  <td>
                    <ul>
                      @foreach ($gejala->where('kasus_id', $item->id) as $itemg)
                        <li>{{ $itemg->gejala->nama }}</li>
                      @endforeach
                      @forelse ($kompleksitas->where('kasus_id', $item->id) as $itemk)
                        <li>{{ $itemk->kompleksitas->nama }}</li>
                      @empty

                      @endforelse
                    </ul>
                  </td>
                  <td>{{ $item->similarity }}</td>
                  <td>
                    @if (auth()->user()->role == 'pakar')
                    <div class="dropdown open">
                      <button class="btn btn-sm @if($item->keterangan == 'tunggu') btn-warning @else btn-success @endif dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if($item->keterangan == 'tunggu') Tunggu @else Selesai @endif
                      </button>
                      <div class="dropdown-menu" aria-labelledby="triggerId">
                        <form action="{{ route('ubah_keterangan', $item->id) }}" method="post">
                          @csrf
                          @method('patch')
                          <input type="hidden" name="keterangan" value="tunggu">
                          <button type="submit" class="dropdown-item bg-warning">Tunggu</button>
                        </form>
                        <form action="{{ route('ubah_keterangan', $item->id) }}" method="post">
                          @csrf
                          @method('patch')
                          <input type="hidden" name="keterangan" value="selesai">
                          <button type="submit" class="dropdown-item bg-success text-light">Selesai</button>
                        </form>
                      </div>
                    </div>
                    @elseif (auth()->user()->role == 'perawat')
                      @if ($item->keterangan == 'tunggu')
                        <span class="badge bg-warning">Tunggu</span>
                      @else
                        <span class="badge bg-success text-light">Selesai</span>
                      @endif
                    @endif
                  </td>
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
  </div>
</main>
@endsection