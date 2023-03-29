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
        <form action="{{ route('gejala.update', $get_gejala->id) }}" method="POST">
          @csrf
          @method('patch')
          <h3 class="tile-title">Edit {{ $title }}</h3>
          <div class="tile-body">
              <div class="form-group">
                <label class="control-label">Kode</label>
                <input class="form-control @error('kode') is-invalid @enderror" type="text" name="kode" readonly value="{{ $kode }}">
                @error('kode') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
              </div>
              <div class="form-group">
                <label class="control-label">Nama</label>
                <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama" required value="{{ old('nama', $get_gejala->nama) }}">
                @error('nama') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
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