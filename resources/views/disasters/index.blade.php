<x-app-layout>
    {{-- HERO SECTION --}}
    <section
    x-data="{
        current: 0,
        slides: [
            { src: '{{ asset('images/slide.svg') }}', title: 'STIT Hidayatunnajah Bekasi', desc: 'Kampus berbasis ma’had yang berkomitmen menyiapkan pendidik profesional.' },
            { src: '{{ asset('images/slider/slide-2.jpg') }}', title: 'Layanan Bansos & Zakat', desc: 'Memfasilitasi penyaluran bantuan bencana secara amanah dan transparan.' },
            { src: '{{ asset('images/slider/slide-3.jpg') }}', title: 'Kolaborasi Kebaikan', desc: 'Ajak keluarga, kerabat, dan sahabat untuk ikut berdonasi dan menyebarkan informasi.' },
        ],
        next() { this.current = (this.current + 1) % this.slides.length },
        prev() { this.current = (this.current - 1 + this.slides.length) % this.slides.length },
    }"
    class="relative w-full overflow-hidden bg-slate-900"
>
    {{-- TRACK SLIDER FULL WIDTH --}}
  <div class="relative w-full aspect-[16/9] overflow-hidden">
    <div
        class="flex h-full transition-transform duration-500 ease-out"
        :style="`transform: translateX(-${current * 100}%);`"
    >
        <template x-for="(slide, index) in slides" :key="index">
            <div class="w-full h-full flex-shrink-0 relative">
                <img
                    :src="slide.src"
                    class="absolute inset-0 w-full h-full object-cover object-center"
                >

                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                    {{-- CONTENT CENTERED --}}
                    <div class="absolute inset-0 flex flex-col justify-center px-6 md:px-16 lg:px-24">
                        <p class="text-xs sm:text-sm tracking-[0.35em] text-emerald-300 uppercase mb-1">
                            STIT HIDAYATUNNAJAH • BEKASI
                        </p>

                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight"
                            x-text="slide.title"></h1>

                        <p class="mt-2 text-white/80 max-w-xl"
                           x-text="slide.desc"></p>

                        <div class="mt-4">
                            <a href="#daftar-bencana"
                               class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-slate-900 font-semibold rounded-lg">
                                Lihat Daftar Bencana
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- BUTTONS --}}
        <button
            @click="prev"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white rounded-full p-2"
        >
            ‹
        </button>

        <button
            @click="next"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white rounded-full p-2"
        >
            ›
        </button>

        {{-- DOTS --}}
        <div class="absolute bottom-5 w-full flex justify-center gap-2">
            <template x-for="(slide, index) in slides" :key="'dot-'+index">
                <button
                    @click="current = index"
                    class="w-3 h-3 rounded-full border border-white/70"
                    :class="current === index ? 'bg-white' : 'bg-white/10'"
                ></button>
            </template>
        </div>
    </div>
</section>



    {{-- SECTION LIST DATA BENCANA --}}
    <section id="daftar-bencana" class="py-8 sm:py-10 bg-slate-950">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search (client-side) --}}
            <div class="mb-4">
                <input
                    id="search-disaster"
                    type="text"
                    placeholder="Cari judul..."
                    class="border border-slate-700/80 bg-slate-900/60 text-slate-100 rounded px-3 py-2 w-full sm:w-80 focus:outline-none focus:ring-1 focus:ring-emerald-500"
                    autocomplete="off"
                >
            </div>

            @php
                $user = auth()->user();
            @endphp

            <div class="flex items-center justify-between mb-4 gap-3">
                <h2 class="text-xl font-semibold text-white">
                    Daftar Bencana Saat Ini
                </h2>

                {{-- Tombol admin --}}
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('disasters.create') }}"
                           class="hidden sm:inline-flex items-center px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 text-sm">
                            + Tambah Bencana
                        </a>
                    @endif
                @endauth

                {{-- Tombol partner --}}
                @if($user && $user->isPartner())
                    <div class="flex gap-2">
                        <a href="{{ route('disasters.create') }}"
                           class="px-3 py-2 rounded-md bg-blue-600 text-white text-xs sm:text-sm hover:bg-blue-700">
                            + Posting Bencana
                        </a>
                        <a href="{{ route('disasters.my') }}"
                           class="px-3 py-2 rounded-md bg-gray-700 text-gray-100 text-xs sm:text-sm hover:bg-gray-600">
                            Bencana Saya
                        </a>
                    </div>
                @endif
            </div>

            <div
                class="
                    relative
                    overflow-hidden
                    sm:rounded-3xl
                    p-6
                    bg-slate-900/40
                    border border-white/10
                    shadow-xl shadow-black/40
                    backdrop-blur-lg
                    supports-[backdrop-filter]:bg-slate-900/30
                    supports-[backdrop-filter]:backdrop-blur-xl
                "
            >
                @if($disasters->count())
                    <div id="disaster-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($disasters as $d)
                            @php
                                $collected = $d->collected_amount ?? 0;
                                $target    = max(1, (int) $d->target_amount);
                                $progress  = $d->progress;
                            @endphp

                            <div
                                class="
                                    disaster-card
                                    group
                                    flex flex-col
                                    overflow-hidden
                                    rounded-xl
                                    border border-slate-700/70
                                    bg-slate-900/70
                                    shadow-lg shadow-black/40
                                    transition
                                    hover:shadow-2xl hover:shadow-black/80
                                    hover:border-emerald-400/70
                                "
                                data-title="{{ strtolower($d->title) }}"
                            >
                                {{-- Gambar + badge status --}}
                                <a href="{{ route('disasters.show', $d) }}" class="block">
                                    <div class="relative">
                                        <img
                                            src="{{ asset('storage/'.$d->img) }}"
                                            alt="{{ $d->title }}"
                                            class="w-full h-40 object-cover"
                                        >

                                        @auth
                                            @if(auth()->user()->isAdmin() || auth()->user()->isPartner())
                                                <span class="
                                                    absolute left-3 top-3
                                                    inline-flex items-center
                                                    rounded-full
                                                    px-3 py-1 text-[11px] font-semibold
                                                    border
                                                    @if($d->status === 'active')
                                                        bg-emerald-500/10 text-emerald-300 border-emerald-500/40
                                                    @elseif($d->status === 'draft')
                                                        bg-yellow-500/10 text-yellow-300 border-yellow-500/40
                                                    @else
                                                        bg-slate-600/10 text-slate-300 border-slate-500/40
                                                    @endif
                                                ">
                                                    {{ strtoupper($d->status) }}
                                                </span>
                                            @endif
                                        @endauth
                                    </div>
                                </a>

                                {{-- Konten --}}
                                <div class="p-4 flex flex-col gap-3 flex-1">
                                    <div class="space-y-1">
                                        <h3 class="font-semibold text-lg text-gray-100 line-clamp-2">
                                            {{ $d->title }}
                                        </h3>

                                        @if(!empty($d->location))
                                            <p class="text-xs text-slate-300/80 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M10 2a5 5 0 00-5 5c0 3.53 4.06 7.71 4.57 8.21a.75.75 0 001.06 0C10.94 14.71 15 10.53 15 7a5 5 0 00-5-5zm0 3a2 2 0 100 4 2 2 0 000-4z"
                                                          clip-rule="evenodd" />
                                                </svg>
                                                <span>{{ $d->location }}</span>
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Target & progress --}}
                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between text-xs text-slate-200">
                                            <span>Target</span>
                                            <span class="font-semibold">
                                                Rp {{ number_format($d->target_amount, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="flex items-center justify-between text-[11px] text-slate-400">
                                            <span>Terkumpul</span>
                                            <span>
                                                Rp {{ number_format($collected, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="mt-2">
                                            <div class="h-2 w-full rounded-full bg-slate-700/80 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full bg-emerald-500 transition-all duration-300"
                                                    style="width: {{ $progress }}%;"
                                                ></div>
                                            </div>
                                            <div class="mt-1 text-right text-[11px] text-slate-400">
                                                {{ $progress }}%
                                            </div>
                                        </div>
                                    </div>

                                    {{-- CTA + tombol admin --}}
                                    <div class="mt-2 flex items-center justify-between">
                                        <a
                                            href="{{ route('disasters.show', $d) }}"
                                            class="text-xs font-medium text-emerald-300 hover:text-emerald-200"
                                        >
                                            Lihat detail &rarr;
                                        </a>

                                        @auth
                                            @if(auth()->user()->isAdmin())
                                                <a
                                                    href="{{ route('disasters.edit', $d) }}"
                                                    class="inline-flex items-center px-2.5 py-1 text-[11px] rounded bg-indigo-600 text-white hover:bg-indigo-700"
                                                >
                                                    Kelola / Edit
                                                </a>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <p id="disaster-empty-msg" class="text-gray-500 mt-4 hidden">
                        Pencarian tidak ditemukan.
                    </p>

                    <div class="mt-6">
                        {{ $disasters->withQueryString()->links() }}
                    </div>
                @else
                    <p class="text-gray-500">Belum ada data.</p>
                @endif
            </div>
        </div>

        @include('disasters.search_script')
    </section>
</x-app-layout>
