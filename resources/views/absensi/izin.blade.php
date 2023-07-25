@extends('layouts.absensi')
@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Data Izin / Sakit</div>
    <div class="right"></div>
</div>
@endsection
@section('content')
<div class="row" style="margin-top: 4rem">
    <div class="col">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col">
        @foreach($dataizin as $d)
        <ul class="listview image-listview">
            <li>
                <div class="item">
                <div class="in">
                    <div>
                        <b>{{ \Carbon\Carbon::parse($d->tgl_izin)->isoformat('dddd, D MMMM Y') }} ({{ $d->status=="s" ? "Sakit" : "Izin" }})</b><br>
                        <small class="text-muted">{{ $d->keterangan }}</small>
                    </div>
                    @if( $d->tgl_izin >= \Carbon\Carbon::now()->startOfWeek()->format("Y-m-d") && $d->tgl_izin <= \Carbon\Carbon::now()->endOfWeek()->format("Y-m-d"))
                    <a href="/absensi/editizin/{{$d->tgl_izin}}">
                        <span class="badge bg-warning"><ion-icon name="create-outline"></ion-icon> Edit</span>
                    </a>
                    @endif
                    </div>
                </div>
            </li>
        </ul>
        @endforeach
    </div>
</div>
<div class="fab-button bottom-right" style="margin-bottom:70px;">
    <a href="/absensi/buatizin" class="fab">
        <ion-icon name="add-outline"></ion-icon>
    </a>
</div>
@endsection