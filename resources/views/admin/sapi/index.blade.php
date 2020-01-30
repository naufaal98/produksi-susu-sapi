@extends('layouts.master')

@section('title', 'Pengolahan Data Sapi')

@section('content')
<div class="row">
  <div class="col-xl-8 col-md-10 mb-12">
    <div class="card">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Sapi</h6>
      </div>
      <div class="card-body">
        <p>
          <a href="{{ route('admin.sapi.create') }}" class="btn btn-primary">Tambah Data Sapi</a>
        </p>
        @if (count($all_sapi) == 0)
          Data tidak ditemukan
        @else
          <div class="table-responsive">
            <table class="table table-bordered tabel_sapi" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode Sapi</th>
                  <th>Tgl Lahir Sapi</th>
                  <th>No Kandang</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($all_sapi as $sapi)
                  <tr>
                    <td>{{ $sapi->kode_sapi }}</td>
                    <td>{{ $sapi->tgl_lahir_sapi }}</td>
                    <td>{{ $sapi->no_kandang }}</td>
                    <td>
                      <a href="{{ route('admin.sapi.edit', ['kode_sapi' => $sapi->kode_sapi]) }}" class="btn btn-warning">Edit</a>
                      <a 
                        href="{{ route('admin.sapi.delete', ['kode_sapi' => $sapi->kode_sapi]) }}" 
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
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
  <script>
    $('.tabel_sapi').dataTable({
      aaSorting: [[1, 'desc']]
    });
  </script>
@endsection