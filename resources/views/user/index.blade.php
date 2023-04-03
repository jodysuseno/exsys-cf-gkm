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
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahId"><i class="fa fa-plus"></i> Tambah {{ $title }}</button>
          <!-- Modal Body -->
          
          <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
          <div class="modal fade" id="modalTambahId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
              <div class="modal-content">
                <form action="{{ route('user.store') }}" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Tambah {{ $title }}</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body">
                      @csrf
                      <div class="form-group">
                        <input type="hidden" name="role" value="{{ $role }}">
                        <label class="control-label">Nama</label>
                        <input class="form-control" type="text" name="nama" value="{{ old('nama') }}" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label">password</label>
                        <input class="form-control" type="password" name="password" value="{{ old('password') }}" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label">repassword</label>
                        <input class="form-control" type="password" name="repassword" value="{{ old('repassword') }}" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label">NIP</label>
                        <input class="form-control" type="number" name="nip" value="{{ old('nip') }}" required>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Telp</label>
                        <input class="form-control" type="number" name="phone" value="{{ old('phone') }}" required>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          @if ($errors->any()) 
          <div class="alert alert-dismissible alert-danger">
            <button class="close" type="button" data-dismiss="alert">×</button>
            <h6>{{ $title }} gagal di simpan!</h6>
            @foreach ($errors->all() as $error)
              <strong>{{ $error }}</strong> <br>
            @endforeach
          </div>
          @endif

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
                  <th>Email</th>
                  <th>NIP</th>
                  <th>Phone</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($user as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->email }}</td>
                  <td>{{ $item->nip }}</td>
                  <td>{{ $item->phone }}</td>
                  <td>
                    {{-- tombol edit --}}
                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditId{{ $item->id }}"><i class="fa fa-edit"></i> Edit</button>
                    <!-- Modal Body -->
                    
                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                    <div class="modal fade" id="modalEditId{{ $item->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                          <form method="POST" action="{{ route('user.update', $item->id) }}">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalTitleId">Edit {{ $title }}</h5>
                              <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                              @csrf
                              @method('put')
                              <div class="form-group">
                                <input type="hidden" name="role" value="{{ $role }}">
                                <label class="control-label">Nama</label>
                                <input class="form-control" type="text" name="nama" required value="{{ $item->nama }}">
                              </div>
                              <div class="form-group">
                                <label class="control-label">Email</label>
                                <input class="form-control" type="email" name="email" required value="{{ $item->email }}">
                              </div>
                              <div class="form-group">
                                <label class="control-label">password</label>
                                <input class="form-control" type="password" name="password" value="">
                              </div>
                              <div class="form-group">
                                <label class="control-label">repassword</label>
                                <input class="form-control" type="password" name="repassword" value="">
                              </div>
                              <div class="form-group">
                                <label class="control-label">NIP</label>
                                <input class="form-control" type="number" name="nip" required value="{{ $item->nip }}">
                              </div>
                              <div class="form-group">
                                <label class="control-label">Telp</label>
                                <input class="form-control" type="number" name="phone" required value="{{ $item->phone }}">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
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
                            Apakah ada yakin untuk menghapus data "{{ $item->nama }}". Jika ya maka data "{{ $item->nama }}" yang ada di basis pengetahuan akan juga dihapus. Jika tidak ingin menghapus mungkin bisa mengedit atau ubah data "{{ $item->nama }}".
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form class="d-inline" action="{{ route('user.destroy', $item->id) }}" method="post">
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