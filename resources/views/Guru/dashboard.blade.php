<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-blue-600 rounded-lg shadow-lg p-6 mb-6 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold">Selamat Datang, {{ $teacherName }}! 👋</h3>
                    <p class="mt-2 text-blue-100">Berikut adalah jadwal mengajar Anda minggu ini.</p>
                </div>
                <div class="hidden md:block text-4xl opacity-50">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>

            @if (isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $error }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">
                        <i class="fa-solid fa-calendar-days mr-2"></i>Jadwal Mengajar
                    </h4>

                    @if ($schedules->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            <i class="fa-regular fa-calendar-xmark text-4xl mb-2"></i>
                            <p>Anda belum memiliki jadwal mengajar saat ini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Hari</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Jam</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Kelas</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Mata Pelajaran</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                    @foreach ($schedules as $s)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">
                                                {{ $s->hari }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-blue-600 font-medium">
                                                {{ substr($s->jam_mulai, 0, 5) }} - {{ substr($s->jam_selesai, 0, 5) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 font-semibold text-xs">
                                                    {{ $s->classroom->nama_kelas }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                                {{ $s->subject->nama_mapel }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <a href="{{ route('guru.grades.create', $s->id_jadwal) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition shadow-sm">
                                                    <i class="fa-solid fa-pen-to-square mr-1.5"></i> Input Nilai
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
