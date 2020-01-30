<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PemberianPakan;
use PDF;

class PembagianPakanController extends Controller
{
    public function getPembagianPakanIndex ()
    {
        $pembagian_pakan_hari_ini = PemberianPakan::where("tgl_pemberian", date('Y-m-d'))->get();
        return view('admin.pembagian_pakan.index', ['pembagian_pakan_hari_ini' => $pembagian_pakan_hari_ini]);
    }

    public function cetak_pdf ()
    {
        $pembagian_pakan_hari_ini = PemberianPakan::where("tgl_pemberian", date('Y-m-d'))->get();
        // return view('admin.pembagian_pakan.laporan', ['pembagian_pakan_hari_ini'=>$pembagian_pakan_hari_ini]);
        $pdf = PDF::loadview('admin.pembagian_pakan.laporan', ['pembagian_pakan_hari_ini'=>$pembagian_pakan_hari_ini]);
        return $pdf->download('laporan-pembagian-pakan-'.date('Y-m-d').'-pdf');
    }
}

