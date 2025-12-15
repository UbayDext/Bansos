<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Profile</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="p-3 rounded bg-green-100 text-green-800 mb-4">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}"
                  class="bg-white dark:bg-gray-800 p-6 rounded shadow space-y-3">
                @csrf @method('PATCH')

                <div>
                    <label class="block text-sm">Name</label>
                    <input name="name" value="{{ old('name', $user->name) }}"
                           class="border rounded px-3 py-2 w-full">
                    @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm">Email</label>
                    <input name="email" value="{{ old('email', $user->email) }}"
                           class="border rounded px-3 py-2 w-full">
                    @error('email') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>

                <x-primary-button>Simpan</x-primary-button>
            </form>

            <form method="POST" action="{{ route('profile.destroy') }}"
                  class="bg-white dark:bg-gray-800 p-6 rounded shadow mt-6"
                  onsubmit="return confirm('Yakin hapus akun?');">
                @csrf @method('DELETE')
                <label class="block text-sm mb-2">Konfirmasi Password</label>
                <input name="password" type="password" class="border rounded px-3 py-2 w-full mb-3">
                @error('password') <div class="text-red-600 text-sm mb-3">{{ $message }}</div> @enderror
                <button class="px-4 py-2 border rounded text-red-600">Hapus Akun</button>
            </form>
        </div>
    </div>
</x-app-layout>
