@extends('layout.main')

@section('container')
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-user"></i> {{ $title }}</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="tile">
        <form action="{{ route('pasien.update', $get_pasien->id) }}" method="POST">
          @csrf
          @method('patch')
          <h3 class="tile-title">Edit {{ $title }}</h3>
          <div class="tile-body">
              <div class="form-group">
                <label class="control-label">Nomor kartu Identitas</label>
                <input class="form-control @error('nomor_kartu_identitas') is-invalid @enderror" type="number" name="nomor_kartu_identitas" required value="{{ old('nomor_kartu_identitas', $get_pasien->nomor_kartu_identitas) }}">
                @error('nomor_kartu_identitas') <div class="form-control-feedback text-danger ">{{ $message }}</div> @enderror
              </div>
              <div class="form-group">
                <label class="control-label">Nama</label>
                <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama" required value="{{ old('nama', $get_pasien->nama) }}">
                @error('nama') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
              </div>
              <div class="form-group">
                <label class="control-label">Umur</label>
                <input class="form-control @error('umur') is-invalid @enderror" type="number" name="umur" required value="{{ old('umur', $get_pasien->umur) }}">
                @error('umur') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
              </div>
              <div class="form-group">
                <label class="control-label">Telp</label>
                <input class="form-control @error('phone') is-invalid @enderror" type="number" name="phone" required value="{{ old('phone', $get_pasien->phone) }}">
                @error('phone') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
              </div>
          </div>
          <div class="tile-footer">
            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Save</button> 
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection