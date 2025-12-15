<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100">
            Bencana Saya
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex items-center justify-between">
                <form method="GET" class="w-full max-w-md">
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari judul..."
                           class="w-full px-3 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700">
                </form>

                <form method="GET" class="ml-4">
                    <select name="status"
                            class="px-3 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700"
                            onchange="this.form.submit()">
                        <option value="">Semua status</option>
                        <option value="draft"  @selected(request('status')=='draft')>Draft</option>
                        <option value="active" @selected(request('status')=='active')>Active</option>
                        <option value="closed" @selected(request('status')=='closed')>Closed</option>
                    </select>
                </form>
            </div>

            @if($disasters->isEmpty())
                <div class="bg-gray-800 rounded-lg p-6 text-gray-300">
                    Belum ada bencana yang kamu buat.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($disasters as $disaster)
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow">
                            <img src="{{ asset('storage/'.$disaster->img) }}"
                                 alt="{{ $disaster->title }}"
                                 class="w-full h-40 object-cover">

                            <div class="p-4 space-y-2">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-100">
                                        {{ $disaster->title }}
                                    </h3>
                                    <span
                                        class="text-xs px-2 py-1 rounded
                                        @class([
                                            'bg-yellow-600/70' => $disaster->status === 'draft',
                                            'bg-emerald-600/70' => $disaster->status === 'active',
                                            'bg-gray-500/70' => $disaster->status === 'closed',
                                        ])">
                                        {{ strtoupper($disaster->status) }}
                                    </span>
                                </div>

                                <p class="text-sm text-gray-300">
                                    Target: Rp {{ number_format($disaster->target_amount,0,',','.') }}
                                </p>

                                <div class="flex gap-2 mt-3">
                                    <a href="{{ route('disasters.edit', $disaster) }}"
                                       class="px-3 py-1 text-xs rounded bg-blue-600 text-white hover:bg-blue-700">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('disasters.destroy', $disaster) }}"
                                          onsubmit="return confirm('Hapus bencana ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-xs rounded border border-red-500 text-red-400 hover:bg-red-600 hover:text-white">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $disasters->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
