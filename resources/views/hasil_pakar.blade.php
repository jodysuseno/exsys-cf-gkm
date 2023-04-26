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
        <section class="invoice">
          <div class="row mb-4">
            <div class="col-6">
              <h2 class="page-header"><i class="fa fa-file-text-o"></i> Hasil Pakar</h2>
            </div>
            <div class="col-6">
              {{-- <h5 class="text-right">Date: 01/01/2016</h5> --}}
            </div>
          </div>
          <div class="row invoice-info">
            <div class="col-6">
              <address>
                <strong>Data Pasien : </strong><br>
                <table>
                  <tr>
                    <td>Nomor kartu identitas</td>
                    <td>:</td>
                    <td>{{ $pasien_kartu_identitas }}</td>
                  </tr>
                  <tr>
                    <td>Nama </td>
                    <td>:</td>
                    <td>{{ $pasien_nama }}</td>
                  </tr>
                  <tr>
                    <td>Umur </td>
                    <td>:</td>
                    <td>{{ $pasien_umur }}</td>
                  </tr>
                  <tr>
                    <td>Phone </td>
                    <td>:</td>
                    <td>{{ $pasien_phone }}</td>
                  </tr>
                </table>
              </address>
            </div>
            <div class="col-6">
              <address>
                <strong>Hasil Diagnosa</strong><br>
                <table>
                  <tr>
                    <td>Penyakit </td>
                    <td>:</td>
                    <td>{{ $diagnosa_penyakit }}</td>
                  </tr>
                  <tr>
                    <td>Nilai Similarity </td>
                    <td>:</td>
                    <td><strong> {{ number_format($diagnosa_nilai_similarity, 2) }} </strong></td>
                  </tr>
                  <tr>
                    <td>Definisi Penyakit </td>
                    <td>:</td>
                    <td>{{ $data_penyakit_devinisi }}</td>
                  </tr>
                  <tr>
                    <td>Solusi </td>
                    <td>:</td>
                    <td>{{ $data_penyakit_solusi }}</td>
                  </tr>
                </table>
              </address>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-6">
              <address>
                <strong>Gejala yang dipilih</strong><br>
                <ul>
                  @foreach ($gejala as $item)
                  <li>{{ $data_gejala->where('id', $item)->first()->nama }}</li>
                  @endforeach
                </ul>
              </address>
            </div>
            <div class="col-6">
              <address>
                <strong>Kompleksitas yang dipilih</strong><br>
                <ul>
                  @if (is_null($kompleksitas))
                  <strong><li>Tidak ada yang dipilih</li></strong>
                  @else
                  @foreach ($kompleksitas as $item)
                  <li>{{ $data_kompleksitas->where('id', $item)->first()->nama }}</li>
                  @endforeach
                  @endif
                </ul>
              </address>
            </div>
            <div class="col-12 text-right">
              <a class="btn btn-primary" href="{{ route('sistem_pakar') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
              <form action="{{ route('cek_sebagai_revise', $id_kasus) }}" class="d-inline" method="post">
                @csrf
                @method('patch')
                <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Tandai Sebagai revise</button>
              </form>
            </div>
            <hr>
            <div class="col-12 table-responsive">
              <strong> 5 Data Kasus dengan similaritas yang tinggi</strong><br>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Pasien</th>
                    <th>Penyakit</th>
                    <th>Gejala dan Kompleksitas pada kasus</th>
                    <th>Gejala dan Kompleksitas yang Sama</th>
                    <th>Similaritas </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($kasus as $key => $item)
                  @if ($key < 5)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['data_pasien_name'] }}</td>
                    <td>{{ $item['data_penyakit_name'] }}</td>
                    <td>
                      <ul>
                        @foreach ($item['data_kasus_gejala'] as $itemg)
                        <li>{{ $data_gejala->where('id', $itemg)->first()->nama }}</li>
                        @endforeach
                        @if (!is_null($item['data_kasus_kompleksitas']))
                        @foreach ($item['data_kasus_kompleksitas'] as $itemk)
                        <li>{{ $data_gejala->where('id', $itemk)->first()->nama }}</li>
                        @endforeach
                        @endif
                      </ul>
                    </td>
                    <td>
                      <ul>
                        @foreach ($item['data_same_gejala'] as $itemg)
                        <li>{{ $data_gejala->where('id', $itemg)->first()->nama }}</li>
                        @endforeach
                        @if (!is_null($item['data_same_kompleksitas']))
                        @foreach ($item['data_same_kompleksitas'] as $itemk)
                        <li>{{ $data_gejala->where('id', $itemk)->first()->nama }}</li>
                        @endforeach
                        @endif
                      </ul>
                    </td>
                    <td>{{ number_format($item['data_result'], 2) }} </td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="row d-print-none mt-2">
            <div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print();"><i class="fa fa-print"></i> Print</a></div>
          </div>
        </section>
      </div>
    </div>
  </div>
</main>
@endsection