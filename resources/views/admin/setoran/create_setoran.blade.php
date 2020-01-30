@extends('layouts.master')

@section('title', 'Pengolahan Data Setoran')

@section('content')
<div class="row">
  <div class="col-xl-8 col-md-10 mb-12">
    <div class="card">
      <div class="card-header">
        Tambah Data Setoran
      </div>
      <div class="card-body">
        @include('includes.info-box')
        <form method="POST" action="{{ route('admin.setoran.create') }}">
          <div class="form-group">
            <label for="tgl_setoran">Tanggal Setoran</label>
            <input name="tgl_setoran" value="{{ Request::old('tgl_setoran') }}" type="date" class="form-control" id="tgl_setoran" placeholder="Tanggal Setoran">
          </div>
          <div class="form-group">
            <label for="waktu_setoran">Waktu Setoran</label>
            <select class="form-control" name="waktu_setoran">
              <option value="">Pilih Waktu Setoran</option>
              <option value="01">Pagi</option>
              <option value="02">Sore</option>
            </select>
          </div>
          <div class="form-group">
            <label for="nama_petugas">Petugas</label>
            <input name="nama_petugas" value="{{ Request::old('nama_petugas') }}" type="text" class="form-control" id="nama_petugas" placeholder="Nama Petugas">
          </div>
          <div class="form-group">
            <label for="nama_pembeli">Pembeli</label>
            <input name="nama_pembeli" value="{{ Request::old('nama_pembeli') }}" type="text" class="form-control" id="nama_pembeli" placeholder="Nama Pembeli">
          </div>
          
          <div class="form-group">
            <label for="nama_pembeli">Hasil Perahan</label>
              @if ($hasil_perahan->count() < 1)
                <div class="form-group">
                  Data perahan belum ada, silahkan tambahkan data perahan <a href="{{ route('admin.perahan.create') }}">disini</a>
                </div>
              @else
              <ul>
                @foreach($hasil_perahan as $perahan)
                  <li>
                    <input type="checkbox" name="hasil_perahan[]" value="{{ $perahan->id_pemerahan }}"> Sapi {{$perahan->kode_sapi}} ({{$perahan->jumlah_susu}} lt) <br />
                  </li>
                @endforeach
              </ul>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Tambah Data Sapi</button>
          <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection