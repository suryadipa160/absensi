<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function dashboard(){
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1;
        $tahunini = date("Y");
        $nik = Auth::guard('karyawan')->user()->nik;
        $absenhariini = DB::table('absensi')
            ->where('nik', $nik)
            ->where('tgl_absensi', $hariini)
            ->first();
        $historibulanini = DB::table('absensi')
            ->leftjoin('pengajuan_izin', 'absensi.id_izin', '=', 'pengajuan_izin.id')
            ->where('absensi.nik', $nik)
            ->whereRaw('MONTH(tgl_absensi)="'. $bulanini . '"')
            ->whereRaw('Year(tgl_absensi)="'. $tahunini .'"')
            ->orderBy('tgl_absensi','desc')
            ->get();
        $rekapabsensi = DB::table('absensi')
            ->selectRaw('SUM(IF(jam_in != "00:00:00", 1, 0)) as jmlhadir, SUM(IF(jam_in > "07:30", 1, 0)) as jmlterlambat')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_absensi)="'. $bulanini . '"')
            ->whereRaw('Year(tgl_absensi)="'. $tahunini .'"')
            ->first();
        $leaderboard = DB::table('absensi')
            ->join('karyawan', 'absensi.nik', '=', 'karyawan.nik')
            ->leftjoin('pengajuan_izin', 'absensi.id_izin', '=', 'pengajuan_izin.id')
            ->where('tgl_absensi', $hariini)
            ->get();
        $rekapizin = DB::table('pengajuan_izin')
            ->selectRAW('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_izin)="'. $bulanini . '"')
            ->whereRaw('Year(tgl_izin)="'. $tahunini .'"')
            // ->where('status_approved', 1)
            ->first();
        $status = DB::table('absensi')
            ->selectRaw('MAX(case when tgl_absensi = "'.$hariini.'" and status ="i" then 1 when tgl_absensi = "'.$hariini.'" and status ="s" then 2 when tgl_absensi = "'.$hariini.'" and jam_out != "" then 3 end) as status')
            ->join('karyawan', 'absensi.nik', '=', 'karyawan.nik')
            ->leftjoin('pengajuan_izin', 'absensi.id_izin', '=', 'pengajuan_izin.id')
            ->where('absensi.nik', $nik)
            ->whereRaw('MONTH(tgl_absensi)="'. $bulanini . '"')
            ->whereRaw('Year(tgl_absensi)="'. $tahunini .'"')
            ->first();
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view ('dashboard.dashboard', compact('absenhariini','historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekapabsensi',
        'leaderboard','rekapizin','status'));
    }

    public function dashboardadmin()
    {
        $hariini = date("Y-m-d");
        $rekapabsensi = DB::table('absensi')
            ->selectRaw('COUNT(IF(id_izin != "", NULL, absensi.nik)) as jmlhadir, SUM(IF(jam_in > "07:30", 1, 0)) as jmlterlambat') 
            ->where('tgl_absensi', $hariini)
            ->first();

        $rekapizin = DB::table('pengajuan_izin')
            ->selectRAW('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('tgl_izin', $hariini)
            // ->where('status_approved', 1)
            ->first();
        return view('dashboard.dashboardadmin', compact('rekapabsensi','rekapizin'));
    }
}
