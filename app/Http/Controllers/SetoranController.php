<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penyetoran;
use App\HasilPerahan;
use DateTime;
use PDF;

class SetoranController extends Controller
{
    public function getSetoranIndex ()
    {
        $penyetoran = Penyetoran::all();
        foreach($penyetoran as $setoran) {
            $subSetoran = Penyetoran::find($setoran->kode_setoran);
            foreach($subSetoran->perahan as $detail_perahan) {
                $setoran->total_susu += $detail_perahan->jumlah_susu;
            }
        }
        // return $penyetoran;
        return view('admin.setoran.index', ['penyetoran' => $penyetoran]);
    }

    public function getCreateSetoran ()
    {
        $hasil_perahan = HasilPerahan::where("kode_setoran", NULL)->orWhere("kode_setoran", "")->get();
        return view('admin.setoran.create_setoran', ['hasil_perahan' => $hasil_perahan]);
    }

    public function postCreateSetoran (Request $request)
    {
        $this->validate($request, [
            'tgl_setoran' => 'required',
            'waktu_setoran' => 'required',
            'nama_petugas' => 'required',
            'nama_pembeli' => 'required',
            'hasil_perahan' => 'required'
        ]);

        $last_setoran = Penyetoran::latest('created_at')->first();

        // ambil nomor terakhir dari kode_setoran
        if ($last_setoran) {
            $last_setoran = (int)substr($last_setoran->kode_setoran, -2);
            $last_setoran += 1;
            if ($last_setoran < 9) {
                $last_setoran = "0".$last_setoran;
            }
        } else {
            $last_setoran = "01";
        }

        $date_setoran = DateTime::createFromFormat("Y-m-d", $request->tgl_setoran);
        $tanggal_setoran = substr($date_setoran->format("d"), -2);
        $bulan_setoran = substr($date_setoran->format("m"), -2);
        $tahun_setoran = substr($date_setoran->format("Y"), -2);

        $kode_setoran = $tanggal_setoran.$bulan_setoran.$tahun_setoran.$request->waktu_setoran.$last_setoran;

        $setoran = new Penyetoran();
        $setoran->kode_setoran = $kode_setoran;
        $setoran->tgl_setoran = $request->tgl_setoran;
        $setoran->waktu_setoran = $request->waktu_setoran;
        $setoran->petugas = $request->nama_petugas;
        $setoran->pembeli = $request->nama_pembeli;
        if ($setoran->save()) {
            foreach($request->hasil_perahan as $hasil_perahan) {
                $perahan = HasilPerahan::find($hasil_perahan);
                $perahan->kode_setoran = $kode_setoran;
                $perahan->update();
            }
        }

        return redirect()->route('admin.setoran')->with(['success' => 'Data Setoran Berhasil ditambah.']);
    }

    public function getUpdateSetoran($kode_setoran)
    {
        $setoran = Penyetoran::find($kode_setoran);
        $hasil_perahan = HasilPerahan::where("kode_setoran", NULL)->orWhere("kode_setoran", "")->orWhere("kode_setoran", $kode_setoran)->get();
        return view('admin.setoran.edit_setoran', [
            'hasil_perahan' => $hasil_perahan,
            'setoran' => $setoran
        ]);
    }

    public function postUpdateSetoran (Request $request)
    {
        $this->validate($request, [
            'tgl_setoran' => 'required',
            'waktu_setoran' => 'required',
            'nama_petugas' => 'required',
            'nama_pembeli' => 'required',
            'hasil_perahan' => 'required'
        ]);

        $hasil_perahan_old = HasilPerahan::where("kode_setoran", $request->kode_setoran)->get();
        foreach($hasil_perahan_old as $perahan_old) {
            $status = 0;
            foreach($request->hasil_perahan as $perahan_new) {
                if ($perahan_old->kode_perahan == $perahan_new) {
                    $status = 1;
                }
            }

            if ($status == 0) {
                $perahan_old->kode_setoran = NULL;
                $perahan_old->update();
            }
        }
        $setoran = Penyetoran::find($request->kode_setoran);
        $setoran->tgl_setoran = $request->tgl_setoran;
        $setoran->waktu_setoran = $request->waktu_setoran;
        $setoran->petugas = $request->nama_petugas;
        $setoran->pembeli = $request->nama_pembeli;
        if ($setoran->save()) {
            foreach($request->hasil_perahan as $hasil_perahan) {
                $perahan = HasilPerahan::find($hasil_perahan);
                $perahan->kode_setoran = $request->kode_setoran;
                $perahan->update();
            }
        }
        return redirect()->route('admin.setoran');
    }

    public function getDeleteSetoran ($kode_setoran)
    {
        $setoran = Penyetoran::find($kode_setoran);
        if($setoran->delete()) {
            $hasil_perahan_old = HasilPerahan::where("kode_setoran", $kode_setoran)->get();
            foreach($hasil_perahan_old as $perahan_old) {
                $perahan_old->kode_setoran = NULL;
                $perahan_old->update();
            }
        }
        return redirect()->route('admin.setoran');
    }

    public function cetak_pdf ()
    {
        $penyetoran = Penyetoran::all();
        foreach($penyetoran as $setoran) {
            $subSetoran = Penyetoran::find($setoran->kode_setoran);
            foreach($subSetoran->perahan as $detail_perahan) {
                $setoran->total_susu += $detail_perahan->jumlah_susu;
            }
        }
        if ($penyetoran->count() < 1) {
            return redirect()->route('admin.setoran')->with(['fail' => 'Belum ada data setoran untuk dicetak.']);;
        }
        $pdf = PDF::loadview('admin.setoran.laporan', ['penyetoran'=>$penyetoran]);
        return $pdf->download('laporan-setoran-pdf');
    }
}
