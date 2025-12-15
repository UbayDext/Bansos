{{-- resources/views/disasters/show.blade.php --}}
@extends('layouts.app')

@section('title', $disaster->title . ' | Web Bansos')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100">
    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Breadcrumb / Back --}}
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('disasters.index') }}"
               class="inline-flex items-center text-sm text-slate-400 hover:text-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Kembali ke daftar bencana
            </a>
        </div>

        {{-- Header --}}
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 flex flex-col md:flex-row gap-6">
            {{-- Gambar --}}
            @if($disaster->img ?? false)
                <div class="md:w-1/3">
                    <img src="{{ asset('storage/'. $disaster->img) }}"
                         alt="{{ $disaster->title }}"
                         class="w-full h-56 md:h-full object-cover rounded-xl">
                </div>
            @endif

            {{-- Info utama --}}
            <div class="flex-1 space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-semibold">
                            {{ $disaster->title }}
                        </h1>
                        <p class="mt-1 text-sm text-slate-400">
                            Lokasi: {{ $disaster->location ?? '-' }}
                        </p>
                    </div>

                    {{-- Status --}}
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                        @if($disaster->status === 'active') bg-emerald-500/10 text-emerald-300 border border-emerald-500/40
                        @elseif($disaster->status === 'draft') bg-yellow-500/10 text-yellow-300 border border-yellow-500/40
                        @else bg-slate-600/10 text-slate-300 border border-slate-500/40 @endif">
                        {{ strtoupper($disaster->status) }}
                    </span>
                </div>

                {{-- Target & tanggal --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-slate-400">Target Dana</p>
                        <p class="font-semibold">
                            Rp {{ number_format($disaster->target_amount, 0, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-400">Mulai</p>
                        <p class="font-semibold">
                            {{ optional($disaster->start_date)->format('d M Y') ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-400">Berakhir</p>
                        <p class="font-semibold">
                            {{ optional($disaster->end_date)->format('d M Y') ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Konten + Kalkulator --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- Deskripsi & Tautan sosial --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Deskripsi --}}
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 prose prose-invert max-w-none">
                    {!! nl2br(e($disaster->description)) !!}
                </div>

                {{-- Tautan Sosial --}}
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold mb-4">Tautan Sosial</h2>

                    <ul class="space-y-2 text-sm">
                        @if($disaster->instagram_url ?? false)
                            <li>
                                <span class="font-medium text-slate-300">INSTAGRAM:</span>
                                <a href="{{ $disaster->instagram_url }}" target="_blank"
                                   class="text-indigo-400 hover:text-indigo-300 break-all">
                                    {{ $disaster->instagram_url }}
                                </a>
                            </li>
                        @endif

                        {{-- Tambah sosial lain jika ada --}}
                          @if ($disaster->links->count())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-3">Tautan Sosial</h3>
                    <ul class="list-disc ms-5 space-y-1">
                        @foreach ($disaster->links as $l)
                            <li>
                                <span class="uppercase text-xs text-gray-500">{{ $l->platform }}</span>:
                                <a class="text-blue-600 hover:underline" href="{{ $l->url }}" target="_blank"
                                    rel="noopener">
                                    {{ $l->url }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
                    </ul>
                </div>
            </div>

            {{-- Kalkulator Kontribusi + tombol WA --}}
<div
    id="contribution-calculator"
    class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 space-y-4"
    x-data="{
        amount: '',
        target: {{ $disaster->target_amount }},
        get pct() {
            const a = parseInt(this.amount || 0);
            if (!this.target) return 0;
            return ((a / this.target) * 100) || 0;
        }
    }"
    data-disaster-title="{{ $disaster->title }}"
    data-whatsapp-admin="{{ config('bansos.whatsapp_admin') }}"
>
    <h2 class="text-lg font-semibold">Kalkulator Kontribusi</h2>

    <div class="space-y-2">
        <label class="block text-sm text-slate-300" for="contributionInput">
            Masukkan nominal kontribusi (Rp)
        </label>
        <input
            id="contributionInput"
            type="text"
            inputmode="numeric"
            pattern="[0-9]*"
            x-model="amount"
            x-on:input="
                $event.target.value = $event.target.value.replace(/[^0-9]/g, '');
                amount = $event.target.value;
            "
            class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-100
                   focus:outline-none focus:ring-2 focus:ring-indigo-500"
            placeholder="contoh: 100000"
        >
    </div>

    <p class="text-sm text-slate-300">
        Target:
        <span>Rp {{ number_format($disaster->target_amount, 0, ',', '.') }}</span>
    </p>

    <p class="text-sm text-slate-300">
        Kontribusi kamu ≈
        <span x-text="pct.toFixed(2)"></span>% dari kebutuhan.
    </p>

    <div class="pt-2">
        <a
            id="waButton"
            href="#"
            target="_blank"
            class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-4 py-2 text-sm
                   font-semibold text-white hover:bg-green-600
                   pointer-events-none opacity-60"
        >
            {{-- Icon WhatsApp --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.486 2 2 6.019 2 11.043c0 1.94.57 3.742 1.555 5.278L2 22l5.852-1.512A10.16 10.16 0 0 0 12 20.086C17.514 20.086 22 16.067 22 11.043 22 6.019 17.514 2 12 2zm0 16.95c-1.42 0-2.807-.38-4.02-1.1l-.288-.17-3.472.897.93-3.317-.188-.304A7.47 7.47 0 0 1 4.5 11.04C4.5 7.5 7.838 4.6 12 4.6c4.162 0 7.5 2.9 7.5 6.44 0 3.54-3.338 6.91-7.5 6.91z"/>
                <path d="M16.065 13.61c-.222-.111-1.313-.647-1.516-.72-.203-.074-.351-.111-.5.111-.148.222-.57.72-.698.868-.129.148-.259.167-.48.056-.222-.111-.936-.345-1.783-1.098-.659-.588-1.103-1.314-1.233-1.536-.129-.222-.014-.342.097-.453.1-.1.222-.259.333-.388.111-.129.148-.222.222-.37.074-.148.037-.278-.019-.389-.056-.111-.5-1.205-.686-1.65-.18-.434-.364-.376-.5-.382l-.428-.008c-.148 0-.389.056-.593.278-.203.222-.777.759-.777 1.852 0 1.093.796 2.149.907 2.295.111.148 1.566 2.39 3.797 3.352.531.229.946.365 1.27.467.534.17 1.02.146 1.405.089.429-.064 1.313-.537 1.499-1.056.185-.518.185-.962.129-1.056-.056-.093-.203-.148-.425-.259z"/>
            </svg>
            Hubungi Admin via WhatsApp
        </a>
        <p class="mt-1 text-xs text-slate-400">
            Klik tombol di atas untuk konfirmasi donasi via WhatsApp.
        </p>
    </div>

    <p class="mt-4 text-xs text-slate-500">
        Hanya kalkulator; tidak ada input/output pembayaran.
    </p>
</div>

        </div>
    </div>
</div>

{{-- Script khusus halaman ini --}}
<script src="{{ asset('js/donation-calculator.js') }}" defer></script>
@endsection
