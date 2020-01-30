@extends('layouts.master')

@section('title', 'Pengolahan Data Pakan')

@section('content')
<div class="row">
  <div class="col-xl-8 col-md-10 mb-12">
    <div class="card">
      <div class="card-header">
        Tambah Data Pakan Hari Ini
      </div>
      <div class="card-body">
        @include('includes.info-box')
        <form method="POST" action="{{ route('admin.pakan.create') }}">
          <div class="form-group">
            <label for="stok_mako">Stok Mako (Kg)</label>
            <input name="stok_mako" type="text" class="form-control" id="stok_mako" placeholder="Stok Mako">
          </div>
          <div class="form-group">
            <label for="stok_rumput">Stok Rumput (Kg)</label>
            <input name="stok_rumput" type="text" class="form-control" id="stok_rumput" placeholder="Stok Rumput">
          </div>
          <button type="submit" class="btn btn-primary">Tambah Data Stok Pakan Hari Ini</button>
          <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection