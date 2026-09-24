@extends('layouts.backend')
@section('title', 'Profil Saya')
@section('content')

<h2>Profil Saya</h2>

<div class="profile-layout">
    <div class="profile-card">
        <div class="avatar">{{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}</div>
        <p style="font-size:13px;font-weight:600;color:var(--text);margin:0 0 4px;">{{ $user->nama_lengkap }}</p>
        <span class="badge">{{ ucfirst($user->role) }}</span>
    </div>

    <form method="post" action="{{ route('anggota.profil.update') }}" class="form-page" style="flex:1;min-width:260px;">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="nama_lengkap">Nama</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="field">
            <label for="nomor_wa">Nomor WhatsApp</label>
            <input type="text" id="nomor_wa" name="nomor_wa" value="{{ old('nomor_wa', $user->nomor_wa) }}">
        </div>

        <div class="field">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat">{{ old('alamat', $user->alamat) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary" style="width:auto;padding:10px 24px;">Simpan</button>
        </div>
    </form>
</div>

@endsection
