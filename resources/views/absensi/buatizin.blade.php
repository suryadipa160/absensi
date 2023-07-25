@extends('layouts.absensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 430px !important;
    }
    .datepicker-date-display{
        background-color: #1e74fd !important;
    }
</style>
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin / Sakit</div>
    <div class="right"></div>
</div>
@endsection
@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <form method="POST" action="/absensi/storeizin" id="frmizin">
            @csrf
            <div class="form-group">
                <input type="text" name="tgl_izin" value="{{ old('tgl_izin') }}" id="tgl_izin" class="form-control datepicker" placeholder="Tanggal">
            </div>
            <div class="form-group">
                <select name="status" id="status" class="form-control">
                    <option value="">Status</option>
                    <option value="i" @if(old('status') == "i") selected @endif>Izin</option>
                    <option value="s" @if(old('status') == "s") selected @endif>Sakit</option>
                </select>
            </div>
            <div class="form-group">
                <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan">{{ old('keterangan') }}</textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100 confirm">Kirim</button>
            </div>
    </div>
</div>
@error('tgl_izin')
<div class="alert alert-outline-danger">
    <p>{{ $message }}</p>
</div>
@enderror
@endsection
@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

    $(document).ready(function() {
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd"    
    });
    $('#tgl_izin').change(function(e){
        var tgl_izin = $(this).val();
        $.ajax({
            type: 'POST'
            , url: '/absensi/cektanggal'
            , data: {
                _token: '{{ csrf_token() }}'
                , tgl_izin: tgl_izin
            }
            , cache: false
            , success: function(respond){
                if(respond == 1) {
                    Swal.fire({
                        title:'Oops!'
                        , text: 'Anda Sudah Melakukan Pengajuan Izin Atau Sakit Pada Tanggal Tersebut!'
                        , icon: 'warning'
                    }).then((result)=>{
                        $('#tgl_izin').val('');
                    })
                }
            }
        });
    });
    $('.confirm').click(function(e) {
            e.preventDefault();
            var tgl_izin = $('#tgl_izin').val();
            var status = $('#status').val();
            var keterangan = $('#keterangan').val();
            if (tgl_izin == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Tanggal Masih Kosong!',
                    icon: 'warning'
                });
                return false;
            } else if (status == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Status Belum Dipilih!',
                    icon: 'warning'
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Keterangan Masih Kosong!',
                    icon: 'warning'
                });
                return false;
            } else {
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Apa Anda Yakin?',
                    text: "Pastikan Form Sudah Diisi Dengan Benar!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ajukan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
            }     
    });
});

</script>
@endpush