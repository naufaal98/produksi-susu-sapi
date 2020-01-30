@extends('layouts.master')

@section('title', 'Pengolahan Data Pakan')

@section('content')
<div class="row">
  <div class="col-xl-8 col-md-10 mb-12">
    <div class="card">
      <div class="card-header">
        Edit Data Pakan Hari Ini
      </div>
      <div class="card-body">
        @include('includes.info-box')
        <form method="POST" action="{{ route('admin.pakan.update') }}">
          <div class="form-group">
            <label for="stok_mako">Stok Mako (Kg)</label>
            <input 
              name="stok_mako" 
              type="text" 
              class="form-control" 
              id="stok_mako" 
              placeholder="Stok Mako"
              value="{{ Request::old('stok_mako') ? Request::old('stok_mako') : isset($penyetokan) ? $penyetokan->stok_mako : '' }}"
            >
          </div>
          <div class="form-group">
            <label for="stok_rumput">Stok Rumput (Kg)</label>
            <input 
              name="stok_rumput" 
              type="text" 
              class="form-control" 
              id="stok_rumput" 
              placeholder="Stok Rumput"
              value="{{ Request::old('stok_rumput') ? Request::old('stok_rumput') : isset($penyetokan) ? $penyetokan->stok_rumput : '' }}"
            >
          </div>
          <input type="hidden" name="id_penyetokan" value="{{ $penyetokan->id_penyetokan }}">
          <button type="submit" class="btn btn-primary">Update Data Stok Pakan Hari Ini</button>
          <input type="hidden" name="_token" value="{{ Session::token() }}">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection