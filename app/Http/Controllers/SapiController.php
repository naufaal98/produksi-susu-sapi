<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sapi;
use DateTime;

class SapiController extends Controller
{
    public function getSapiIndex ()
    {
        $all_sapi = Sapi::orderBy('created_at', 'DESC')->get();
        return view('admin.sapi.index', ['all_sapi' => $all_sapi]);
    }

    public function getCreateSapi ()
	{
		return view('admin.sapi.create_sapi');
    }
    
    public function postCreateSapi (Request $request)
    {
        $this->validate($request, [
            'tgl_lahir_sapi' => 'required',
            'no_kandang' => 'required'
        ]);
        
        // ambil data sapi terakhir yang diinput
        $last_sapi = Sapi::latest('created_at')->first();

        // ambil nomor terakhir dari sapi
        if ($last_sapi) {
            $last_sapi_number = (int)substr($last_sapi->kode_sapi, -2);
            $last_sapi_number+=1;
            if ($last_sapi_number < 9) {
                $last_sapi_number = "0".$last_sapi_number;
            }
        } else {
            $last_sapi_number = "01";
        }

        // ambil 2 digit terakhir dari tahun kelahiran sapi
        $tgl_lahir_sapi = DateTime::createFromFormat("Y-m-d", $request->tgl_lahir_sapi);
        $tahun_lahir_sapi = substr($tgl_lahir_sapi->format("Y"), -2);

        $sapi = new Sapi();
        $sapi->kode_sapi = $tahun_lahir_sapi.$last_sapi_number;
        $sapi->tgl_lahir_sapi = $request->tgl_lahir_sapi;
        $sapi->no_kandang = $request->no_kandang;
        $sapi->save();
        return redirect()->route('admin.sapi')->with(['success' => 'Data Sapi Berhasil ditambah.']);
    }

    public function getUpdateSapi ($kode_sapi)
    {
        $sapi = Sapi::find($kode_sapi);
        return view('admin.sapi.edit_sapi', ['sapi' => $sapi]);
    }

    public function postUpdateSapi (Request $request)
    {
        $sapi = Sapi::find($request['kode_sapi']);
        $this->validate($request, [
            'tgl_lahir_sapi' => 'required',
            'no_kandang' => 'required'
        ]);
        
        $last_sapi_number = substr($request->kode_sapi, -2);

        // ambil 2 digit terakhir dari tahun kelahiran sapi
        $tgl_lahir_sapi = DateTime::createFromFormat("Y-m-d", $request->tgl_lahir_sapi);
        $tahun_lahir_sapi = substr($tgl_lahir_sapi->format("Y"), -2);

        $sapi->kode_sapi = $tahun_lahir_sapi.$last_sapi_number;
        $sapi->tgl_lahir_sapi = $request->tgl_lahir_sapi;
        $sapi->no_kandang = $request->no_kandang;
        $sapi->update();
        return redirect()->route('admin.sapi');
    }

    public function getDeleteSapi ($kode_sapi)
    {
        $sapi = Sapi::find($kode_sapi);
        $sapi->delete();
        return redirect()->route('admin.sapi');
    }
}
