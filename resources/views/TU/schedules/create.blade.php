<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-calendar-plus mr-2 text-emerald-600"></i>
            {{ __('Buat Jadwal Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('tu.schedules.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                                <select name="hari"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 transition">
                                    <option value="">Pilih Hari...</option>
                                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                        <option value="{{ $hari }}">{{ $hari }}</option>
                                    @endforeach
                                </select>
                                @error('hari')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                                <select name="id_kelas"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 transition">
                                    <option value="">Pilih Kelas...</option>
                                    @foreach ($classrooms as $kelas)
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                @error('id_kelas')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                                <input type="time" name="jam_mulai"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                                <input type="time" name="jam_selesai"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                                <select name="id_mapel"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 transition">
                                    <option value="">Pilih Mapel...</option>
                                    @foreach ($subjects as $mapel)
                                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Guru Pengampu</label>
                                <select name="id_guru"
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 transition">
                                    <option value="">Pilih Guru...</option>
                                    @foreach ($teachers as $guru)
                                        <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('tu.schedules.index') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">Batal</a>
                            <button type="submit"
                                class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-bold hover:bg-emerald-700 transition">Simpan
                                Jadwal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
