<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Edit Bencana (Partner)
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 sm:rounded-lg p-6 text-gray-100">
                <form action="{{ route('disasters.update', $disaster) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm mb-1">Judul</label>
                            <input type="text" name="title" class="w-full rounded border-gray-600 bg-gray-900"
                                   value="{{ old('title', $disaster->title) }}">
                            @error('title')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm mb-1">Lokasi</label>
                            <input type="text" name="location" class="w-full rounded border-gray-600 bg-gray-900"
                                   value="{{ old('location', $disaster->location) }}">
                            @error('location')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm mb-1">Deskripsi</label>
                            <textarea name="description" rows="4"
                                      class="w-full rounded border-gray-600 bg-gray-900">{{ old('description', $disaster->description) }}</textarea>
                            @error('description')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm mb-1">Target Dana (Rp)</label>
                            <input type="number" name="target_amount"
                                   class="w-full rounded border-gray-600 bg-gray-900"
                                   value="{{ old('target_amount', $disaster->target_amount) }}">
                            @error('target_amount')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm mb-1">Gambar</label>
                            <input type="file" name="img" class="w-full text-sm">
                            @error('img')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror

                            @if($disaster->img)
                                <img src="{{ asset('storage/'.$disaster->img) }}" class="mt-2 w-40 rounded" alt="">
                            @endif
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <a href="{{ route('disasters.my') }}"
                               class="px-4 py-2 rounded bg-gray-600 text-sm">
                                Kembali
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 rounded bg-emerald-600 hover:bg-emerald-700 text-sm text-white">
                                Simpan Draft
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
