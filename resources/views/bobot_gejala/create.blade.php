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
        <form action="{{ route('bobot_gejala.store') }}" method="POST">
          @csrf
          <h3 class="tile-title">Tambah {{ $title }}</h3>
          <div class="tile-body">
            <div class="form-group">
              <label class="control-label">Nama</label>
              <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama" required value="{{ old('nama') }}">
              @error('nama') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
              <label class="control-label">Bobot</label>
              <input class="form-control @error('bobot') is-invalid @enderror" type="number" name="bobot" required value="{{ old('bobot') }}">
              @error('bobot') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
            </div>
          </div>
          <div class="tile-footer">
            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-save"></i>Simpan</button> 
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection