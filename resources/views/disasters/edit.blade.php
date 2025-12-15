<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Edit Bencana (Admin)
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm mb-1">Target Dana (Rp)</label>
                                <input type="number" name="target_amount"
                                       class="w-full rounded border-gray-600 bg-gray-900"
                                       value="{{ old('target_amount', $disaster->target_amount) }}">
                                @error('target_amount')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Dana Terkumpul (Rp)</label>
                                <input type="number" name="collected_amount"
                                       class="w-full rounded border-gray-600 bg-gray-900"
                                       value="{{ old('collected_amount', $disaster->collected_amount) }}">
                                @error('collected_amount')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm mb-1">Status</label>
                                <select name="status" class="w-full rounded border-gray-600 bg-gray-900">
                                    <option value="draft"  @selected(old('status', $disaster->status) === 'draft')>Draft</option>
                                    <option value="active" @selected(old('status', $disaster->status) === 'active')>Active</option>
                                    <option value="closed" @selected(old('status', $disaster->status) === 'closed')>Closed</option>
                                </select>
                                @error('status')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-sm mb-1">Gambar</label>
                                <input type="file" name="img" class="w-full text-sm">
                                @error('img')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror

                                @if($disaster->img)
                                    <img src="{{ asset('storage/'.$disaster->img) }}" class="mt-2 w-40 rounded" alt="">
                                @endif
                            </div>
                        </div>

                        {{-- FOOTER: tombol kembali, simpan, dan HAPUS --}}
                        <div class="flex items-center justify-between gap-4 mt-4">
                            {{-- Tombol Hapus (kiri) --}}
                            <form action="{{ route('disasters.destroy', $disaster) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus bencana ini? Tindakan ini tidak bisa dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-sm text-white">
                                    Hapus
                                </button>
                            </form>

                            {{-- Kembali + Simpan (kanan) --}}
                            <div class="flex gap-2">
                                <a href="{{ route('disasters.index') }}"
                                   class="px-4 py-2 rounded bg-gray-600 text-sm">
                                    Kembali
                                </a>
                                <button type="submit"
                                        class="px-4 py-2 rounded bg-emerald-600 hover:bg-emerald-700 text-sm text-white">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
