<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pembagian Pakan</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

	<div class="container">
		<center>
			<h4>Laporan Pembagian Pakan Tanggal {{ $tgl_penyetokan }}</h4>
		</center>
		<br/>
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

</body>
</html>