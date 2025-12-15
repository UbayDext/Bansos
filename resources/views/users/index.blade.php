<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Manajemen User
            </h2>

            <a href="{{ route('users.create') }}"
               class="inline-flex items-center px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 text-sm">
                + Tambah User
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-gray-800 dark:bg-gray-800 shadow-lg sm:rounded-lg p-6">
                <table class="min-w-full text-sm text-gray-100">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left py-2">Nama</th>
                            <th class="text-left py-2">Email</th>
                            <th class="text-left py-2">Roles</th>
                            <th class="text-left py-2 w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-b border-gray-700/60">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2 text-gray-300">{{ $user->email }}</td>
                                <td class="py-2">
                                    @php $roleNames = $user->roles->pluck('name')->toArray(); @endphp

                                    @if(count($roleNames))
                                        <span class="inline-flex flex-wrap gap-1">
                                            @foreach($roleNames as $role)
                                                <span class="px-2 py-0.5 rounded text-xs bg-indigo-600/80">
                                                    {{ $role }}
                                                </span>
                                            @endforeach
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">
                                            - belum ada role -
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('users.edit',$user) }}"
                                           class="inline-flex items-center px-3 py-1 rounded text-xs bg-blue-600 hover:bg-blue-700 text-white">
                                            Kelola Role
                                        </a>

                                        {{-- Tombol hapus, cegah diri sendiri di sisi view juga --}}
                                        @if(auth()->id() !== $user->id)
                                            <form method="POST"
                                                  action="{{ route('users.destroy',$user) }}"
                                                  onsubmit="return confirm('Hapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 rounded text-xs border border-red-500 text-red-500 hover:bg-red-600 hover:text-white">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-400">
                                    Belum ada user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
