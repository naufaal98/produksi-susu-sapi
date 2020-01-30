@extends('layouts.master')

@section('title', 'Pengolahan Data Hasil Perahan')

@section('content')
<div class="row">
  <div class="col-xl-8 col-md-10 mb-12">
    <div class="card">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Perahan</h6>
      </div>
      <div class="card-body">
        <p>
          <a href="{{ route('admin.perahan.create') }}" class="btn btn-primary">Tambah Data Perahan</a>
        </p>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Tgl Pemerahan</th>
                <th>Jumlah Susu</th>
                <th>Kode Sapi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($all_perahan as $perahan)
                <tr>
                  <td>{{ $perahan->tgl_pemerahan }}</td>
                  <td>{{ $perahan->jumlah_susu }} lt</td>
                  <td>{{ $perahan->kode_sapi }}</td>
                  <td>
                    <a href="{{ route('admin.perahan.edit', ['id_pemerahan' => $perahan->id_pemerahan]) }}" class="btn btn-warning">Edit</a>
                    <a 
                        href="{{ route('admin.perahan.delete', ['id_pemerahan' => $perahan->id_pemerahan]) }}" 
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