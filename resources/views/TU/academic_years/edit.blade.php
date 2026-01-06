<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Tahun Ajaran') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('tu.academic_years.update', $academicYear->id_tahun) }}">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="tahun_ajaran" :value="__('Tahun Ajaran')" />
                        <x-text-input id="tahun_ajaran" class="block mt-1 w-full" type="text" name="tahun_ajaran"
                            :value="old('tahun_ajaran', $academicYear->tahun_ajaran)" required />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="semester" :value="__('Semester')" />
                        <select id="semester" name="semester"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="Ganjil" {{ $academicYear->semester == 'Ganjil' ? 'selected' : '' }}>Ganjil
                            </option>
                            <option value="Genap" {{ $academicYear->semester == 'Genap' ? 'selected' : '' }}>Genap
                            </option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('tu.academic_years.index') }}" class="mr-4 text-gray-600">Batal</a>
                        <x-primary-button>Update Data</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
