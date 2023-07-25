@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
          Overview
        </div>
        <h2 class="page-title">
          Konfigurasi Lokasi Kantor
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                </div>
                <div>{{ Session::get('success') }}</div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
                </div>
                <div>{{ Session::get('error') }}</div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <form action="/konfigurasi/updatelokasikantor" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-google-maps" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 9.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0"></path>
                                            <path d="M6.428 12.494l7.314 -9.252"></path>
                                            <path d="M10.002 7.935l-2.937 -2.545"></path>
                                            <path d="M17.693 6.593l-8.336 9.979"></path>
                                            <path d="M17.591 6.376c.472 .907 .715 1.914 .709 2.935a7.263 7.263 0 0 1 -.72 3.18a19.085 19.085 0 0 1 -2.089 3c-.784 .933 -1.49 1.93 -2.11 2.98c-.314 .62 -.568 1.27 -.757 1.938c-.121 .36 -.277 .591 -.622 .591c-.315 0 -.463 -.136 -.626 -.593a10.595 10.595 0 0 0 -.779 -1.978a18.18 18.18 0 0 0 -1.423 -2.091c-.877 -1.184 -2.179 -2.535 -2.853 -4.071a7.077 7.077 0 0 1 -.621 -2.967a6.226 6.226 0 0 1 1.476 -4.055a6.25 6.25 0 0 1 4.811 -2.245a6.462 6.462 0 0 1 1.918 .284a6.255 6.255 0 0 1 3.686 3.092z"></path>
                                        </svg>
                                        </span>
                                        <input type="text" id="lokasi_kantor" name="lokasi_kantor" value="{{ $lok_kantor->lokasi_kantor }}" class="form-control" placeholder="Lokasi Kantor"></input>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-radar-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                            <path d="M15.51 15.56a5 5 0 1 0 -3.51 1.44"></path>
                                            <path d="M18.832 17.86a9 9 0 1 0 -6.832 3.14"></path>
                                            <path d="M12 12v9"></path>
                                        </svg>
                                        </span>
                                        <input type="text" id="radius" name="radius" value="{{ $lok_kantor->radius }}" class="form-control" placeholder="Radius">
                                        <span class="input-group-text">
                                            Meter
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                        </svg> Update
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection