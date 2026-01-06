<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Kelola Jadwal Pelajaran (D.7)') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('tu.schedules.index') }}" class="flex gap-2">
                    <select name="kelas" class="border-gray-300 rounded shadow-sm text-sm"
                        onchange="this.form.submit()">
                        <option value="">-- Semua Kelas --</option>
                        @foreach ($classrooms as $c)
                            <option value="{{ $c->id_kelas }}"
                                {{ request('kelas') == $c->id_kelas ? 'selected' : '' }}>
                                {{ $c->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <a href="{{ route('tu.schedules.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                    + Buat Jadwal
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full border-collapse w-full">
                    <thead>
                        <tr class="bg-slate-100 text-left uppercase text-sm font-semibold text-slate-600">
                            <th class="p-3">Hari & Jam</th>
                            <th class="p-3">Kelas</th>
                            <th class="p-3">Mata Pelajaran</th>
                            <th class="p-3">Guru Pengampu</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @forelse($schedules as $s)
                            <tr class="border-b hover:bg-slate-50">
                                <td class="p-3 font-bold text-blue-600">
                                    {{ $s->hari }} <br>
                                    <span class="text-xs text-gray-500 font-normal">{{ substr($s->jam_mulai, 0, 5) }} -
                                        {{ substr($s->jam_selesai, 0, 5) }}</span>
                                </td>
                                <td class="p-3"><span
                                        class="bg-gray-200 px-2 py-1 rounded font-bold">{{ $s->classroom->nama_kelas }}</span>
                                </td>
                                <td class="p-3 font-medium">{{ $s->subject->nama_mapel }}</td>
                                <td class="p-3">{{ $s->teacher->nama_guru }}</td>
                                <td class="p-3 text-center flex justify-center gap-2">
                                    <a href="{{ route('tu.schedules.edit', $s->id_jadwal) }}"
                                        class="text-yellow-600"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('tu.schedules.destroy', $s->id_jadwal) }}" method="POST"
                                        onsubmit="return confirm('Hapus jadwal ini?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center">Belum ada jadwal. Silakan pilih kelas atau
                                    tambah jadwal baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
