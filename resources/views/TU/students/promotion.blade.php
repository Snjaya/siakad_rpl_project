<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            <i class="fa-solid fa-angles-up mr-2 text-emerald-600"></i> {{ __('Manajemen Kenaikan Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold text-gray-800">Proses Kenaikan Kelas Massal</h3>
                    <p class="text-sm text-gray-500">Pindahkan seluruh siswa dari satu kelas ke kelas lainnya secara
                        otomatis.</p>
                </div>

                {{-- Form dengan Fungsi Konfirmasi SweetAlert2 --}}
                <form action="{{ route('tu.students.promote') }}" method="POST" id="formPromotion">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        {{-- Kelas Asal --}}
                        <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                            <label class="block text-red-700 font-bold mb-2 text-sm uppercase">Dari Kelas
                                (Asal):</label>
                            <select name="from_class" required
                                class="w-full rounded-lg border-red-200 focus:ring-red-500 focus:border-red-500 shadow-sm">
                                <option value="">-- Pilih Kelas Asal --</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}">{{ $c->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Kelas Tujuan --}}
                        <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                            <label class="block text-emerald-700 font-bold mb-2 text-sm uppercase">Ke Kelas
                                (Tujuan):</label>
                            <select name="to_class" required
                                class="w-full rounded-lg border-emerald-200 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                <option value="">-- Pilih Kelas Tujuan --</option>
                                <option value="lulus" class="font-bold text-blue-600">ALUMNI / LULUS</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}">{{ $c->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="bg-yellow-50 p-4 rounded-lg mb-6 border border-yellow-200 flex items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-yellow-600 mt-1"></i>
                        <p class="text-xs text-yellow-700 leading-relaxed">
                            <strong>Peringatan Penting:</strong> Tindakan ini bersifat massal. Seluruh siswa yang
                            terdaftar di kelas asal akan dipindahkan ke kelas tujuan. Pastikan data sudah benar sebelum
                            memproses.
                        </p>
                    </div>

                    <button type="button" onclick="confirmPromotion()"
                        class="w-full py-4 bg-emerald-600 text-white font-bold rounded-xl shadow-lg hover:bg-emerald-700 transition flex items-center justify-center gap-2 transform active:scale-95">
                        <i class="fa-solid fa-rocket"></i> Proses Kenaikan Kelas Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Khusus Halaman Ini --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // 1. Alert Sukses/Error dari Laravel Session
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{!! session('success') !!}",
                    confirmButtonColor: '#10b981',
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{!! session('error') !!}",
                    confirmButtonColor: '#ef4444',
                });
            @endif

            // 2. Fungsi Konfirmasi Sebelum Submit
            function confirmPromotion() {
                const fromClass = document.getElementsByName('from_class')[0].value;
                const toClass = document.getElementsByName('to_class')[0].value;

                if (fromClass === "" || toClass === "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Silakan pilih kelas asal dan kelas tujuan terlebih dahulu.',
                        confirmButtonColor: '#f59e0b',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Kenaikan',
                    text: "Apakah Anda yakin ingin memindahkan seluruh siswa? Tindakan ini tidak dapat dibatalkan secara otomatis.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Proses!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('formPromotion').submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
