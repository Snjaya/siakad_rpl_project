<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Kelas') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('tu.classrooms.update', $classroom->id_kelas) }}">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="tingkat" :value="__('Tingkat Kelas')" />
                        <select id="tingkat" name="tingkat"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="10" {{ $classroom->tingkat == 10 ? 'selected' : '' }}>Kelas 10 (X)
                            </option>
                            <option value="11" {{ $classroom->tingkat == 11 ? 'selected' : '' }}>Kelas 11 (XI)
                            </option>
                            <option value="12" {{ $classroom->tingkat == 12 ? 'selected' : '' }}>Kelas 12 (XII)
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="nama_kelas" :value="__('Nama Kelas')" />
                        <x-text-input id="nama_kelas" class="block mt-1 w-full" type="text" name="nama_kelas"
                            value="{{ $classroom->nama_kelas }}" required />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="nip_teacher" :value="__('Wali Kelas')" />
                        <select id="nip_teacher" name="nip_teacher"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @foreach ($teachers as $guru)
                                <option value="{{ $guru->nip }}"
                                    {{ $classroom->nip_teacher == $guru->nip ? 'selected' : '' }}>
                                    {{ $guru->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('tu.classrooms.index') }}" class="mr-4 text-gray-600">Batal</a>
                        <x-primary-button>Update Kelas</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
