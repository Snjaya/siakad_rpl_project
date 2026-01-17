<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\AcademicYear;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Pakai locale Indonesia biar namanya real

        // 1. BUAT ROLE UTAMA (Admin & TU)
        User::create([
            'username' => 'admin',
            'email' => 'admin@smkmarhas.sch.id',
            'password' => Hash::make('password'),
            'role' => 'Admin'
        ]);

        User::create([
            'username' => 'tatausaha',
            'email' => 'tu@smkmarhas.sch.id',
            'password' => Hash::make('password'),
            'role' => 'TU'
        ]);

        // 2. TAHUN AJARAN (1 Aktif)
        AcademicYear::create(['tahun_ajaran' => '2023/2024', 'semester' => 'Genap', 'status' => 'Tidak Aktif']);
        AcademicYear::create(['tahun_ajaran' => '2024/2025', 'semester' => 'Ganjil', 'status' => 'Tidak Aktif']);
        $activeYear = AcademicYear::create(['tahun_ajaran' => '2024/2025', 'semester' => 'Genap', 'status' => 'Aktif']);

        // 3. BUAT 20 GURU & AKUNNYA
        $teacherIds = [];
        for ($i = 0; $i < 20; $i++) {
            $nip = $faker->unique()->numerify('19########');
            $user = User::create([
                'username' => $nip,
                'email' => $faker->unique()->email,
                'password' => Hash::make('guru123'),
                'role' => 'Guru'
            ]);

            // --- PERBAIKAN DI SINI ---
            $teacher = Teacher::create([
                'id_user' => $user->id,
                'nip' => $nip,
                'nama_guru' => $faker->title . ' ' . $faker->name . ', ' . $faker->randomElement(['S.Pd', 'M.Pd', 'S.Kom', 'M.T']),
                'email' => $user->email,
                'no_hp' => $faker->phoneNumber,
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'alamat' => $faker->address,
            ]);
            // -------------------------

            $teacherIds[] = $teacher->id;
        }

        // 4. BUAT MATA PELAJARAN (Realistis)
        $mapelList = [
            'Pendidikan Agama',
            'PPKn',
            'Bahasa Indonesia',
            'Matematika',
            'Sejarah Indonesia',
            'Bahasa Inggris',
            'Seni Budaya',
            'PJOK',
            'Fisika',
            'Kimia',
            'Simulasi Digital',
            'Dasar Program Keahlian',
            'Pemrograman Web',
            'Basis Data',
            'Pemrograman Berorientasi Objek'
        ];

        $subjectIds = [];
        foreach ($mapelList as $namaMapel) {
            $subject = Subject::create([
                'nama_mapel' => $namaMapel,
                'kkm' => 75
            ]);
            $subjectIds[] = $subject->id;
        }

        // 5. BUAT KELAS & SISWA
        $tingkats = ['10', '11', '12'];
        $jurusans = ['RPL', 'TKJ', 'TKR'];

        foreach ($tingkats as $tingkat) {
            foreach ($jurusans as $jurusan) {
                // Buat Kelas (Misal: 10 RPL 1)
                $namaKelas = "$tingkat $jurusan 1";
                $kelas = Classroom::create([
                    'nama_kelas' => $namaKelas,
                    'jurusan' => $jurusan,
                    'tingkat' => $tingkat,
                    'nip_teacher' => $faker->randomElement($teacherIds) // Random Wali Kelas
                ]);

                // --- BUAT 30 SISWA PER KELAS ---
                for ($j = 0; $j < 30; $j++) {
                    $nis = $faker->unique()->numerify('24####');
                    $userSiswa = User::create([
                        'username' => $nis,
                        'email' => $faker->unique()->userName . '@student.marhas.id',
                        'password' => Hash::make('siswa123'),
                        'role' => 'Siswa'
                    ]);

                    $siswa = Student::create([
                        'id_user' => $userSiswa->id,
                        'id_kelas' => $kelas->id,
                        'nis' => $nis,
                        'nama_siswa' => $faker->name,
                        'email' => $userSiswa->email,
                        'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                        'alamat' => $faker->address
                    ]);
                }

                // --- BUAT JADWAL PELAJARAN OTOMATIS UNTUK KELAS INI ---
                // Kita buat 5 mapel acak untuk kelas ini
                $randomSubjects = $faker->randomElements($subjectIds, 5);
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                $jamMulai = ['07:00', '09:00', '10:30', '13:00'];

                foreach ($randomSubjects as $idx => $subId) {
                    $jadwal = Schedule::create([
                        'id_kelas' => $kelas->id,
                        'id_mapel' => $subId,
                        'id_guru' => $faker->randomElement($teacherIds),
                        'hari' => $days[$idx % 5],
                        'jam_mulai' => $jamMulai[$idx % 4],
                        'jam_selesai' => date('H:i', strtotime($jamMulai[$idx % 4]) + 5400) // +90 menit
                    ]);

                    // --- BUAT NILAI DUMMY (Opsional, biar KHS gak kosong) ---
                    // Ambil 5 siswa acak dari kelas ini untuk dikasih nilai
                    $randomStudents = Student::where('id_kelas', $kelas->id)->inRandomOrder()->take(5)->get();
                    foreach ($randomStudents as $rs) {
                        $tugas = rand(60, 95);
                        $uts = rand(50, 90);
                        $uas = rand(50, 95);
                        $akhir = ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);

                        Grade::create([
                            'id_jadwal' => $jadwal->id,
                            'nis_siswa' => $rs->nis,
                            'tugas' => $tugas,
                            'uts' => $uts,
                            'uas' => $uas,
                            'nilai_akhir' => $akhir
                        ]);
                    }
                }
            }
        }
    }
}
