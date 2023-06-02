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
        <form action="{{ route('penyakit.update', $get_penyakit->id) }}" method="POST">
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
                <input class="form-control @error('nama') is-invalid @enderror" type="text" name="nama" required value="{{ old('nama', $get_penyakit->nama) }}">
                @error('nama') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
              </div>
              <div class="form-group">
                <label for="definisi">Definisi</label>
                <textarea class="form-control @error('definisi') is-invalid @enderror" name="definisi" id="definisi" rows="3">{{ old('definisi', $get_penyakit->definisi) }}</textarea>
                @error('definisi') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
              </div>
              <div class="form-group">
                <label for="solusi">Solusi</label>
                <textarea class="form-control @error('solusi') is-invalid @enderror" name="solusi" id="solusi" rows="3">{{ old('solusi', $get_penyakit->solusi) }}</textarea>
                @error('solusi') <div class="form-control-feedback text-danger">{{ $message }}</div> @enderror
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