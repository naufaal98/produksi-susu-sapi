@extends('layouts.master')

@section('title', 'Pengolahan Data Hasil Perahan')

@section('content')
<div class="row">
  <div class="col-xl-8 col-md-10 mb-12">
    <div class="card">
      <div class="card-header">
        Tambah Data Hasil Perahan
      </div>
      <div class="card-body">
        @include('includes.info-box')
        <form method="POST" action="{{ route('admin.perahan.create') }}">
          <div class="form-group">
            <label for="jumlah_susu">Jumlah Susu (Liter)</label>
            <input name="jumlah_susu" type="text" class="form-control" id="jumlah_susu" placeholder="Jumlah Liter">
          </div>
          <div class="form-group">
            <label for="stok_rumput">Kode Sapi</label>
            <select class="form-control" name="kode_sapi">
              <option value="">Pilih Sapi</option>
              @foreach($all_sapi as $sapi)
                <option value="{{ $sapi->kode_sapi }}">{{ $sapi->kode_sapi }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Tambah Data Hasil Perahan</button>
          <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection