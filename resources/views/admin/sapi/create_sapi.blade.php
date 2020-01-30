@extends('layouts.master')

@section('title', 'Pengolahan Data Sapi')

@section('content')
<div class="row">
  <div class="col-xl-8 col-md-10 mb-12">
    <div class="card">
      <div class="card-header">
        Tambah Data Sapi
      </div>
      <div class="card-body">
        @include('includes.info-box')
        <form method="POST" action="{{ route('admin.sapi.create') }}">
          <div class="form-group">
            <label for="tgl_lahir_sapi">Tanggal Lahir Sapi</label>
            <input value="{{ Request::old('tgl_lahir_sapi') }}" name="tgl_lahir_sapi" type="date" class="form-control" id="tgl_lahir_sapi" placeholder="Tanggal Lahir Sapi">
          </div>
          <div class="form-group">
            <label for="no_kandang">No Kandang</label>
            <input value="{{ Request::old('no_kandang') }}" name="no_kandang" type="text" class="form-control" id="no_kandang" placeholder="Masukan No Kandang">
          </div>
          <button type="submit" class="btn btn-primary">Tambah Data Sapi</button>
          <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection