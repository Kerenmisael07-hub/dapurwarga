@php
    $avatarUser = $user ?? null;
    $avatarSize = $size ?? 'w-9 h-9';
    $avatarText = $textClass ?? 'text-xs';
    $avatarRing = $ring ?? 'border border-outline-variant';
    $avatarFallback = $fallback ?? 'bg-surface-container text-on-surface-variant';
    $showPhoto = $showPhoto ?? true;
@endphp

@if ($showPhoto && $avatarUser?->foto_profile)
    <img src="{{ $avatarUser->foto_profile }}" alt="{{ $avatarUser->nama_lapak ?: $avatarUser->name }}"
         class="{{ $avatarSize }} rounded-full object-cover shrink-0 {{ $avatarRing }} bg-surface-container">
@else
    <div class="{{ $avatarSize }} rounded-full {{ $avatarFallback }} font-bold {{ $avatarText }} flex items-center justify-center shrink-0 {{ $avatarRing }}"
         title="{{ $avatarUser?->nama_lapak ?: $avatarUser?->name }}">
        {{ $avatarUser?->initials ?? '?' }}
    </div>
@endif
