@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
          Monitoring Absensi
        </h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path>
                                        <path d="M16 3v4"></path>
                                        <path d="M8 3v4"></path>
                                        <path d="M4 11h16"></path>
                                        <path d="M11 15h1"></path>
                                        <path d="M12 15v3"></path>
                                    </svg>
                                    </span>
                                    <input type="text" value="{{ date("Y-m-d") }}" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal Absensi" autocomplete="off">
                                </div>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table tablle-stripad table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama Pegawai</th>
                                            <th>Jabatan</th>
                                            <th>Jam Masuk</th>
                                            <th>Foto Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Foto Pulang</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="loadabsensi">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>

@endsection
@push('myscript')
<script>
    $(function () {
        $("#tanggal").datepicker({ 
            autoclose: true, 
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        function loadabsensi(){
            var tanggal = $("#tanggal").val();
            $.ajax({
                type: 'POST'
                , url: '/getabsensi'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , tanggal: tanggal
                }
                , cache: false
                , success: function(respond){
                    $("#loadabsensi").html(respond);
                }
            });
        }

        $("#tanggal").change(function(e) {
            loadabsensi();
        });

        loadabsensi();
    });
</script>
@endpush