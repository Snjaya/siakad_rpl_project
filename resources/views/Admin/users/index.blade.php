<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-users-gear mr-2 text-emerald-600"></i>
            {{ __('Kelola Akun Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @foreach (['success', 'error'] as $msg)
                @if (session($msg))
                    <div x-data="{ show: true }" x-show="show"
                        class="mb-4 p-4 rounded-lg shadow-sm border-l-4 flex justify-between items-center {{ $msg == 'success' ? 'bg-emerald-100 border-emerald-500 text-emerald-700' : 'bg-red-100 border-red-500 text-red-700' }}">
                        <div class="flex items-center gap-2">
                            <i
                                class="fa-solid {{ $msg == 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation' }}"></i>
                            <span>{{ session($msg) }}</span>
                        </div>
                        <button @click="show = false" class="opacity-50 hover:opacity-100"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif
            @endforeach

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">

                <div
                    class="p-6 border-b border-gray-100 bg-white flex flex-col lg:flex-row justify-between items-center gap-4">

                    <div class="text-gray-500 text-sm font-medium w-full lg:w-auto">
                        Total User: <span class="text-emerald-600 font-bold text-lg">{{ $users->total() }}</span>
                        @if (request('search'))
                            <span class="ml-2 text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">
                                Hasil pencarian: "{{ request('search') }}"
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">

                        <form action="{{ route('admin.users.index') }}" method="GET" class="relative w-full md:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full py-2 pl-10 pr-4 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition"
                                placeholder="Cari Username / Email...">
                        </form>

                        @if (request('search'))
                            <a href="{{ route('admin.users.index') }}"
                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition font-bold text-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </a>
                        @else
                            <a href="{{ route('admin.users.create') }}"
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-md hover:shadow-lg transition font-bold text-sm flex items-center justify-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-user-plus"></i> Tambah User
                            </a>
                        @endif
                    </div>
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold border-b border-gray-200">
                            <tr>
                                <th class="p-4 w-16 text-center">#</th>
                                <th class="p-4">Identitas Akun</th>
                                <th class="p-4 text-center">Role</th>
                                <th class="p-4 text-center">Terdaftar</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($users as $index => $user)
                                <tr class="hover:bg-emerald-50/30 transition duration-150">
                                    <td class="p-4 text-center text-gray-400 font-medium">
                                        {{ $users->firstItem() + $index }}
                                    </td>
                                    <td class="p-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-bold text-gray-800 text-base">{{ $user->username }}</span>
                                            <span class="text-xs text-gray-500 font-mono">{{ $user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        @php
                                            $badges = [
                                                'Admin' => 'bg-red-100 text-red-700 border-red-200',
                                                'TU' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'Guru' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'Siswa' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            ];
                                            $badgeClass = $badges[$user->role] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center text-gray-500 text-xs">
                                        {{ $user->created_at->format('d M Y') }}
                                        <div class="text-[10px] text-gray-400">{{ $user->created_at->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center gap-2">

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded bg-yellow-50 text-yellow-600 hover:bg-yellow-100 border border-yellow-200 transition shadow-sm"
                                                title="Edit Data">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            {{-- TOMBOL BARU: RESET PASSWORD --}}
                                            <a href="{{ route('admin.users.password', $user->id) }}"
                                                class="w-8 h-8 flex items-center justify-center rounded bg-purple-50 text-purple-600 hover:bg-purple-100 border border-purple-200 transition shadow-sm"
                                                title="Reset Password">
                                                <i class="fa-solid fa-key"></i>
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus user {{ $user->username }}?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center rounded bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 transition shadow-sm"
                                                    title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-user-slash text-4xl mb-3 text-gray-200"></i>
                                            <p class="font-medium">Data tidak ditemukan.</p>
                                            @if (request('search'))
                                                <p class="text-xs mt-1">Coba kata kunci lain atau <a
                                                        href="{{ route('admin.users.index') }}"
                                                        class="text-emerald-600 underline">Reset</a></p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden grid grid-cols-1 gap-3 p-4 bg-slate-50">
                    @forelse($users as $user)
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 relative">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $user->username }}</h4>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                                <span
                                    class="text-[10px] font-bold px-2 py-1 rounded border {{ $badges[$user->role] ?? 'bg-gray-100' }}">
                                    {{ $user->role }}
                                </span>
                            </div>

                            <div class="flex justify-end gap-2 mt-3 pt-3 border-t border-gray-50">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="flex-1 py-2 text-center rounded bg-yellow-50 text-yellow-700 text-sm font-semibold border border-yellow-200">Edit</a>

                                {{-- TOMBOL BARU: RESET PASSWORD --}}
                                <a href="{{ route('admin.users.password', $user->id) }}"
                                    class="flex-1 py-2 text-center rounded bg-purple-50 text-purple-700 text-sm font-semibold border border-purple-200 flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-key text-xs"></i> Reset
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    class="flex-1" onsubmit="return confirm('Hapus user?');">
                                    @csrf @method('DELETE')
                                    <button
                                        class="w-full py-2 text-center rounded bg-red-50 text-red-700 text-sm font-semibold border border-red-200">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-8 text-gray-500 bg-white rounded-lg border border-gray-200">
                            Tidak ada data.
                        </div>
                    @endforelse
                </div>

                <div class="p-4 border-t border-gray-100 bg-white">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
