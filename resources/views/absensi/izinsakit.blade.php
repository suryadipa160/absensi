@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
          Data Izin / Sakit
        </h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
    <div class="container-xl">
      <div class="row">
        <div class="col-12">
          <form action="/absensi/izinsakit" method="GET" autocomplete="off">
            <div class="row">
              <div class="col-6">
                <div class="input-icon mb-3">
                  <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-code" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6"></path>
                    <path d="M16 3v4"></path>
                    <path d="M8 3v4"></path>
                    <path d="M4 11h16"></path>
                    <path d="M20 21l2 -2l-2 -2"></path>
                    <path d="M17 17l-2 2l2 2"></path>
                  </svg>
                  </span>
                  <input type="text" value="{{ Request('dari') }}" id="dari" name="dari" class="form-control" placeholder="Dari" autocomplete="off">
                </div>
              </div>
              <div class="col-6">
                <div class="input-icon mb-3">
                  <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-code" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6"></path>
                    <path d="M16 3v4"></path>
                    <path d="M8 3v4"></path>
                    <path d="M4 11h16"></path>
                    <path d="M20 21l2 -2l-2 -2"></path>
                    <path d="M17 17l-2 2l2 2"></path>
                  </svg>
                  </span>
                  <input type="text" value="{{ Request('sampai') }}" id="sampai" name="sampai" class="form-control" placeholder="Sampai" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="input-icon mb-3">
                  <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                    <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                    <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                    <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                    <path d="M5 11h1v2h-1z"></path>
                    <path d="M10 11l0 2"></path>
                    <path d="M14 11h1v2h-1z"></path>
                    <path d="M19 11l0 2"></path>
                  </svg>
                  </span>
                  <input type="text" value="{{ Request('nik') }}" id="nik" name="nik" class="form-control" placeholder="NIK" autocomplete="off">
                </div>
              </div>
              <div class="col-3">
                <div class="input-icon mb-3">
                  <span class="input-icon-addon">
                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                  </svg>
                  </span>
                  <input type="text" value="{{ Request('nama') }}" id="nama" name="nama" class="form-control" placeholder="Nama Pegawai" autocomplete="off">
                </div>
              </div>
              <div class="col-1" style="margin-right: 20px !important;">
                <div class="form-group">
                  <button class="btn btn-primary" type="submit">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                    <path d="M21 21l-6 -6"></path>
                  </svg> Cari Data
                  </button>
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  <a href="/absensi/izinsakit" class="btn btn-success">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-zoom-reset" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M21 21l-6 -6"></path>
                    <path d="M3.268 12.043a7.017 7.017 0 0 0 6.634 4.957a7.012 7.012 0 0 0 7.043 -6.131a7 7 0 0 0 -5.314 -7.672a7.021 7.021 0 0 0 -8.241 4.403"></path>
                    <path d="M3 4v4h4"></path>
                  </svg> Reset
                  </a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIK</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($izinsakit as $d)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d-m-Y',strtotime($d->tgl_izin)) }}</td>
                <td>{{ $d->nik }}</td>
                <td>{{ $d->nama_lengkap }}</td>
                <td>{{ $d->jabatan }}</td>
                <td>{{ $d->status == "i" ? "Izin" : "Sakit" }}</td>
                <td>{{ $d->keterangan }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{ $izinsakit->links('vendor.pagination.bootstrap-5') }}
        </div>
      </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
  $(function(){
    $("#dari, #sampai").datepicker({ 
            autoclose: true, 
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
  });
</script>
@endpush