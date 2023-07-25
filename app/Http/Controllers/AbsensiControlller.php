<?php

namespace App\Http\Controllers;

use App\Models\PengajuanIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class AbsensiControlller extends Controller
{
    function create()
    {
        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('absensi')->where('tgl_absensi', $hariini)->where('nik', $nik)->count();
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('absensi.create', compact('cek', 'lok_kantor'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_absensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        $lok = explode(",", $lok_kantor->lokasi_kantor);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);
        $image = $request->image;
        $folderPath = "public/upload/absensi/";
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);

        $cek = DB::table('absensi')->where('tgl_absensi', $tgl_absensi)->where('nik', $nik)->count();
        if($radius > $lok_kantor->radius) {
            echo "error|Maaf Anda Berada Diluar Radius, Jarak Anda " .$radius. " meter dari Kantor!|radius";
        } else {
        if($cek > 0) {
            $formatName = $nik . "_" . $tgl_absensi . "_out";
            $fileName = $formatName . ".png";
            $file = $folderPath . $fileName;

            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'lokasi_out' => $lokasi
            ];
            $update = DB::table('absensi')->where ('tgl_absensi', $tgl_absensi)->where('nik', $nik)->update($data_pulang);
            if($update){
                echo "success|Terimakasih, Hati Hati Di Jalan!|out";
                Storage::put($file, $image_base64);
            } else {
                echo "error|Maaf Gagal Absen, Silakan Coba Lagi!|out";
            }
        }else {
            $formatName = $nik . "_" . $tgl_absensi . "_in";
            $fileName = $formatName . ".png";
            $file = $folderPath . $fileName;
            $data = [
                'nik' => $nik,
                'tgl_absensi' => $tgl_absensi,
                'jam_in' => $jam,
                'foto_in' => $fileName,
                'lokasi_in' => $lokasi
            ];
            $simpan = DB::table('absensi')->insert($data);
            if($simpan){
                echo "success|Terimakasih, Selamat Berkerja!|in";
                Storage::put($file, $image_base64);
            } else {
                echo "error|Maaf Gagal Absen, Silakan Coba Lagi!|in";
            }
        }
    }
    }

    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('absensi.editprofile', compact('karyawan'));
    }

    function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        if($request->hasFile('foto')){
            $foto = $nik . "." . $request->File('foto')->getClientOriginalExtension();
        }
        else {
            $foto = $karyawan->foto;
        }
        try{
            if(empty($request->password)){
                $data = [
                    'nama_lengkap' => $nama_lengkap,
                    'no_hp' => $no_hp,
                    'foto' => $foto
                ];
            } else{
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto,
                'password' => $password
            ];
            }
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);
            if($update){
                if($request->hasFile('foto')){
                    $folderPath = "public/upload/karyawan/";
                    $folderPathOld = "public/upload/karyawan/". $karyawan->foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return redirect()->back()->with('success' , 'Data Berhasil Di Update!');
            } 
            } catch(\Exception $e) 
            {
                return redirect()->back()->with('error' , 'Data Gagal Di Update!');
            }
                return redirect()->back()->with('success' , 'Data Tidak Ada Perubahan!');
    }

    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
         "November", "Desember"];
        return view ('absensi.histori', compact('namabulan'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('absensi')
            ->leftjoin('pengajuan_izin', 'absensi.id_izin', '=', 'pengajuan_izin.id')
            ->where('absensi.nik', $nik)
            ->whereRaw('MONTH(tgl_absensi)="'. $bulan . '"')
            ->whereRaw('Year(tgl_absensi)="'. $tahun .'"')
            ->orderBy('tgl_absensi','asc')
            ->get();
        
        return view('absensi.gethistori', compact('histori'));
    }

    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan_izin')->where('nik', $nik)->orderBy('tgl_izin','desc')->get();
        return view('absensi.izin', compact('dataizin'));
    }

    public function buatizin()
    {
        return view('absensi.buatizin');
    }

    public function cektanggal(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('pengajuan_izin')->where('nik', $nik)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }

    public function storeizin(Request $request)
    {
        $message = [
            'unique' => 'Anda Sudah Mengajukan Izin/Sakit Di Tanggal Tersebut.'
        ];

        $request->validate([
            'tgl_izin' => 'unique:pengajuan_izin,tgl_izin'
        ], $message);

        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan_izin')
            ->select('tgl_izin')
            ->where('nik', $nik)
            ->where('tgl_izin', $tgl_izin)
            ->get();
        
            $data = [
                'nik' => $nik,
                'tgl_izin' => $tgl_izin,
                'status' => $status,
                'keterangan' => $keterangan,
                'status_approved' => '0'
            ];

            $simpan = DB::table('pengajuan_izin')->insert($data);
            
            $izinsakit = DB::table('pengajuan_izin')
            ->where('nik', $nik)
            ->where('tgl_izin', $tgl_izin)
            ->first();
            
            $dataabsen = [
                'nik' => $izinsakit->nik,
                'tgl_absensi' => $izinsakit->tgl_izin,
                'jam_in' => '00:00:00',
                'jam_out' => '00:00:00',
                'id_izin' => $izinsakit->id
            ];

            $simpanabsen = DB::table('absensi')->insert($dataabsen);
            
            if($simpan)
            {
                return redirect('/absensi/izin')->with('success' , 'Data Berhasil Disimpan!');
            } else {
                return redirect('/absensi/izin')->with('error' , 'Data Gagal Disimpan!');
            }
    }

    public function editizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $dataizin = DB::table('pengajuan_izin')->where('nik', $nik)->where('tgl_izin', $tgl_izin)->first();
        return view('absensi.editizin', compact('dataizin'));
    }

    public function updateizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        try{
            $data = [
                'tgl_izin' => $tgl_izin,
                'status' => $status,
                'keterangan' => $keterangan
            ];
            $update = DB::table('pengajuan_izin')->where('nik', $nik)->where('tgl_izin', $tgl_izin)->update($data);
            if($update){
                return redirect('/absensi/izin')->with('success' , 'Data Berhasil Di Update!');
            } 
            } catch(\Exception $e) 
            {
                return redirect('/absensi/izin')->with('error' , 'Data Gagal Di Update!');
            }
                return redirect('/absensi/izin')->with('success' , 'Data Tidak Ada Perubahan!');
    }

    public function monitoring()
    {
        return view('absensi.monitoring');
    }

    public function getabsensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $absensi = DB::table('absensi')
            ->select('absensi.*', 'nama_lengkap', 'jabatan', 'status')
            ->join('karyawan', 'absensi.nik', '=' , 'karyawan.nik')
            ->leftjoin('pengajuan_izin', 'absensi.id_izin', '=', 'pengajuan_izin.id')
            ->where('tgl_absensi', $tanggal)
            ->get();

        return view('absensi.getabsensi', compact('absensi'));
    }

    public function laporan()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
         "November", "Desember"];
         $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('absensi.laporan', compact('namabulan','karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
         "November", "Desember"];
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $absensi = DB::table('absensi')
            ->join('karyawan','absensi.nik','=','karyawan.nik')
            ->leftjoin('pengajuan_izin', 'absensi.id_izin', '=', 'pengajuan_izin.id')
            ->where('absensi.nik', $nik)
            ->whereRaw('MONTH(tgl_absensi)="'. $bulan .'"')
            ->whereRaw('Year(tgl_absensi)="'. $tahun .'"')
            ->orderBy('tgl_absensi', 'asc')
            ->get();
        return view('absensi.cetaklaporan', compact('bulan','tahun','namabulan','karyawan','absensi'));
    }

    public function rekap()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
         "November", "Desember"];
        
        return view('absensi.rekap', compact('namabulan'));
    }

    public function cetakrekap(Request $request)
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
         "November", "Desember"];
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $rekap = DB::table('absensi')
        ->selectRAW('absensi.nik, nama_lengkap, 
        MAX(case when DAY(tgl_absensi) = 1 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 1 AND status = "i" then 2 when DAY(tgl_absensi) = 1 AND status = "s" then 3 end) as tgl1,
        MAX(case when DAY(tgl_absensi) = 2 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 2 AND status = "i" then 2 when DAY(tgl_absensi) = 2 AND status = "s" then 3 end) as tgl2,
        MAX(case when DAY(tgl_absensi) = 3 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 3 AND status = "i" then 2 when DAY(tgl_absensi) = 3 AND status = "s" then 3 end) as tgl3,
        MAX(case when DAY(tgl_absensi) = 4 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 4 AND status = "i" then 2 when DAY(tgl_absensi) = 4 AND status = "s" then 3 end) as tgl4,
        MAX(case when DAY(tgl_absensi) = 5 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 5 AND status = "i" then 2 when DAY(tgl_absensi) = 5 AND status = "s" then 3 end) as tgl5,
        MAX(case when DAY(tgl_absensi) = 6 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 6 AND status = "i" then 2 when DAY(tgl_absensi) = 6 AND status = "s" then 3 end) as tgl6,
        MAX(case when DAY(tgl_absensi) = 7 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 7 AND status = "i" then 2 when DAY(tgl_absensi) = 7 AND status = "s" then 3 end) as tgl7,
        MAX(case when DAY(tgl_absensi) = 8 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 8 AND status = "i" then 2 when DAY(tgl_absensi) = 8 AND status = "s" then 3 end) as tgl8,
        MAX(case when DAY(tgl_absensi) = 9 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 9 AND status = "i" then 2 when DAY(tgl_absensi) = 9 AND status = "s" then 3 end) as tgl9,
        MAX(case when DAY(tgl_absensi) = 10 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 10 AND status = "i" then 2 when DAY(tgl_absensi) = 10 AND status = "s" then 3 end) as tgl10,
        MAX(case when DAY(tgl_absensi) = 11 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 11 AND status = "i" then 2 when DAY(tgl_absensi) = 11 AND status = "s" then 3 end) as tgl11,
        MAX(case when DAY(tgl_absensi) = 12 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 12 AND status = "i" then 2 when DAY(tgl_absensi) = 12 AND status = "s" then 3 end) as tgl12,
        MAX(case when DAY(tgl_absensi) = 13 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 13 AND status = "i" then 2 when DAY(tgl_absensi) = 13 AND status = "s" then 3 end) as tgl13,
        MAX(case when DAY(tgl_absensi) = 14 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 14 AND status = "i" then 2 when DAY(tgl_absensi) = 14 AND status = "s" then 3 end) as tgl14,
        MAX(case when DAY(tgl_absensi) = 15 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 15 AND status = "i" then 2 when DAY(tgl_absensi) = 15 AND status = "s" then 3 end) as tgl15,
        MAX(case when DAY(tgl_absensi) = 16 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 16 AND status = "i" then 2 when DAY(tgl_absensi) = 16 AND status = "s" then 3 end) as tgl16,
        MAX(case when DAY(tgl_absensi) = 17 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 17 AND status = "i" then 2 when DAY(tgl_absensi) = 17 AND status = "s" then 3 end) as tgl17,
        MAX(case when DAY(tgl_absensi) = 18 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 18 AND status = "i" then 2 when DAY(tgl_absensi) = 18 AND status = "s" then 3 end) as tgl18,
        MAX(case when DAY(tgl_absensi) = 19 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 19 AND status = "i" then 2 when DAY(tgl_absensi) = 19 AND status = "s" then 3 end) as tgl19,
        MAX(case when DAY(tgl_absensi) = 20 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 20 AND status = "i" then 2 when DAY(tgl_absensi) = 20 AND status = "s" then 3 end) as tgl20,
        MAX(case when DAY(tgl_absensi) = 21 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 21 AND status = "i" then 2 when DAY(tgl_absensi) = 21 AND status = "s" then 3 end) as tgl21,
        MAX(case when DAY(tgl_absensi) = 22 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 22 AND status = "i" then 2 when DAY(tgl_absensi) = 22 AND status = "s" then 3 end) as tgl22,
        MAX(case when DAY(tgl_absensi) = 23 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 23 AND status = "i" then 2 when DAY(tgl_absensi) = 23 AND status = "s" then 3 end) as tgl23,
        MAX(case when DAY(tgl_absensi) = 24 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 24 AND status = "i" then 2 when DAY(tgl_absensi) = 24 AND status = "s" then 3 end) as tgl24,
        MAX(case when DAY(tgl_absensi) = 25 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 25 AND status = "i" then 2 when DAY(tgl_absensi) = 25 AND status = "s" then 3 end) as tgl25,
        MAX(case when DAY(tgl_absensi) = 26 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 26 AND status = "i" then 2 when DAY(tgl_absensi) = 26 AND status = "s" then 3 end) as tgl26,
        MAX(case when DAY(tgl_absensi) = 27 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 27 AND status = "i" then 2 when DAY(tgl_absensi) = 27 AND status = "s" then 3 end) as tgl27,
        MAX(case when DAY(tgl_absensi) = 28 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 28 AND status = "i" then 2 when DAY(tgl_absensi) = 28 AND status = "s" then 3 end) as tgl28,
        MAX(case when DAY(tgl_absensi) = 29 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 29 AND status = "i" then 2 when DAY(tgl_absensi) = 29 AND status = "s" then 3 end) as tgl29,
        MAX(case when DAY(tgl_absensi) = 30 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 30 AND status = "i" then 2 when DAY(tgl_absensi) = 30 AND status = "s" then 3 end) as tgl30,
        MAX(case when DAY(tgl_absensi) = 31 AND jam_in != "00:00:00" then 1 when DAY(tgl_absensi) = 31 AND status = "i" then 2 when DAY(tgl_absensi) = 31 AND status = "s" then 3 end) as tgl31,
        SUM(IF(jam_in != "00:00:00", 1, 0)) as totalhadir, SUM(IF(status = "i", 1, 0)) as totalizin, SUM(IF(status = "s", 1, 0)) as totalsakit')
        ->join('karyawan', 'absensi.nik', '=', 'karyawan.nik')
        ->leftjoin('pengajuan_izin', 'absensi.id_izin', '=', 'pengajuan_izin.id')
        ->whereRaw('MONTH(tgl_absensi)="'. $bulan .'"')
        ->whereRaw('YEAR(tgl_absensi)="'. $tahun .'"')
        ->groupBy('absensi.nik','nama_lengkap')
        ->get();

       return view('absensi.cetakrekap', compact('namabulan', 'bulan', 'tahun', 'rekap')); 
    }

    public function izinsakit(Request $request)
    {
        $query = PengajuanIzin::query();
        $query->select('id','tgl_izin','pengajuan_izin.nik','nama_lengkap','jabatan','status','keterangan');
        $query->join('karyawan','pengajuan_izin.nik','=','karyawan.nik');
        if(!empty($request->dari) && !empty($request->sampai)){
            $query->whereBetween('tgl_izin',[$request->dari,$request->sampai]);
        }
        if(!empty($request->nik)){
            $query->where('pengajuan_izin.nik','like','%'. $request->nik .'%');
        }
        if(!empty($request->nama)){
            $query->where('nama_lengkap','like','%'. $request->nama .'%');
        }
        $query->orderBy('tgl_izin','desc');
        $izinsakit = $query->paginate(8);
        $izinsakit->appends($request->all());
        return view('absensi.izinsakit', compact('izinsakit'));
    }
}
