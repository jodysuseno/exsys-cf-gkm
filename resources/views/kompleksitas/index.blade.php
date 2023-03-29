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
          <!-- Modal trigger button -->
          <a href="{{ route('kompleksitas.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Tambah {{ $title }}</a>
          
          @if (session('status'))   
          <div class="alert alert-dismissible alert-success">
            <button class="close" type="button" data-dismiss="alert">×</button>
            <strong>{{ session('status') }}</strong>
          </div>
          @endif
          
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="sampleTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Bobot</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($kompleksitas as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->bobot }}</td>
                  <td>
                    {{-- tombol edit --}}
                    <a href="{{ route('kompleksitas.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</a>
                    {{-- tombol hapus --}}
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusId{{ $item->id }}"><i class="fa fa-trash"></i> Hapus</button>
                    <!-- Modal Body -->
                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                    <div class="modal fade" id="modalHapusId{{ $item->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                      <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">Hapus {{ $title }}</h5>
                            <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                          </div>
                          <div class="modal-body">
                            Apakah ada yakin untuk menghapus data "{{ $item->nama }}".
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form class="d-inline" action="{{ route('kompleksitas.destroy', $item->id) }}" method="post">
                              @csrf
                              @method('delete')
                              <button class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
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