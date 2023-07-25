<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <title>F4</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
    #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 4px !important;
    }   
    @page { 
        size: legal; 
    }
    body{
        font-family: Arial, Helvetica, sans-serif;
    }

    #customers {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10px;
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
    text-align: center;
    background-color: #049ab5;
    color: white;
    }

  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="legal landscape">
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
    <h3 align="center">Laporan Rekap Absensi Periode Bulan {{ $namabulan[$bulan] }} Tahun {{ $tahun }}</h3>
    
    <table id="customers">
        <tr>
            <th rowspan="2" style="padding: 10px 0px 10px 0 !important; font-size: 12px;">NIK</th>
            <th rowspan="2" style="padding: 10px 0px 10px 0 !important; font-size: 12px;">Nama</th>
            <th colspan="31" style="padding: 10px 0px 10px 0 !important; font-size: 12px;">Tanggal</th>
            <th rowspan="2" style="padding: 10px 5px 10px 5px !important; font-size: 12px;">TH</th>
            <th rowspan="2" style="padding: 10px 5px 10px 5px !important; font-size: 12px;">TS</th>
            <th rowspan="2" style="padding: 10px 5px 10px 5px !important; font-size: 12px;">TI</th>
        </tr>
        <tr>
            <?php
                for($i=1; $i<= 31; $i++){
            ?>
            <th>{{ $i }}</th>
            <?php
                }
            ?>
        </tr>
        @foreach($rekap as $d)
        <tr>
            <td>{{ $d->nik }}</td>
            <td>{{ $d->nama_lengkap }}</td>
            <?php
                for($i=1; $i<= 31; $i++){
                    $tgl = "tgl".$i;
            ?>
            <td style="text-align: center;">
                @if ($d->$tgl == 1)
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" color="green" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M5 12l5 5l10 -10"></path>
                </svg>
                @elseif($d->$tgl == 2)
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-info" color="blue" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                    <path d="M11 14h1v4h1"></path>
                    <path d="M12 11h.01"></path>
                </svg>
                @elseif($d->$tgl == 3)
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-sick" color="orange" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 21a9 9 0 1 1 0 -18a9 9 0 0 1 0 18z"></path>
                    <path d="M9 10h-.01"></path>
                    <path d="M15 10h-.01"></path>
                    <path d="M8 16l1 -1l1.5 1l1.5 -1l1.5 1l1.5 -1l1 1"></path>
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" color="red" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M18 6l-12 12"></path>
                    <path d="M6 6l12 12"></path>
                </svg>
                @endif
            </td>
            <?php
                }
            ?>
            <td style="text-align: center;">{{ $d->totalhadir }}</td>
            <td style="text-align: center;">{{ $d->totalsakit }}</td>
            <td style="text-align: center;">{{ $d->totalizin }}</td>
        </tr>
        @endforeach
    </table>

  </section>

</body>

</html>