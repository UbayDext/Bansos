<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Kelola Role: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-gray-800 dark:bg-gray-800 shadow-lg sm:rounded-lg p-6">
                <div class="mb-4">
                    <p class="text-sm text-gray-300">
                        <span class="font-semibold">Nama:</span> {{ $user->name }}
                    </p>
                    <p class="text-sm text-gray-300">
                        <span class="font-semibold">Email:</span> {{ $user->email }}
                    </p>
                </div>

                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <h3 class="font-semibold mb-2 text-gray-100">Role User</h3>

                    <div class="space-y-2 mb-4">
                        @foreach($roles as $role)
                            <label class="flex items-center gap-2 text-sm text-gray-100">
                                <input type="checkbox"
                                       name="roles[]"
                                       value="{{ $role->name }}"
                                       @checked($user->roles->contains('name', $role->name))
                                >
                                <span>{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('roles')
                        <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                    @enderror

                    <div class="flex gap-2">
                        <x-primary-button type="submit">
                            Simpan
                        </x-primary-button>
                        <a href="{{ route('users.index') }}"
                           class="px-4 py-2 border rounded text-sm text-gray-200">
                            Kembali
                        </a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
