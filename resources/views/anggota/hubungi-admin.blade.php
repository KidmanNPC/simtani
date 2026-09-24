@extends('layouts.backend')
@section('title', 'Hubungi Admin')
@section('content')

<h2>Hubungi Admin</h2>
<p style="font-size:13px;color:var(--text-muted);margin:-8px 0 20px;">Punya pertanyaan atau butuh bantuan? Hubungi admin melalui WhatsApp atau email.</p>

<div class="contact-grid">
    @forelse($admins as $admin)
        <div class="contact-card">
            <div class="avatar">{{ strtoupper(substr($admin->nama_lengkap, 0, 2)) }}</div>
            <p class="contact-name">{{ $admin->nama_lengkap }}</p>
            <span class="badge">Admin</span>
            <div class="contact-actions">
                @if($admin->nomor_wa)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $admin->nomor_wa) }}" target="_blank" rel="noopener" class="btn-outline btn-contact">WhatsApp</a>
                @endif
                @if($admin->email)
                    <a href="mailto:{{ $admin->email }}" class="btn-outline btn-contact">Email</a>
                @endif
            </div>
        </div>
    @empty
        <p class="placeholder-note">Kontak admin belum tersedia.</p>
    @endforelse
</div>

@endsection
