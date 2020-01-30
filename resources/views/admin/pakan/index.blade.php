@extends('layouts.master')

@section('title', 'Pengolahan Data Stok Pakan')

@section('content')
<div class="row">
  <div class="col-xl-8 col-md-10 mb-12">
    <div class="card">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pakan</h6>
      </div>
      <div class="card-body">
        @if ($stok_pakan_hari_ini->count() < 1)
          <p>
            <a href="{{ route('admin.pakan.create') }}" class="btn btn-primary">Tambah Data Pakan Hari Ini</a>
          </p>
        @else
          <div class="alert alert-success" role="alert">
            Data stok hari ini sudah dimasukan dan dilakukan pembagian kepada setiap sapi, hasil pembagian pakan bisa dilihat <a href="{{ route('admin.pembagian_pakan') }}">disini</a>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table table-bordered tabel_pakan" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Tgl Penyetokan</th>
                <th>Stok Rumput</th>
                <th>Stok Mako</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($stok_pakan_all as $stok_pakan)
                <tr>
                  <td>{{ $stok_pakan->tgl_penyetokan }}</td>
                  <td>{{ $stok_pakan->stok_mako }} Kg</td>
                  <td>{{ $stok_pakan->stok_rumput }} Kg</td>
                  <td>
                    @if ($stok_pakan->tgl_penyetokan == date('Y-m-d'))
                      <a href="{{ route('admin.pakan.edit', ['id_penyetokan' => $stok_pakan->id_penyetokan]) }}" class="btn btn-warning">Edit</a>
                      <a 
                        href="{{ route('admin.pakan.delete', ['id_penyetokan' => $stok_pakan->id_penyetokan]) }}" 
                        class="btn btn-danger"
                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                      >
                        Delete
                      </a>
                    @else
                      <a href="{{ route('admin.pakan.detail', ['id_penyetokan' => $stok_pakan->id_penyetokan]) }}" class="btn btn-primary">Detail</a>
                    @endif
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

@section('script')
  <script>
    $('.tabel_pakan').dataTable({
      aaSorting: [[1, 'desc']]
    });
  </script>
@endsection