<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\StokPakan;
use App\Sapi;
use App\PemberianPakan;
use Carbon\Carbon;
use PDF;

use Illuminate\Support\Facades\DB;

class PakanController extends Controller
{
    public function getPakanIndex ()
    {
        $stok_pakan_all = StokPakan::orderBy('created_at', 'DESC')->get();
        $stok_pakan_hari_ini = StokPakan::where("tgl_penyetokan", date('Y-m-d'))->get();
        return view('admin.pakan.index', [
            'stok_pakan_hari_ini' => $stok_pakan_hari_ini,
            'stok_pakan_all' => $stok_pakan_all
        ]);
    }

    public function getDetailPenyetokan ($id_penyetokan)
    {
        $penyetokan = StokPakan::find($id_penyetokan);
        $pembagian_pakan = PemberianPakan::where("id_penyetokan", $id_penyetokan)->get();
        return view('admin.pakan.detail_pakan', [
            'pembagian_pakan' => $pembagian_pakan,
            'tgl_penyetokan' => $penyetokan->tgl_penyetokan,
            'id_penyetokan' => $id_penyetokan
        ]);
    }

    public function cetak_pdf ($id_penyetokan)
    {
        $penyetokan = StokPakan::find($id_penyetokan);
        $pembagian_pakan = PemberianPakan::where("id_penyetokan", $id_penyetokan)->get();
        $pdf = PDF::loadview('admin.pakan.laporan', [
            'pembagian_pakan'=>$pembagian_pakan,
            'tgl_penyetokan' => $penyetokan->tgl_penyetokan,
            'id_penyetokan' => $id_penyetokan
        ]);
        return $pdf->download('laporan-pembagian-pakan-'.$penyetokan->tgl_penyetokan.'-pdf');
    }

    public function getCreatePakan ()
    {
        return view('admin.pakan.create_pakan');
    }

    public function postCreatePakan (Request $request)
    {
        $this->validate($request, [
            'stok_mako' => 'required|numeric',
            'stok_rumput' => 'required|numeric'
        ]);

        $stok_pakan = new StokPakan();
        $stok_pakan->stok_rumput = $request->stok_rumput;
        $stok_pakan->stok_mako = $request->stok_mako;
        $stok_pakan->tgl_penyetokan = date("Y/m/d");
        
        if ($stok_pakan->save()) {
            $stok_pakan = StokPakan::latest('created_at')->first();
            $id_penyetokan = $stok_pakan->id_penyetokan;

            /*
             * Proses Pembagian Pakan
             */
            $total_mako = $request->stok_mako;
            $total_rumput = $request->stok_rumput;

            $persen_mako_prioritas = 60;
            $persen_mako_non_prioritas = 40;
            $persen_rumput_prioritas = 40;
            $persen_rumput_non_prioritas = 60;

            $jumlah_sapi_prioritas = 0;
            $jumlah_sapi_non_prioritas = 0;

            $all_sapi = Sapi::all();
            // Menghitung jumlah sapi prioritas dan bukan prioritas
            foreach ($all_sapi as $sapi) {
                $usia = Carbon::parse($sapi->tgl_lahir_sapi)->age;
                $sapi->usia = $usia;
                $sapi->usia <= 7 ? $jumlah_sapi_prioritas++ : $jumlah_sapi_non_prioritas++; 
            }

            $total_sapi = $jumlah_sapi_prioritas + $jumlah_sapi_non_prioritas;
            
            // Menghitung Pembagian Mako
            $pakan_mako_sapi_prioritas = $this->kalkulasiPakan(
                $total_mako,
                $persen_mako_prioritas,
                $total_sapi,
                $jumlah_sapi_prioritas,
                $jumlah_sapi_non_prioritas
            );

            $pakan_mako_sapi_non_prioritas = $this->kalkulasiPakan(
                $total_mako,
                $persen_mako_non_prioritas,
                $total_sapi,
                $jumlah_sapi_non_prioritas,
                $jumlah_sapi_prioritas
            );

            $pembagian_mako = $this->kalkulasiPakanPembagianAkhir(
                $pakan_mako_sapi_prioritas,
                $pakan_mako_sapi_non_prioritas,
                $total_mako,
                $total_sapi
            );

            // Menghitung Pembagian Rumput
            $pakan_rumput_sapi_prioritas = $this->kalkulasiPakan(
                $total_rumput,
                $persen_rumput_prioritas,
                $total_sapi,
                $jumlah_sapi_prioritas,
                $jumlah_sapi_non_prioritas
            );

            $pakan_rumput_sapi_non_prioritas = $this->kalkulasiPakan(
                $total_rumput,
                $persen_rumput_non_prioritas,
                $total_sapi,
                $jumlah_sapi_non_prioritas,
                $jumlah_sapi_prioritas
            );

            $pembagian_rumput = $this->kalkulasiPakanPembagianAkhir(
                $pakan_rumput_sapi_prioritas,
                $pakan_rumput_sapi_non_prioritas,
                $total_rumput,
                $total_sapi
            );

            foreach ($all_sapi as $sapi) {
                $pemberian_pakan = new PemberianPakan();
                if ($sapi->usia <= 7) {
                    $pemberian_pakan->jumlah_mako = $pembagian_mako->getData()->pembagian_sapi_prioritas;
                    $pemberian_pakan->jumlah_rumput = $pembagian_rumput->getData()->pembagian_sapi_prioritas;
                } else {
                    $pemberian_pakan->jumlah_mako = $pembagian_mako->getData()->pembagian_sapi_non_prioritas;
                    $pemberian_pakan->jumlah_rumput = $pembagian_rumput->getData()->pembagian_sapi_non_prioritas;
                }
                $pemberian_pakan->tgl_pemberian = date("Y/m/d");
                $pemberian_pakan->kode_sapi = $sapi->kode_sapi;
                $pemberian_pakan->id_penyetokan = $id_penyetokan;
                $pemberian_pakan->save();
            }
        }

        return redirect()->route('admin.pembagian_pakan');
    }

    public function getUpdatePakan ($id_penyetokan)
    {
        $penyetokan = StokPakan::find($id_penyetokan);
        // $pembagian_pakan = DB::table('pemberian_pakan')->where('id_penyetokan', $id_penyetokan)->delete();
        
        return view('admin.pakan.edit_pakan', ['penyetokan' => $penyetokan]);
    }

    public function postUpdatePakan (Request $request) 
    {
        $this->validate($request, [
            'stok_mako' => 'required|numeric',
            'stok_rumput' => 'required|numeric'
        ]);

        $pembagian_pakan = DB::table('pemberian_pakan')->where('id_penyetokan', $request->id_penyetokan)->delete();

        $stok_pakan = StokPakan::find($request->id_penyetokan);
        $stok_pakan->stok_rumput = $request->stok_rumput;
        $stok_pakan->stok_mako = $request->stok_mako;
        $stok_pakan->tgl_penyetokan = date("Y/m/d");
        
        if ($stok_pakan->update()) {
            $stok_pakan = StokPakan::latest('created_at')->first();
            $id_penyetokan = $request->id_penyetokan;

            /*
             * Proses Pembagian Pakan
             */
            $total_mako = $request->stok_mako;
            $total_rumput = $request->stok_rumput;

            $persen_mako_prioritas = 60;
            $persen_mako_non_prioritas = 40;
            $persen_rumput_prioritas = 40;
            $persen_rumput_non_prioritas = 60;

            $jumlah_sapi_prioritas = 0;
            $jumlah_sapi_non_prioritas = 0;

            $all_sapi = Sapi::all();
            // Menghitung jumlah sapi prioritas dan bukan prioritas
            foreach ($all_sapi as $sapi) {
                $usia = Carbon::parse($sapi->tgl_lahir_sapi)->age;
                $sapi->usia = $usia;
                $sapi->usia <= 7 ? $jumlah_sapi_prioritas++ : $jumlah_sapi_non_prioritas++; 
            }

            $total_sapi = $jumlah_sapi_prioritas + $jumlah_sapi_non_prioritas;
            
            // Menghitung Pembagian Mako
            $pakan_mako_sapi_prioritas = $this->kalkulasiPakan(
                $total_mako,
                $persen_mako_prioritas,
                $total_sapi,
                $jumlah_sapi_prioritas,
                $jumlah_sapi_non_prioritas
            );

            $pakan_mako_sapi_non_prioritas = $this->kalkulasiPakan(
                $total_mako,
                $persen_mako_non_prioritas,
                $total_sapi,
                $jumlah_sapi_non_prioritas,
                $jumlah_sapi_prioritas
            );

            $pembagian_mako = $this->kalkulasiPakanPembagianAkhir(
                $pakan_mako_sapi_prioritas,
                $pakan_mako_sapi_non_prioritas,
                $total_mako,
                $total_sapi
            );

            // Menghitung Pembagian Rumput
            $pakan_rumput_sapi_prioritas = $this->kalkulasiPakan(
                $total_rumput,
                $persen_rumput_prioritas,
                $total_sapi,
                $jumlah_sapi_prioritas,
                $jumlah_sapi_non_prioritas
            );

            $pakan_rumput_sapi_non_prioritas = $this->kalkulasiPakan(
                $total_rumput,
                $persen_rumput_non_prioritas,
                $total_sapi,
                $jumlah_sapi_non_prioritas,
                $jumlah_sapi_prioritas
            );

            $pembagian_rumput = $this->kalkulasiPakanPembagianAkhir(
                $pakan_rumput_sapi_prioritas,
                $pakan_rumput_sapi_non_prioritas,
                $total_rumput,
                $total_sapi
            );

            foreach ($all_sapi as $sapi) {
                $pemberian_pakan = new PemberianPakan();
                if ($sapi->usia <= 7) {
                    $pemberian_pakan->jumlah_mako = $pembagian_mako->getData()->pembagian_sapi_prioritas;
                    $pemberian_pakan->jumlah_rumput = $pembagian_rumput->getData()->pembagian_sapi_prioritas;
                } else {
                    $pemberian_pakan->jumlah_mako = $pembagian_mako->getData()->pembagian_sapi_non_prioritas;
                    $pemberian_pakan->jumlah_rumput = $pembagian_rumput->getData()->pembagian_sapi_non_prioritas;
                }
                $pemberian_pakan->tgl_pemberian = date("Y/m/d");
                $pemberian_pakan->kode_sapi = $sapi->kode_sapi;
                $pemberian_pakan->id_penyetokan = $id_penyetokan;
                $pemberian_pakan->save();
            }
        }

        return redirect()->route('admin.pembagian_pakan');
    }

    public function getDeletePakan($id_penyetokan)
    {
        $pembagian_pakan = DB::table('pemberian_pakan')->where('id_penyetokan', $id_penyetokan)->delete();
        $penyetokan = StokPakan::find($id_penyetokan);
        $penyetokan->delete();

        return redirect()->route('admin.pakan');
    }

    private function kalkulasiPakan ($total_pakan, $persen, $total_sapi, $sapi_yang_dihitung, $sapi_yang_disisakan)
    {
        $sisa_kiri = $sapi_yang_dihitung/$total_sapi * ($total_pakan * ($persen /100));
        $sisa_kanan = $sapi_yang_disisakan/$total_sapi * ($total_pakan * ($persen /100));
        $sisa = $sisa_kiri - $sisa_kanan;

        if ($sisa < 0) {
            $sisa = $sisa * -1;
        }
        
        $pembagian_murni = $sisa_kiri / $sapi_yang_dihitung;
        $hasil_sementara = $pembagian_murni + $sisa;
        $total_hasil_sementara = $hasil_sementara * $sapi_yang_dihitung;
        
        return response()->json([
            "sisa_pakan" => $sisa,
            "pembagian_murni" => $pembagian_murni,
            "pembagian_sementara" => $hasil_sementara,
            "total_sementara" => $total_hasil_sementara
        ]);
    }

    private function kalkulasiPakanPembagianAkhir ($pakan_sapi_prioritas, $pakan_sapi_non_prioritas, $total_pakan, $total_sapi)
    {
        $jumlah_total_sementara = $pakan_sapi_prioritas->getData()->total_sementara + $pakan_sapi_non_prioritas->getData()->total_sementara;
        $selisih_kalkulasi_pembagian = $jumlah_total_sementara - $total_pakan;
        if ($selisih_kalkulasi_pembagian < 0) {
            $selisih_kalkulasi_pembagian = $selisih_kalkulasi_pembagian * -1;
        }
        $jumlah_yang_harus_dikurangi = $selisih_kalkulasi_pembagian / $total_sapi;

        if ($jumlah_total_sementara < $total_pakan) {
            $pembagian_akhir_sapi_prioritas = $pakan_sapi_prioritas->getData()->pembagian_sementara + $jumlah_yang_harus_dikurangi;
        $pembagian_akhir_sapi_non_prioritas = $pakan_sapi_non_prioritas->getData()->pembagian_sementara + $jumlah_yang_harus_dikurangi;
        } else {
            $pembagian_akhir_sapi_prioritas = $pakan_sapi_prioritas->getData()->pembagian_sementara - $jumlah_yang_harus_dikurangi;
            $pembagian_akhir_sapi_non_prioritas = $pakan_sapi_non_prioritas->getData()->pembagian_sementara - $jumlah_yang_harus_dikurangi;
        }
        
        return response()->json([
            "total_sementara" => $jumlah_total_sementara,
            "jumlah_selisih" => $selisih_kalkulasi_pembagian,
            "pembagian_sapi_prioritas" => round($pembagian_akhir_sapi_prioritas, 2),
            "pembagian_sapi_non_prioritas" => round($pembagian_akhir_sapi_non_prioritas, 2)
        ]);
    }
}
