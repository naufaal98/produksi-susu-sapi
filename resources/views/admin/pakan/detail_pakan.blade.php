@extends('layouts.master')

@section('title', 'Pembagian Pakan')

@section('content')
<div class="row">
  <div class="col-xl-8 col-md-10 mb-12">
    <div class="card">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pembagian Pakan Pada {{ $tgl_penyetokan }}</h6>
      </div>
      <div class="card-body">
        @if ($pembagian_pakan->count() < 1)
          <div class="alert alert-danger" role="alert">
            Belum ada pembagian pakan untuk hari ini, silahkan tambahkan stok pakan agar bisa melakukan pembagian <a href="{{ route('admin.pakan.create') }}">disini</a>
          </div>
        @else
          <p>
            <a href="{{ route('admin.pakan_detail.cetak_pdf', ['id_penyetokan' => $id_penyetokan]) }}" class="btn btn-success">Cetak Laporan Pembagian Pakan</a>
          </p>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode Sapi</th>
                  <th>Jatah Mako</th>
                  <th>Jatah Rumput</th>
                  <th>Waktu Pemberian</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pembagian_pakan as $pembagian)
                  <tr>
                    <td>{{ $pembagian->kode_sapi }}</td>
                    <td>{{ $pembagian->jumlah_mako }} Kg</td>
                    <td>{{ $pembagian->jumlah_rumput }} Kg</td>
                    <td>{{ $pembagian->tgl_pemberian }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection