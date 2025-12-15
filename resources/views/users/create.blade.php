<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Tambah User Baru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 dark:bg-gray-800 shadow-lg sm:rounded-lg p-6">
                <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm text-gray-200">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="mt-1 w-full border rounded px-3 py-2 bg-gray-900 text-gray-100">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-200">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="mt-1 w-full border rounded px-3 py-2 bg-gray-900 text-gray-100">
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-200">Password</label>
                        <input type="password" name="password"
                               class="mt-1 w-full border rounded px-3 py-2 bg-gray-900 text-gray-100">
                        @error('password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-200">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="mt-1 w-full border rounded px-3 py-2 bg-gray-900 text-gray-100">
                    </div>

                    <div class="mt-4">
                        <h3 class="font-semibold mb-2 text-gray-100 text-sm">Role User</h3>
                        <div class="space-y-2">
                            @foreach($roles as $role)
                                <label class="flex items-center gap-2 text-sm text-gray-100">
                                    <input type="checkbox"
                                           name="roles[]"
                                           value="{{ $role->name }}"
                                           @checked( in_array($role->name, (array)old('roles', [])) )
                                    >
                                    <span>{{ $role->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('roles')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2 mt-4">
                        <x-primary-button type="submit">
                            Simpan
                        </x-primary-button>
                        <a href="{{ route('users.index') }}"
                           class="px-4 py-2 border rounded text-sm text-gray-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
