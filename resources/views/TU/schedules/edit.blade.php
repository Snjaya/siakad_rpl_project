<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Jadwal Pelajaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">

                <form method="POST" action="{{ route('tu.schedules.update', $schedule->id_jadwal) }}">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <x-input-label for="id_kelas" :value="__('Kelas')" />
                            <select id="id_kelas" name="id_kelas"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($classrooms as $kelas)
                                    <option value="{{ $kelas->id_kelas }}"
                                        {{ $schedule->id_kelas == $kelas->id_kelas ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="hari" :value="__('Hari')" />
                            <select id="hari" name="hari"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                                    <option value="{{ $h }}" {{ $schedule->hari == $h ? 'selected' : '' }}>
                                        {{ $h }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <x-input-label for="id_mapel" :value="__('Mata Pelajaran')" />
                            <select id="id_mapel" name="id_mapel"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($subjects as $mapel)
                                    <option value="{{ $mapel->id_mapel }}"
                                        {{ $schedule->id_mapel == $mapel->id_mapel ? 'selected' : '' }}>
                                        {{ $mapel->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="nip_teacher" :value="__('Guru Pengampu')" />
                            <select id="nip_teacher" name="nip_teacher"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($teachers as $guru)
                                    <option value="{{ $guru->nip }}"
                                        {{ $schedule->nip_teacher == $guru->nip ? 'selected' : '' }}>
                                        {{ $guru->nama_guru }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6 bg-slate-50 p-4 rounded-lg border border-slate-200">
                        <div>
                            <x-input-label for="jam_mulai" :value="__('Jam Mulai')" />
                            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ $schedule->jam_mulai }}"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <x-input-label for="jam_selesai" :value="__('Jam Selesai')" />
                            <input type="time" id="jam_selesai" name="jam_selesai"
                                value="{{ $schedule->jam_selesai }}"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-end border-t pt-4">
                        <a href="{{ route('tu.schedules.index') }}" class="mr-4 text-sm text-gray-600">Batal</a>
                        <x-primary-button>Update Jadwal</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
