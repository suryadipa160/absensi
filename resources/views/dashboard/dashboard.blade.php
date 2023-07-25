@extends('layouts.absensi')
@section('content')
	<div class="section" id="user-section">
            <div id="user-detail">
                <div class="avatar">
                    @if(!empty(Auth::guard('karyawan')->user()->foto))
                    @php
                    $path = Storage::url('upload/karyawan/'.Auth::guard('karyawan')->user()->foto);
                    @endphp
                    <img src="{{ url($path) }}" style="width: 95px; height: 95px; object-fit: cover;" alt="avatar" class="imaged">
                    @else
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                    @endif
                </div>
                <div id="user-info">
                    <h3 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h3>
                    <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan }}</span>
                </div>
            </div>
        </div>

        <div class="section mt-3" id="menu-section">
            <div class="card">
                <div class="card-body text-center" style="padding: 9px 8px !important;">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/editprofile" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/absensi/izin" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar-number"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Cuti</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/absensi/histori" class="warning" style="font-size: 40px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Histori</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/logout" class="orange" style="font-size: 40px;">
                                    <ion-icon name="log-out"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Log Out
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence" style="margin-top: 75px !important;">
                <div class="row">
                    <div class="col-6">
                        <div class="card gradasigreen">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if($absenhariini != null && $absenhariini->id_izin == null)
                                        @php
                                            $path = Storage::url('upload/absensi/'.$absenhariini->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w76">
                                        @else
                                        <ion-icon name="camera" style="font-size: 57px !important;"></ion-icon>
                                        @endif
                                    </div>
                                    <div style="margin-left: 20px;" class="presencedetail">
                                        <h4 class="presencetitle">Masuk</h4>
                                        <span>{{ $absenhariini != null ? \Carbon\Carbon::parse($absenhariini->jam_in)->format('H:i') : '--:--'}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card gradasired">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if($absenhariini != null && $absenhariini->jam_out > "00:00:00")
                                        @php
                                            $path = Storage::url('upload/absensi/'.$absenhariini->foto_out);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w76">
                                        @else
                                        <ion-icon name="camera" style="font-size: 57px !important;"></ion-icon>
                                        @endif
                                    </div>
                                    <div style="margin-left: 20px;" class="presencedetail">
                                        <h4 class="presencetitle">Pulang</h4>
                                        <span>{{ $absenhariini != null && $absenhariini->jam_out != null ?
                                            \Carbon\Carbon::parse($absenhariini->jam_out)->format('H:i') : '--:--'}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="rekapabsensi">
                <h3 class="text-center">Rekap Absensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</h3>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 16px 12px !important; line-hegiht: 0.8rem">
                                <span class="badge bg-danger" style="position: absolute; top: 3px; right: 10px; font-size: 0.6rem;
                                z-index:999">{{ $rekapabsensi->jmlhadir }}</span>
                                <ion-icon name="finger-print-outline" style="font-size: 1.6rem;" class="text-primary"></ion-icon>
                                <span style="font-size: 0.8rem; font-weight:500">Hadir</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 16px 12px !important;">
                                <span class="badge bg-danger" style="position: absolute; top: 3px; right: 10px; font-size: 0.6rem;
                                z-index:999">{{ $rekapizin != null && $rekapizin->jmlizin != null ?
                                            $rekapizin->jmlizin : '0' }}</span>
                                <ion-icon name="reader-outline" style="font-size: 1.6rem;" class="text-success"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem; font-weight:500">Izin</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 16px 12px !important;">
                            <span class="badge bg-danger" style="position: absolute; top: 3px; right: 10px; font-size: 0.6rem;
                                z-index:999">{{ $rekapizin != null && $rekapizin->jmlsakit != null ?
                                            $rekapizin->jmlsakit : '0' }}</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.6rem;" class="text-warning"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Sakit</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 16px 12px !important;">
                            <span class="badge bg-danger" style="position: absolute; top: 3px; right: 10px; font-size: 0.6rem;
                                z-index:999">{{ $rekapabsensi != null && $rekapabsensi->jmlterlambat != null ?
                                            $rekapabsensi->jmlterlambat : '0' }}</span>
                            <ion-icon name="alarm-outline" style="font-size: 1.6rem;" class="text-danger"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Telat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($historibulanini as $d)
                            <li>
                                <div class="item">
                                    <div class="icon-box">
                                        @if($d->jam_in == "00:00:00" && $d->status == "i")
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-info" color="#6574cd" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                            <path d="M11 14h1v4h1"></path>
                                            <path d="M12 11h.01"></path>
                                        </svg>
                                        @elseif($d->jam_in == "00:00:00" && $d->status == "s")
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-sick" color="#f1c40f" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 21a9 9 0 1 1 0 -18a9 9 0 0 1 0 18z"></path>
                                            <path d="M9 10h-.01"></path>
                                            <path d="M15 10h-.01"></path>
                                            <path d="M8 16l1 -1l1.5 1l1.5 -1l1.5 1l1.5 -1l1 1"></path>
                                        </svg>
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checkbox" color="#5eba00" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 11l3 3l8 -8"></path>
                                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                        </svg>
                                        @endif
                                    </div>
                                    <div class="in">
                                        <div>{{ date("d-m-Y", strtotime($d->tgl_absensi)) }}</div>
                                        @if($d->jam_in == "00:00:00" && $d->status == "i")
                                        <span class="badge badge-primary w-50">Izin</span>
                                        @elseif($d->jam_in == "00:00:00" && $d->status == "s")
                                        <span class="badge badge-warning w-50">Sakit</span>
                                        @else
                                        <span style="width: 70px;" class="badge badge-success">{{ \Carbon\Carbon::parse($d->jam_in)->format('H:i') }}</span>
                                        <span style="width: 70px;" class="badge badge-danger">{{ $historibulanini != null && $d->jam_out != null ?
                                            \Carbon\Carbon::parse($d->jam_out)->format('H:i') : '--:--' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($leaderboard as $d)
                            <li>
                                <div class="item">
                                @if(!empty($d->foto))
                                @php
                                $path = Storage::url('upload/karyawan/'.$d->foto);
                                @endphp
                                <img src="{{ url($path) }}" alt="avatar" style="object-fit: cover !important;" class="image">
                                @else
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                @endif
                                    <div class="in">
                                        <div>
                                            <b>{{ $d->nama_lengkap }}</b><br>
                                            <small class="text-muted">{{ $d->jabatan }}</small>
                                        </div>
                                        @if($d->jam_in == "00:00:00" && $d->status == "i")
                                        <span class="badge badge-primary w-25">Izin</span>
                                        @elseif($d->jam_in == "00:00:00" && $d->status == "s")
                                        <span class="badge badge-primary w-25">Sakit</span>
                                        @else
                                        <span style="width: 70px;" class="badge {{ $d->jam_in < "07:30" ? "bg-success" : "bg-danger" }}">{{ \Carbon\Carbon::parse($d->jam_in)->format('H:i') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
</div>
@endsection

@push('myscript')
<script>
var cek = "{{ $status->status }}";
$('#absen').click(function(e){
    if(cek == "1"){
        Swal.fire({
            title: 'Tidak Bisa Absen!',
            text: 'Anda Sudah Mengajukan Izin',
            icon: 'warning'
        });
    return false;
    }
    else if(cek == "2"){
        Swal.fire({
            title: 'Tidak Bisa Absen!',
            text: 'Anda Sudah Mengajukan Sakit',
            icon: 'warning'
        });
    return false;
    }
    else if(cek == "3"){
        Swal.fire({
            title: 'Tidak Bisa Absen!',
            text: 'Anda Sudah Melengkapi Absen Hari Ini',
            icon: 'warning'
        });
    return false;
    }
});
</script>
@endpush