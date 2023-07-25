@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
          Data Pegawai
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
                                <a href="#" class="btn btn-success" id="btnTambahPegawai">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                    <path d="M16 19h6"></path>
                                    <path d="M19 16v6"></path>
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                    </svg> Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="/karyawan" method="GET">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" 
                                                placeholder="Nama Pegawai" value="{{ Request('nama_lengkap') }}">
                                            </div>
                                        </div>   
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h1.5"></path>
                                                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                                <path d="M20.2 20.2l1.8 1.8"></path>
                                                </svg> Cari</button>
                                            </div>
                                        </div>                         
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
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
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>No. HP</th>
                                            <th>Foto</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($karyawan as $d)
                                        @php
                                        $path = Storage::url('upload/karyawan/'.$d->foto);
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration + $karyawan->firstitem() -1 }}</td>
                                            <td>{{ $d->nik }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->jabatan }}</td>
                                            <td>{{ $d->no_hp }}</td>
                                            <td>
                                                @if(empty($d->foto))
                                                <img src="{{ asset('assets/img/default.jpg') }}" class="avatar" alt="">
                                                @else
                                                <img src="{{ url($path) }}" class="avatar" alt="">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="#" class="edit btn btn-info btn-sm" style="margin-right: 10px" nik="{{ $d->nik }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        <path d="M16 5l3 3"></path>
                                                    </svg>
                                                </a>
                                                <form action="/karyawan/{{ $d->nik }}/delete" method="POST">
                                                    @csrf
                                                    <a class="btn btn-danger btn-sm delete-confirm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M4 7l16 0"></path>
                                                            <path d="M10 11l0 6"></path>
                                                            <path d="M14 11l0 6"></path>
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                        </svg>
                                                    </a>
                                                </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-InputPegawai" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Data Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/karyawan/store" method="POST" id="frmPegawai" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
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
                            <input type="text" id="nik" name="nik" value="" class="form-control" placeholder="NIK"></input>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                            </svg>
                            </span>
                            <input type="text" id="nama" name="nama" value="" class="form-control" placeholder="Nama Lengkap"></input>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hierarchy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M5 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M19 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M6.5 17.5l5.5 -4.5l5.5 4.5"></path>
                                <path d="M12 7l0 6"></path>
                            </svg>
                            </span>
                            <input type="text" id="jabatan" name="jabatan" value="" class="form-control" placeholder="Jabatan"></input>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                            </svg>
                            </span>
                            <input type="text" id="no_hp" name="no_hp" value="" class="form-control" placeholder="No Telepon"></input>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="mb-3">
                        <div class="form-label">Foto</div>
                        <input type="file" id="foto" name="foto" class="form-control">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 14l11 -11"></path>
                                <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                            </svg> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
</div>

    <div class="modal modal-blur fade" id="modal-EditPegawai" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Data Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="loadeditform">
            
          </div>
        </div>
      </div>
    </div>
@endsection
@push('myscript')
<script>
    $(function() {
        $("#btnTambahPegawai").click(function() {
            $("#modal-InputPegawai").modal("show");
        });

        $(".edit").click(function() {
            var nik = $(this).attr('nik');
            $.ajax({
                type : 'POST'
                , url: '/karyawan/edit'
                , cache: false
                , data: {
                    _token: "{{ csrf_token(); }}"
                    , nik: nik
                },
                success:function(respond){
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-EditPegawai").modal("show");
        });

        $(".delete-confirm").click(function(e) {
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: 'Apa Anda Yakin?',
                text: "Data akan terhapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus'
                }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                    'Deleted!',
                    'Data Berhasil Dihapus.',
                    'success'
                    )
                }
            })
        });

        $("#frmPegawai").submit(function() {
            var nik = $("#nik").val();
            var nama = $("#nama").val();
            var jabatan = $("#jabatan").val();
            var no_hp = $("#no_hp").val();
            if(nik == ""){
                Swal.fire({
                title: 'Warning!',
                text: 'NIK Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
                }).then((result) => {
                    $("#nik").focus();
                });
                return false;
            } else if(nama == ""){
                Swal.fire({
                title: 'Warning!',
                text: 'Nama Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
                }).then((result) => {
                    $("#nama").focus();
                });
                return false;
            } else if(jabatan == ""){
                Swal.fire({
                title: 'Warning!',
                text: 'Jabatan Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
                }).then((result) => {
                    $("#jabatan").focus();
                });
                return false;
            } else if(no_hp == ""){
                Swal.fire({
                title: 'Warning!',
                text: 'Nomor Telepon Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
                }).then((result) => {
                    $("#no_hp").focus();
                });
                return false;
            }
        });
    });
</script>
@endpush