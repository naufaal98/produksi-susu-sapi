<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sapi;
use App\HasilPerahan;

class PerahanController extends Controller
{
    public function getPerahanIndex ()
    {
        $all_perahan = HasilPerahan::all();
        return view('admin.perahan.index', ['all_perahan' => $all_perahan]);
    }

    public function getCreatePerahan ()
    {
        $all_sapi = Sapi::all();
        return view('admin.perahan.create_perahan', ['all_sapi' => $all_sapi]);
    }

    public function postCreatePerahan (Request $request)
    {
        $this->validate($request, [
            'jumlah_susu' => 'required|max:4',
            'kode_sapi' => 'required'
        ]);

        $perahan = new HasilPerahan();
        $perahan->jumlah_susu = $request->jumlah_susu;
        $perahan->kode_sapi = $request->kode_sapi;
        $perahan->tgl_pemerahan = date("Y/m/d");
        $perahan->save();
        return redirect()->route('admin.perahan')->with(['success' => 'Data Perahan Berhasil ditambah.']);
    }

    public function getUpdatePerahan ($id_pemerahan)
    {
        $all_sapi = Sapi::all();
        $perahan = HasilPerahan::find($id_pemerahan);
        // return $perahan;
        return view('admin.perahan.edit_perahan', [
            'all_sapi' => $all_sapi,
            'perahan' => $perahan
        ]);
    }

    public function postUpdatePerahan (Request $request)
    {
        $perahan = HasilPerahan::find($request['id_pemerahan']);
        
        $perahan->jumlah_susu = $request->jumlah_susu;
        $perahan->kode_sapi = $request->kode_sapi;
        $perahan->update();
        return redirect()->route('admin.perahan');
    }

    public function getDeletePerahan ($id_pemerahan)
    {
        $perahan = HasilPerahan::find($id_pemerahan);
        $perahan->delete();
        
        return redirect()->route('admin.perahan');
    }
}
