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
        <form action="{{ route('hasil_pakar') }}" method="POST">
          @csrf
          <h3 class="tile-title">Sistem Pakar</h3>
          <div class="tile-body col-sm-12 col-md-6 col-gl-6">
            <div class="form-group">
              <label class="control-label">Nama</label>
              <input type="hidden" name="pasien_id" id="pasien_id">
              <input class="form-control" type="text" name="nama" id="nama" required readonly>
            </div>
            <div class="form-group">
              <label class="control-label">Nonmor Kartu Identitas</label>
              <input class="form-control" type="number" name="nomor_kartu_identitas" id="nomor_kartu_identitas" required readonly>
            </div>
            <div class="form-group">
              <label class="control-label">Umur</label>
              <input class="form-control" type="number" name="umur" id="umur" required readonly>
            </div>
            <div class="form-group">
              <label class="control-label">No. Telp</label>
              <input class="form-control" type="number" name="phone" id="phone" required readonly>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalId"><i class="fa fa-wheelchair"></i> Pilih Pasien</button>
              
              <!-- Modal Body -->
              <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
              <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalTitleId">Pasien</h5>
                      <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Nomor Kartu Identitas</th>
                              <th>Nama</th>
                              <th>Umur</th>
                              <th>Pilih</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($pasien as $item)
                            <tr>
                              <td><input type="hidden" id="pasienId{{ $item->id }}" value="{{ $item->id }}">{{ $loop->iteration }}</td>
                              <td><input type="hidden" id="nomor_kartu_identitas{{ $item->id }}" value="{{ $item->nomor_kartu_identitas }}">{{ $item->nomor_kartu_identitas }}</td>
                              <td><input type="hidden" id="nama{{ $item->id }}" value="{{ $item->nama }}">{{ $item->nama }}</td>
                              <td><input type="hidden" id="umur{{ $item->id }}" value="{{ $item->umur }}">{{ $item->umur }}</td>
                              <td>
                                <input type="hidden" id="phone{{ $item->id }}" value="{{ $item->phone }}"><button type="button" class="btn btn-primary btn-sm" onclick="pilih{{ $item->id }}()" data-bs-dismiss="modal" aria-label="Close">Pilih</button>
                                <script>
                                  function pilih{{ $item->id }}() {
                                    let varpasienId{{ $item->id }} = document.getElementById("pasienId{{ $item->id }}").value;
                                    let varnomor_kartu_identitas{{ $item->id }} = document.getElementById("nomor_kartu_identitas{{ $item->id }}").value;
                                    let varnama{{ $item->id }} = document.getElementById("nama{{ $item->id }}").value;
                                    let varumur{{ $item->id }} = document.getElementById("umur{{ $item->id }}").value;
                                    let varphone{{ $item->id }} = document.getElementById("phone{{ $item->id }}").value;

                                    document.getElementById("pasien_id").value = varpasienId{{ $item->id }};
                                    document.getElementById("nomor_kartu_identitas").value = varnomor_kartu_identitas{{ $item->id }};
                                    document.getElementById("nama").value = varnama{{ $item->id }};
                                    document.getElementById("umur").value = varumur{{ $item->id }};
                                    document.getElementById("phone").value = varphone{{ $item->id }};
                                  }
                                </script>
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
            </div>
          </div>
          <hr>
          <h5>Gejala</h5>
          <div class="tile-body">
            <div class="row g-2 m-3">
              @foreach ($gejala as $item)
              <div class="form-check mb-3 col-sm-12 col-md-6 col-lg-4">
                <label class="form-check-label">
                  <input class="form-check-input" name="gejala_id[]" value="{{ $item->id }}" type="checkbox">{{ $item->nama }}
                </label>
              </div>
              @endforeach
            </div>
          </div>
          <h5>Kompleksitas</h5>
          <div class="tile-body">
            <div class="row g-2 m-3">
              @foreach ($kompleksitas as $item)
                <div class="form-check mb-3 col-sm-12 col-md-6 col-lg-4">
                  <label class="form-check-label">
                    <input class="form-check-input" name="kompleksitas_id[]" value="{{ $item->id }}" type="checkbox">{{ $item->nama }}
                  </label>
                </div>
              @endforeach
            </div>
          </div>
          <div class="tile-footer d-md-flex justify-content-md-end">
            <button class="btn btn-primary d-inline" type="submit"><i class="fa fa-fw fa-lg fa-arrow-right"></i>Kirim</button> 
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection