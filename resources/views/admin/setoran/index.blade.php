@extends('layouts.master')

@section('title', 'Pengolahan Data Setoran')

@section('content')
<div class="row">
  <div class="col-xl-10 col-md-10 mb-12">
    <div class="card">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Setoran</h6>
      </div>
      <div class="card-body">
        @include('includes.info-box')
        <p>
          <a href="{{ route('admin.setoran.create') }}" class="btn btn-primary">Tambah Data Setoran</a>
          <a href="{{ route('admin.setoran.cetak_pdf') }}" class="btn btn-success">Cetak Laporan Setoran</a>
        </p>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Kode Setoran</th>
                <th>Tgl Setoran</th>
                <th>Waktu Setoran</th>
                <th>Petugas</th>
                <th>Pembeli</th>
                <th>Total Susu</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($penyetoran as $setoran)
                <tr>
                  <td>{{ $setoran->kode_setoran }}</td>
                  <td>{{ $setoran->tgl_setoran }}</td>
                  <td>{{ $setoran->waktu_setoran === "01" ? "Pagi" : "Sore" }}</td>
                  <td>{{ $setoran->petugas }}</td>
                  <td>{{ $setoran->pembeli }}</td>
                  <td>{{ $setoran->total_susu }} lt</td>
                  <td>
                    <a href="{{ route('admin.setoran.edit', ['kode_setoran' => $setoran->kode_setoran]) }}" class="btn btn-warning">Edit</a>
                    <a 
                        href="{{ route('admin.setoran.delete', ['kode_setoran' => $setoran->kode_setoran]) }}" 
                        class="btn btn-danger"
                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                    >
                      Delete
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection