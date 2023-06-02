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
          {{-- <a href="{{ route('basis_pengetahuan.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Detail {{ $title }}</a> --}}
          <div class="row invoice-info">
            <div class="col-4">
              <address>
                <h3>Kasus</h3>
                <br>Nama Pasien : {{ $kasus->pasien->nama }}
                <br>Diagnosa : {{ $kasus->penyakit->nama }}
              </address>
            </div>
          </div>

          <hr>
          <h4 class="mb-3">Basis Pengetahuan gejala</h4>

          @if (count($slc_gejala) > 0)
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahId"><i class="fa fa-plus"></i> Tambah</button>
          @endif

          <div class="modal fade" id="modalTambahId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="{{ route('basis_pengetahuan.store') }}" method="POST">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Tambah Gejala</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body">
                    <div class="tile-body">
                      <div class="form-group">
                        <fieldset @if (count($slc_gejala) <= 0) disabled @endif>
                          <label for="gejala_id">Gejala</label>
                          <input type="hidden" name="kasus_id" value="{{ $kasus->id }}">
                          <select class="form-control @error('gejala_id') is-invalid @enderror" id="gejala_id" name="gejala_id">
                            @foreach ($slc_gejala as $item)
                              <option value="{{ $item }}">{{ $gejala->where('id', $item)->first()->nama}}</option>
                            @endforeach
                          </select>
                          @error('gejala_id') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
                        </fieldset>
                      </div>
                      <div class="form-group">
                        <fieldset>
                          <label for="bobot_gejala_id">Bobot Gejala</label>
                          <select class="form-control @error('bobot_gejala_id') is-invalid @enderror" id="bobot_gejala_id" name="bobot_gejala_id" >
                            @foreach ($bobot_gejala as $item)
                              <option value="{{ $item->id }}">{{ $item->nama }} = {{ $item->bobot }}</option>
                            @endforeach
                          </select>
                          @error('bobot_gejala_id') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
                        </fieldset>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Gejala</th>
                  <th>Bobot</th>
                  <th>Nilai</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($bp_gejala as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->gejala->nama}}</td>
                  <td>{{ $item->bobot_gejala->nama }}</td>
                  <td>{{ $item->bobot_gejala->bobot }}</td>
                  <td>
                    {{-- tombol edit --}}
                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditId{{ $item->id }}"><i class="fa fa-edit"></i> Edit Bobot</button>
                    <!-- Modal Body -->
                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                    <div class="modal fade" id="modalEditId{{ $item->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                      <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">Edit Bobot</h5>
                            <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                          </div>
                          <div class="modal-body">
                            <form action="{{ route('basis_pengetahuan.update', $item->id) }}" method="POST">
                              @csrf
                              @method('put')
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalTitleId">Tambah Gejala</h5>
                                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                              </div>
                              <div class="modal-body">
                                <div class="tile-body">
                                  <div class="form-group">
                                    <fieldset>
                                      <label for="bobot_gejala_id">Bobot Gejala</label>
                                      <select class="form-control @error('bobot_gejala_id') is-invalid @enderror" id="bobot_gejala_id" name="bobot_gejala_id" >
                                        @foreach ($bobot_gejala as $itemb)
                                          <option value="{{ $itemb->id }}" @if ($itemb->id == $item->bobot_gejala->id) selected @endif>{{ $itemb->nama }} = {{ $itemb->bobot }}</option>
                                        @endforeach
                                      </select>
                                      @error('bobot_gejala_id') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
                                    </fieldset>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                              </div>
                            </form>
                          </div>
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
                            Apakah ada yakin untuk menghapus data "{{ $item->gejala->nama }}".
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form class="d-inline" action="{{ route('basis_pengetahuan.destroy', $item->id) }}" method="post">
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

          <hr>

          <form action="{{ route('save_revise_note', $kasus->id) }}" method="post">
            @csrf
            @method('put')
            <div class="mb-3">
              <label for="" class="form-label">Catatan</label>
              <textarea class="form-control" name="note" id="note" rows="3" placeholder="Tulis catatan">{{ $note }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Catatan</button>
          </form>
          {{-- <h4 class="mb-3">Basis Pengetahuan Kompleksitas</h4>

          @if (count($slc_kompleksitas) > 0)
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahKId"><i class="fa fa-plus"></i> Tambah</button>
          @endif

          <div class="modal fade" id="modalTambahKId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="{{ route('basis_pengetahuan_kompleksitas.store') }}" method="POST">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Tambah Gejala</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body">
                    <div class="tile-body">
                      <div class="form-group">
                        <fieldset @if (count($slc_kompleksitas) <= 0) disabled @endif>
                          <label for="kompleksitas_id">Bobot Gejala</label>
                            <input type="hidden" name="kasus_id" value="{{ $kasus->id }}">
                            <select class="form-control @error('kompleksitas_id') is-invalid @enderror" id="kompleksitas_id" name="kompleksitas_id" >
                              @foreach ($slc_kompleksitas as $itemk)
                                <option value="{{ $itemk }}">{{ $kompleksitas->where('id', $itemk)->first()->nama}}</option>
                              @endforeach
                            </select>
                            @error('kompleksitas_id') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
                        </fieldset>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Rekam Medis</th>
                  <th>Bobot</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($bp_kompleksitas as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->kompleksitas->nama}}</td>
                  <td>{{ $item->kompleksitas->bobot }}</td>
                  <td>
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
                            Apakah ada yakin untuk menghapus data "{{ $item->kompleksitas->nama }}".
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <form class="d-inline" action="{{ route('basis_pengetahuan_kompleksitas.destroy', $item->id) }}" method="post">
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
          </div> --}}
        </div>
      </div>
    </div>
  </div>
</main>
@endsection