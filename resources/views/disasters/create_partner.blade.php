<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100">
            Tambah Bencana (Partner)
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-lg sm:rounded-lg p-6">
                <form method="POST" action="{{ route('disasters.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm text-gray-200">Judul Bencana</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="mt-1 w-full border rounded px-3 py-2 bg-gray-900 text-gray-100">
                        @error('title')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-200">Gambar</label>
                        <input type="file" name="img"
                               class="mt-1 w-full text-sm text-gray-100">
                        @error('img')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-200">Deskripsi</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 w-full border rounded px-3 py-2 bg-gray-900 text-gray-100">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-200">Target Dana (Rp)</label>
                        <input type="number" name="target_amount" value="{{ old('target_amount') }}"
                               class="mt-1 w-full border rounded px-3 py-2 bg-gray-900 text-gray-100">
                        @error('target_amount')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-200">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-900 text-gray-100">
                            @error('start_date')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-200">Tanggal Selesai</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                   class="mt-1 w-full border rounded px-3 py-2 bg-gray-900 text-gray-100">
                            @error('end_date')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- TIDAK ADA field status di sini, partner selalu draft saat create --}}

                    <div class="flex gap-2 mt-4">
                        <x-primary-button type="submit">
                            Simpan Draft
                        </x-primary-button>
                        <a href="{{ route('disasters.my') }}"
                           class="px-4 py-2 border rounded text-sm text-gray-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
