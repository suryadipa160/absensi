<form action="/karyawan/{$karyawan->nik}/update" method="POST" id="frmPegawai" enctype="multipart/form-data">
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
                            <input type="text" readonly id="nik" name="nik" value="{{ $karyawan->nik }}" class="form-control" placeholder="NIK"></input>
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
                            <input type="text" id="nama" name="nama" value="{{ $karyawan->nama_lengkap }}" class="form-control" placeholder="Nama Lengkap"></input>
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
                            <input type="text" id="jabatan" name="jabatan" value="{{ $karyawan->jabatan }}" class="form-control" placeholder="Jabatan"></input>
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
                            <input type="text" id="no_hp" name="no_hp" value="{{ $karyawan->no_hp }}" class="form-control" placeholder="No Telepon"></input>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3">
                        <div class="form-label">Password</div>
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="Ya" name="password">
                                <span class="form-check-label">Reset</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="Tidak" name="password" checked="">
                                <span class="form-check-label">Tidak</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3">
                        <div class="form-label">Foto</div>
                        <input type="file" id="foto" name="foto" class="form-control">
                        <input type="hidden" name="old_foto" value="{{ $karyawan->foto }}">
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