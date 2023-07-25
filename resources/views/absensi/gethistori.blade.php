@if($histori->isEmpty())
<div class="alert alert-outline-warning">
    <p>Data Belum Ada!</p>
</div>
@endif
        <ul class="listview image-listview">
        @foreach($histori as $d)
            <li>
                <div class="item">
                    @if($d->jam_in == "00:00:00" && $d->status == "i")
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-info" style="margin-right: 15px;" color="blue" width="48" height="48" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                        <path d="M11 14h1v4h1"></path>
                        <path d="M12 11h.01"></path>
                    </svg>
                    <div class="in">
                        <div>
                            <b>{{ date("d-m-Y", strtotime($d->tgl_absensi)) }}</b><br>
                        </div>
                        <span class="badge badge-primary w-50">Izin</span>
                    </div>
                    @elseif($d->jam_in == "00:00:00" && $d->status == "s")
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-sick" style="margin-right: 15px;" color="orange" width="48" height="48" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 21a9 9 0 1 1 0 -18a9 9 0 0 1 0 18z"></path>
                        <path d="M9 10h-.01"></path>
                        <path d="M15 10h-.01"></path>
                        <path d="M8 16l1 -1l1.5 1l1.5 -1l1.5 1l1.5 -1l1 1"></path>
                    </svg>
                    <div class="in">
                        <div>
                            <b>{{ date("d-m-Y", strtotime($d->tgl_absensi)) }}</b><br>
                        </div>
                        <span class="badge badge-warning w-50">Sakit</span>
                    </div>
                    @else
                    @php
                    $path = Storage::url('upload/absensi/'.$d->foto_in);
                    @endphp
                    <img src="{{ url($path) }}" alt="image" class="imaged w48" style="margin-right: 10px;">
                    <div class="in">
                        <div>
                            <b>{{ date("d-m-Y", strtotime($d->tgl_absensi)) }}</b><br>
                        </div>
                        <span class="badge {{ $d->jam_in < '07:30' ? 'badge-success' : 'badge-danger' }}" style="width: 70px;">
                            {{ \Carbon\Carbon::parse($d->jam_in)->format('H:i') }}
                        </span>
                        <span class="badge badge-info" style="width: 70px;">{{ $histori != null && $d->jam_out != null ? \Carbon\Carbon::parse($d->jam_out)->format('H:i') : '--:--' }}</span>
                    </div>
                    @endif
                </div>
            </li>
        @endforeach
        </ul>