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
                  <th>Catatan</th>
                  <th>Similarity</th>
                  {{-- @if (auth()->user()->role == 'pakar') --}}
                  <th>Option</th>
                  {{-- @endif --}}
                  <th>Ketarangan</th>
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
                  <td>
                    @if ($item->note == '')
                      <i style="color:rgb(189, 189, 189)">"Tidak Ada Catatan"</i> 
                    @else
                      {{ $item->note }}
                    @endif
                  </td>
                  <td>{{ $item->similarity }}</td>
                  {{-- @if (auth()->user()->role == 'pakar') --}}
                  <td>
                    <a href="{{ route('detail_revise', $item->id) }}" class="btn btn-sm btn-secondary" ><i class="fa fa-eye"></i> Detail</a>
                  </td>
                  {{-- @endif --}}
                  <td>
                    {{-- @if (auth()->user()->role == 'pakar') --}}
                      @if ($item->keterangan == 'tunggu')
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
                      @else 
                        <span class="badge bg-success text-light">Selesai</span>
                      @endif
                    {{-- @elseif (auth()->user()->role == 'perawat')
                      @if ($item->keterangan == 'tunggu')
                        <span class="badge bg-warning">Tunggu</span>
                      @else
                        <span class="badge bg-success text-light">Selesai</span>
                      @endif
                    @endif --}}
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9">Data Tidak Tersedia</td>
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