<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Buat Postingan Bencana</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('disasters.store') }}" enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm">Judul</label>
                    <input name="title" value="{{ old('title') }}" class="border rounded px-3 py-2 w-full">
                    @error('title')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm">Gambar</label>
                    <input type="file" name="img" accept="image/*" class="border rounded px-3 py-2 w-full">
                    @error('img')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm">Deskripsi</label>
                    <textarea name="description" rows="5" class="border rounded px-3 py-2 w-full">{{ old('description') }}</textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm">Target (Rp)</label>
                        <input name="target_amount" type="number" min="0"
                            value="{{ old('target_amount', 200000) }}" class="border rounded px-3 py-2 w-full">
                    </div>
                    <div>
                        <label class="block text-sm">Start date</label>
                        <input type="date" name="start_date" class="form-control ..."
                            value="{{ old('start_date', optional($disaster->start_date ?? null)->format('Y-m-d')) }}">
                    </div>
                    <div>
                        <label class="block text-sm">End date</label>
                        <input type="date" name="end_date" class="form-control ..."
                            value="{{ old('end_date', optional($disaster->end_date ?? null)->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="flex gap-2">
                    <x-primary-button>Simpan Draft</x-primary-button>
                    <a href="{{ route('disasters.index') }}" class="px-4 py-2 border rounded">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
