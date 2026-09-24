@extends('layouts.backend')
@section('title', 'Presensi Saya')
@section('content')

<h2>Presensi Saya</h2>

<div class="table-scroll">
<table>
    <thead>
        <tr>
            <th>Kegiatan</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($penugasan as $assignment)
            @php
                $status = $assignment->presensi?->status;
                $badgeClass = in_array($status, ['hadir', 'selesai']) ? 'badge' : 'badge-warn';
            @endphp
            <tr>
                <td>{{ $assignment->jadwal->nama_kegiatan ?? '-' }}</td>
                <td>{{ $assignment->presensi?->waktu_check_in ? \Carbon\Carbon::parse($assignment->presensi->waktu_check_in)->format('d-m-Y H:i') : '-' }}</td>
                <td>{{ $assignment->presensi?->waktu_check_out ? \Carbon\Carbon::parse($assignment->presensi->waktu_check_out)->format('d-m-Y H:i') : '-' }}</td>
                <td>
                    @if($status)
                        <span class="{{ $badgeClass }}">{{ ucfirst($status) }}</span>
                    @else
                        <span style="font-size:12px;color:var(--text-muted)">Belum diisi</span>
                    @endif
                </td>
                <td>
                    @if(!$assignment->presensi)
                        <form method="post" action="{{ route('anggota.presensi.check-in', $assignment) }}">
                            @csrf
                            <button type="submit" class="btn-outline">Check-in</button>
                        </form>
                    @elseif(!$assignment->presensi->waktu_check_out)
                        <form method="post" action="{{ route('anggota.presensi.check-out', $assignment) }}">
                            @csrf
                            <button type="submit" class="btn-outline">Check-out</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada penugasan.</td></tr>
        @endforelse
    </tbody>
</table>
</div>

@endsection
