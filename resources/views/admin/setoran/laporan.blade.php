<!DOCTYPE html>
<html>
<head>
	<title>Laporan Setoran Susu Sapi</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

	<div class="container">
		<center>
			<h4>Laporan Setoran Susu Sapi <br> Peternakan Tjutju Rusmana</h4>
		</center>
		<br/>
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Kode Setoran</th>
          <th>Tgl Setoran</th>
          <th>Waktu Setoran</th>
          <th>Petugas</th>
          <th>Pembeli</th>
          <th>Total Susu</th>
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
          </tr>
        @endforeach
      </tbody>
    </table>

	</div>

</body>
</html>