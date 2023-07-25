<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = karyawan::query();
        $query->orderBy('nama_lengkap');
        if(!empty($request->nama_lengkap))
        {
            $query->where('nama_lengkap', 'like' , '%'. $request->nama_lengkap .'%');
        }
        $karyawan = $query->paginate(10);
        return view('karyawan.index', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $password = Hash::make('123asd');
        if($request->hasFile('foto')){
            $foto = $nik . "." . $request->File('foto')->getClientOriginalExtension();
        }
        else {
            $foto = null;
        }

        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'foto' => $foto,
                'password' => $password
            ];
            $simpan = DB::table('karyawan')->insert($data);
            if($simpan){
                if($request->hasFile('foto')){
                    $folderPath = "public/upload/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan!']);
            }
        } catch(\Exception $e)
        {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan!']);
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update($nik, Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $password = $request->password;
        $old_foto = $request->old_foto;
        if($request->hasFile('foto')){
            $foto = $nik . "." . $request->File('foto')->getClientOriginalExtension();
        }
        else {
            $foto = $old_foto;
        }

        try {
            if($password == "Ya"){
                $data = [
                    'nama_lengkap' => $nama_lengkap,
                    'jabatan' => $jabatan,
                    'no_hp' => $no_hp,
                    'foto' => $foto,
                    'password' => Hash::make('123asd')
                ];
            } else{
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
            }
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);
            if($update){
                if($request->hasFile('foto')){
                    $folderPath = "public/upload/karyawan/";
                    $folderPathOld = "public/upload/karyawan/". $old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate!']);
            }
        } catch(\Exception $e)
        {
            return Redirect::back()->with(['error' => 'Data Gagal Diupdate!']);
        }
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate!']);
    }

    public function delete($nik)
    {
        $cek = DB::table('karyawan')->where('nik', $nik)->first();
        if($cek->foto != null)
        {
            $folderPathOld = "public/upload/karyawan/". $cek->foto;
            Storage::delete($folderPathOld);
        }
        $delete = DB::table('karyawan')->where('nik', $nik)->delete();
        if($delete)
        {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus!']);
        } else 
        {
            return Redirect::back()->with(['success' => 'Data Gagal Dihapus!']);
        }
    }
}
