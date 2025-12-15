@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-100">
                Manajemen Role & Permission
            </h2>

            <p class="text-xs text-gray-400">
                User mewarisi permission dari role yang dimilikinya.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($roles as $role)
                <div class="bg-gray-800 shadow-lg rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-100">
                                Role: {{ $role->name }}
                            </h3>
                            <p class="text-xs text-gray-400">
                                Atur permission apa saja yang dimiliki role ini.
                            </p>
                        </div>

                        {{-- info jumlah permission --}}
                        <div class="text-xs text-gray-300">
                            {{ $role->permissions->count() }} permission aktif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('roles.permissions.update', $role) }}">
                        @csrf
                        @method('PUT')

                        @foreach($permissionsGrouped as $group => $permissions)
                            @php
                                $groupKey = $role->id.'-'.Str::slug($group ?? 'global');
                            @endphp

                            <div class="border border-gray-700 rounded-lg mb-4 overflow-hidden">
                                <div class="px-4 py-2 bg-gray-900/70 border-b border-gray-700 flex items-center justify-between">
                                    <span class="text-sm font-semibold text-gray-100">
                                        {{ $group ?? 'Global' }}
                                    </span>

                                    <button type="button"
                                            class="text-xs text-sky-400 hover:underline group-toggle"
                                            data-target="{{ $groupKey }}">
                                        Toggle semua
                                    </button>
                                </div>

                                <div class="p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3"
                                     id="{{ $groupKey }}">
                                    @foreach($permissions as $permission)
                                        <label class="inline-flex items-start gap-2 text-xs text-gray-100">
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $permission->name }}"
                                                   @checked($role->permissions->contains('name', $permission->name))
                                                   class="mt-0.5 rounded border-gray-500 bg-gray-900">
                                            <span>
                                                <span class="font-mono text-[11px] text-gray-400">
                                                    {{ $permission->name }}
                                                </span><br>
                                                <span class="text-[12px]">
                                                    {{ $permission->label ?? $permission->name }}
                                                </span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="flex justify-end">
                            <x-primary-button type="submit">
                                Simpan Permission Role
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="bg-gray-800 rounded-lg p-6 text-gray-300 text-sm">
                    Belum ada role yang terdaftar.
                </div>
            @endforelse
        </div>
    </div>

    {{-- simple JS untuk toggle per grup --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.group-toggle').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetId = this.dataset.target;
                    const container = document.getElementById(targetId);
                    if (!container) return;

                    const checkboxes = container.querySelectorAll('input[type="checkbox"]');
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

                    checkboxes.forEach(cb => cb.checked = !allChecked);
                });
            });
        });
    </script>
</x-app-layout>
