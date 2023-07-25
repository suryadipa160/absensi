<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>A4</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
    @page { 
        size: A4; 
    }
    body{
        font-family: Arial, Helvetica, sans-serif;
    }

    #customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
    }

    #customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
    }

    .center{
        text-align: center;
    }

  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">
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

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">
    
    <table width="100%">
        <tr>
            <td>
                <img style="display: block; margin-left: auto; margin-right: auto;" src="{{ asset('assets/img/logo_judul.png') }}">
            </td>
        </tr>
    </table>
    <h3 align="center">Laporan Absensi Periode Bulan {{ $namabulan[$bulan] }} Tahun {{ $tahun }}</h3>
    <table>
        <tr>
            <td rowspan="5">
                @php
                    $path = Storage::url('upload/karyawan/'.$karyawan->foto);
                @endphp
                <img src="{{ url($path) }}" alt="" style="margin-right: 10px" width="100">
            </td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $karyawan->nik }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $karyawan->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $karyawan->jabatan }}</td>
        </tr>
        <tr>
            <td>No Telepon</td>
            <td>:</td>
            <td>{{ $karyawan->no_hp }}</td>
        </tr>
    </table>

    <table id="customers">
        <tr>
            <th>No</td>
            <th>Tanggal</td>
            <th>Jam Masuk</td>
            <th>Jam Pulang</td>
            <th>Keterangan</td>
        </tr>
        @foreach ($absensi as $d)
        @php
        $jam_terlambat = selisih('07:30:00', $d->jam_in)
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ \Carbon\Carbon::parse($d->tgl_absensi)->isoformat('D MMMM Y') }}</td>
                @if($d->id_izin != '' && $d->status == 'i')
                <td colspan="3" class="center">Izin</td>
                @elseif($d->id_izin != '' && $d->status == 's')
                <td colspan="3" class="center">Sakit</td>
                @else
                <td>{{  \Carbon\Carbon::parse($d->jam_in)->format('H:i') }}</td>
                <td>
                @if($d->jam_out == '')
                Tidak Absen
                @else
                {{  \Carbon\Carbon::parse($d->jam_out)->format('H:i') }}
                @endif
                </td>
                @if($d->jam_in > '07:30')
                <td>Terlambat {{ $jam_terlambat }}</td> 
                @else
                <td>Tepat Waktu</td>
                @endif
                @endif
            </td>
        </tr>
        @endforeach
    </table>
  </section>

</body>

</html>