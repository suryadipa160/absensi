<?php
function selisih($jam_masuk, $jam_keluar)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ":" . round($sisamenit2);
        }
?>
@foreach($absensi as $d)
@php
    $foto_in = Storage::url('upload/absensi/'.$d->foto_in);
    $foto_out = Storage::url('upload/absensi/'.$d->foto_out);
@endphp
@if($d->id_izin == "")
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $d->nik }}</td>
    <td>{{ $d->nama_lengkap }}</td>
    <td>{{ $d->jabatan }}</td>
    <td>{{  \Carbon\Carbon::parse($d->jam_in)->format('H:i') }}</td>
    <td>
        <img src="{{ url($foto_in) }}" width="64px" alt="">
    </td>
    <td>{!! $d->jam_out != null ?  \Carbon\Carbon::parse($d->jam_out)->format('H:i') : '<span class="badge bg-danger">Belum Absen</span>' !!}</td>
    <td>
        @if($d->jam_out != null)
        <img src="{{ url($foto_out) }}" width="64px" alt="">
        @else
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hourglass" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M6.5 7h11"></path>
            <path d="M6.5 17h11"></path>
            <path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z"></path>
            <path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z"></path>
        </svg>
        @endif
    </td>
    <td>
        @if($d->jam_in >= '07:30')
        @php
        $jamterlambat = selisih('07:30:00', $d->jam_in);
        @endphp
        <span class="badge bg-danger">Terlambat {{ $jamterlambat }}</span>
        @else
        <span class="badge bg-success">Tepat Waktu</span>
        @endif
    </td>
</tr>
@elseif($d->status == "i")
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $d->nik }}</td>
    <td>{{ $d->nama_lengkap }}</td>
    <td>{{ $d->jabatan }}</td>
    <td colspan="5">
        <span class="badge bg-indigo w-100">Pegawai Sedang Izin</span>
    </td>
</tr>
@elseif($d->status == "s")
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $d->nik }}</td>
    <td>{{ $d->nama_lengkap }}</td>
    <td>{{ $d->jabatan }}</td>
    <td colspan="5">
        <span class="badge bg-yellow w-100">Pegawai Sedang Sakit</span>
    </td>
</tr>
@endif
@endforeach