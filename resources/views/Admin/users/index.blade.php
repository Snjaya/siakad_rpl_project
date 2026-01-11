<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <i class="fa-solid fa-users-gear text-emerald-600"></i>
                    {{ __('Manajemen Akun Pengguna') }}
                </h2>
            </div>

        </div>
    </x-slot>
    <nav class="hidden md:block text-sm font-medium text-gray-500">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
                <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
            </li>
            <li class="text-emerald-600">Users</li>
        </ol>
    </nav>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @foreach (['success' => 'green', 'info' => 'blue', 'warning' => 'yellow', 'error' => 'red'] as $msg => $color)
                @if (session($msg))
                    <div x-data="{ show: true }" x-show="show" x-transition
                        class="mb-6 flex items-start p-4 rounded-lg bg-{{ $color }}-50 border-l-4 border-{{ $color }}-500 shadow-sm relative">
                        <i class="fa-solid fa-circle-info text-{{ $color }}-600 mt-0.5 mr-3"></i>
                        <div class="flex-1 text-sm font-medium text-{{ $color }}-800 leading-relaxed">
                            {{ session($msg) }}
                        </div>
                        <button @click="show = false"
                            class="text-{{ $color }}-400 hover:text-{{ $color }}-600 ml-3">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
            @endforeach

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">

                <div
                    class="p-5 border-b border-gray-100 bg-slate-50 flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4">

                    <form action="{{ route('admin.users.index') }}" method="GET"
                        class="flex flex-col md:flex-row gap-3 w-full lg:w-auto flex-1">

                        <div class="relative w-full md:w-80">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-4 py-2.5 border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition"
                                placeholder="Cari nama atau email...">
                        </div>

                        <div class="relative w-full md:w-48">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-filter text-gray-400"></i>
                            </div>
                            <select name="role" onchange="this.form.submit()"
                                class="block w-full pl-10 pr-8 py-2.5 border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition bg-white cursor-pointer">
                                <option value="">Semua Role</option>
                                <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="TU" {{ request('role') == 'TU' ? 'selected' : '' }}>Tata Usaha
                                </option>
                                <option value="Guru" {{ request('role') == 'Guru' ? 'selected' : '' }}>Guru</option>
                                <option value="Siswa" {{ request('role') == 'Siswa' ? 'selected' : '' }}>Siswa
                                </option>
                            </select>
                        </div>

                        <button type="submit"
                            class="md:hidden w-full bg-slate-200 text-slate-700 font-bold py-2.5 rounded-lg hover:bg-slate-300 transition">
                            Cari Data
                        </button>
                    </form>

                    <a href="{{ route('admin.users.create') }}"
                        class="inline-flex justify-center items-center px-5 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md whitespace-nowrap">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Akun
                    </a>
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider font-bold">
                            <tr>
                                <th class="p-4 border-b border-gray-200">Pengguna</th>
                                <th class="p-4 border-b border-gray-200">Role</th>
                                <th class="p-4 border-b border-gray-200">Email</th>
                                <th class="p-4 border-b border-gray-200 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($users as $user)
                                <tr class="hover:bg-emerald-50/20 transition duration-150">
                                    <td class="p-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold border border-slate-200">
                                                {{ strtoupper(substr($user->username, 0, 1)) }}
                                            </div>
                                            <span
                                                class="font-semibold text-gray-800 text-sm">{{ $user->username }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 whitespace-nowrap">
                                        @php
                                            $badges = [
                                                'Admin' => 'bg-red-50 text-red-700 ring-red-600/20',
                                                'TU' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                                                'Guru' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                                'Siswa' => 'bg-slate-50 text-slate-700 ring-slate-600/20',
                                            ];
                                            $class =
                                                $badges[$user->role] ?? 'bg-gray-50 text-gray-600 ring-gray-500/10';
                                        @endphp
                                        <span
                                            class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $class }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="p-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('admin.users.reset', $user) }}"
                                                class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition"
                                                title="Reset Password">
                                                <i class="fa-solid fa-key"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                    title="Hapus" onclick="return confirm('Yakin hapus akun ini?')">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-gray-400">
                                        <i class="fa-solid fa-filter-circle-xmark text-4xl mb-3"></i>
                                        <p class="font-medium">Data tidak ditemukan.</p>
                                        <p class="text-xs mt-1">Coba ubah kata kunci atau filter role.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden bg-slate-50 p-4 space-y-4">
                    @forelse ($users as $user)
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold border border-slate-200 shadow-sm">
                                        {{ strtoupper(substr($user->username, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-800">{{ $user->username }}</h4>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                                @php
                                    $badges = [
                                        'Admin' => 'bg-red-50 text-red-700 border-red-200',
                                        'TU' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'Guru' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'Siswa' => 'bg-slate-50 text-slate-700 border-slate-200',
                                    ];
                                    $class = $badges[$user->role] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                                @endphp
                                <span class="px-2 py-1 rounded text-[10px] font-bold border {{ $class }}">
                                    {{ $user->role }}
                                </span>
                            </div>

                            <div class="border-t border-gray-100 my-3"></div>

                            <div class="grid grid-cols-3 gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="flex items-center justify-center py-2 bg-blue-50 text-blue-700 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">
                                    <i class="fa-solid fa-pen mr-1.5"></i> Edit
                                </a>
                                <a href="{{ route('admin.users.reset', $user) }}"
                                    class="flex items-center justify-center py-2 bg-amber-50 text-amber-700 rounded-lg text-xs font-semibold hover:bg-amber-100 transition">
                                    <i class="fa-solid fa-key mr-1.5"></i> Reset
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    class="w-full">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full flex items-center justify-center py-2 bg-red-50 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-100 transition"
                                        onclick="return confirm('Hapus user ini?')">
                                        <i class="fa-solid fa-trash mr-1.5"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-400">
                            <i class="fa-solid fa-filter-circle-xmark text-4xl mb-3"></i>
                            <p class="font-medium">Data tidak ditemukan.</p>
                        </div>
                    @endforelse
                </div>

                <div
                    class="bg-gray-50 p-4 border-t border-gray-200 text-xs text-gray-500 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-2">
                    <span>Menampilkan <strong>{{ $users->count() }}</strong> hasil.</span>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
