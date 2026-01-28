<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-users mr-2 text-emerald-600"></i>
            {{ __('Data Siswa Ajar') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
                <form method="GET" action="{{ route('guru.students.index') }}"
                    class="flex flex-col md:flex-row md:items-end gap-4">
                    <div class="flex-1">
                        <label for="id_kelas" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-filter text-emerald-500 mr-1"></i> Filter Kelas
                        </label>
                        <select name="id_kelas" id="id_kelas"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">-- Tampilkan Semua Kelas Ajar --</option>
                            @foreach ($classes as $kelas)
                                <option value="{{ $kelas->id }}"
                                    {{ request('id_kelas') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }} ({{ $kelas->jurusan }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 text-white font-bold rounded-lg shadow-md hover:bg-emerald-700 transition transform active:scale-95">
                        <i class="fa-solid fa-magnifying-glass mr-2"></i> Terapkan Filter
                    </button>

                    @if (request('id_kelas'))
                        <a href="{{ route('guru.students.index') }}"
                            class="px-6 py-2.5 bg-gray-100 text-gray-600 font-bold rounded-lg shadow-sm hover:bg-gray-200 transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white shadow-xl sm:rounded-xl overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead
                            class="bg-emerald-50 text-emerald-800 uppercase text-xs font-bold border-b border-emerald-100">
                            <tr>
                                <th class="p-4 w-12 text-center">No</th>
                                <th class="p-4">Identitas Siswa</th>
                                <th class="p-4">Kelas</th>
                                <th class="p-4">Kontak (WhatsApp)</th>
                                <th class="p-4">Alamat Domisili</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($students as $index => $siswa)
                                <tr class="hover:bg-yellow-50 transition duration-150">
                                    <td class="p-4 text-center text-gray-400 font-medium">
                                        {{ $students->firstItem() + $index }}
                                    </td>

                                    <td class="p-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg mr-3 border border-emerald-200 shadow-sm">
                                                {{ substr($siswa->nama_siswa, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800 text-base">{{ $siswa->nama_siswa }}
                                                </div>
                                                <div
                                                    class="text-xs text-gray-500 font-mono bg-gray-100 px-1.5 py-0.5 rounded inline-block mt-0.5">
                                                    NIS: {{ $siswa->nis }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        <span
                                            class="bg-white text-gray-800 text-xs font-bold px-3 py-1 rounded-full border border-gray-200 shadow-sm">
                                            {{ $siswa->kelas->nama_kelas }}
                                        </span>
                                    </td>

                                    <td class="p-4">
                                        @if ($siswa->no_hp)
                                            @php
                                                // Ubah 08xxx jadi 628xxx untuk link WA
                                                $hp = preg_replace(
                                                    '/^0/',
                                                    '62',
                                                    preg_replace('/[^0-9]/', '', $siswa->no_hp),
                                                );
                                            @endphp
                                            <a href="https://wa.me/{{ $hp }}" target="_blank"
                                                class="inline-flex items-center text-emerald-600 hover:text-emerald-800 font-bold bg-emerald-50 px-3 py-1 rounded-lg hover:bg-emerald-100 transition">
                                                <i class="fa-brands fa-whatsapp mr-2 text-lg"></i>
                                                {{ $siswa->no_hp }}
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs italic bg-gray-50 px-2 py-1 rounded">
                                                <i class="fa-solid fa-phone-slash mr-1"></i> Tidak ada
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-gray-600 max-w-xs truncate" title="{{ $siswa->alamat }}">
                                        @if ($siswa->alamat)
                                            <i class="fa-solid fa-location-dot text-gray-300 mr-1"></i>
                                            {{ Str::limit($siswa->alamat, 30) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-100 p-4 rounded-full mb-3">
                                                <i class="fa-solid fa-user-slash text-4xl text-gray-400"></i>
                                            </div>
                                            <p class="font-medium text-lg">Tidak ada data siswa ditemukan.</p>
                                            <p class="text-sm mt-1">Coba pilih kelas lain di filter.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100">
                    {{ $students->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
