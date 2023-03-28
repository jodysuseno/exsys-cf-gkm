<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BobotKompleksitas;
use App\Models\BobotGejala;
use App\Models\Gejala;
use App\Models\Pasien;
use App\Models\Penyakit;
use App\Models\User;
use App\Models\BasisPengetahuan;
use App\Models\BasisPengetahuanKompleksitas;
use App\Models\Kasus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //buat data user
        User::create([
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin123'),
            'nama' => 'admin',
            'nip' => '0123456789',
            'phone' => '085000888555',
            'role' => 'admin',
        ]);
        User::create([
            'email' => 'pakar@mail.com',
            'password' => bcrypt('pakar123'),
            'nama' => 'pakar',
            'nip' => '0123456790',
            'phone' => '085000888590',
            'role' => 'pakar',
        ]);
        User::create([
            'email' => 'perawat@mail.com',
            'password' => bcrypt('perawat123'),
            'nama' => 'perawat',
            'nip' => '0123456791',
            'phone' => '085000888591',
            'role' => 'perawat',
        ]);
        //buat data bobot kompleksitas
        BobotKompleksitas::create(['nama' => 'Riwayat Penyakit Kronis', 'bobot' => 3]);
        BobotKompleksitas::create(['nama' => 'Riwayat Keluarga Gangguan Kejiwaan', 'bobot' => 5]);
        BobotKompleksitas::create(['nama' => 'Riwayat Gangguan Kejiwaan Sebelumnya', 'bobot' => 5]);
        //buat data bobot gejala
        BobotGejala::create(['nama' => 'Gejala Biasa', 'bobot' => 1]);
        BobotGejala::create(['nama' => 'Gejala Sedang', 'bobot' => 3]);
        BobotGejala::create(['nama' => 'Gejaal Dominan', 'bobot' => 5]);
        //buat data penyakit
        Penyakit::create(['kode' => 'P1', 'nama' => 'Gangguan Depresi', 'definisi' => 'definisi penyakit', 'solusi' => 'solusi penyakit']);
        Penyakit::create(['kode' => 'P2', 'nama' => 'Gangguan Kecemasan', 'definisi' => 'definisi penyakit', 'solusi' => 'solusi penyakit']);
        Penyakit::create(['kode' => 'P3', 'nama' => 'Gangguan Somatoform', 'definisi' => 'definisi penyakit', 'solusi' => 'solusi penyakit']);
        Penyakit::create(['kode' => 'P4', 'nama' => 'Gangguan Neurotik', 'definisi' => 'definisi penyakit', 'solusi' => 'solusi penyakit']);
        //buat data gejala 
        Gejala::create(['kode' => 'G1', 'nama' => 'Sering merasakan sakit kepala']);
        Gejala::create(['kode' => 'G2', 'nama' => 'Sulit untuk tidur']);
        Gejala::create(['kode' => 'G3', 'nama' => 'Mudah merasa takut']);
        Gejala::create(['kode' => 'G4', 'nama' => 'Merasa tegang, cemas dan khawatir']);
        Gejala::create(['kode' => 'G5', 'nama' => 'Tangan sering bergemetar']);
        Gejala::create(['kode' => 'G6', 'nama' => 'Pencernaan terganggu atau merasa lebih buruk']);
        Gejala::create(['kode' => 'G7', 'nama' => 'Sulit untuk berpikir jernih']);
        Gejala::create(['kode' => 'G8', 'nama' => 'Merasa tidak Bahagia']);
        Gejala::create(['kode' => 'G9', 'nama' => 'Menangis lebih sering']);
        Gejala::create(['kode' => 'G10', 'nama' => 'Merasa sulit untuk menikmati sehari-hari']);
        Gejala::create(['kode' => 'G11', 'nama' => 'Sulit untuk mengambil keputusan']);
        Gejala::create(['kode' => 'G12', 'nama' => 'Pekerjaan sehari-hari merasa terganggu']);
        Gejala::create(['kode' => 'G13', 'nama' => 'Tidak mampu melakukan hal yang bermanfaat dalam hidup']);
        Gejala::create(['kode' => 'G14', 'nama' => 'Kehilangan minat pada berbagai hal']);
        Gejala::create(['kode' => 'G15', 'nama' => 'Merasa tidak berharga']);
        Gejala::create(['kode' => 'G16', 'nama' => 'Mempunyai pikiran untuk mengakhiri hidup']);
        Gejala::create(['kode' => 'G17', 'nama' => 'Merasa lelah sepanjang waktu']);
        Gejala::create(['kode' => 'G18', 'nama' => 'Mengalami rasa tidak enak perut']);
        Gejala::create(['kode' => 'G19', 'nama' => 'Terlalu banyak makan atau kurang nafsu makan']);
        Gejala::create(['kode' => 'G20', 'nama' => 'Bergerak atau berbicara sangat lambat sehingga orang lain memperhatikannya.']);
        //buat data pasien
        Pasien::create([
            'nomor_kartu_identitas' => '3514100102030001',
            'nama' => 'pasien 1',
            'umur' => '20',
            'phone' => '081234876098',
        ]);
        Pasien::create([
            'nomor_kartu_identitas' => '3514100102040001',
            'nama' => 'pasien 2',
            'umur' => '20',
            'phone' => '081234876098',
        ]);
        Pasien::create([
            'nomor_kartu_identitas' => '3514100102050001',
            'nama' => 'pasien 3',
            'umur' => '20',
            'phone' => '081234876098',
        ]);
        Pasien::create([
            'nomor_kartu_identitas' => '3514100102060001',
            'nama' => 'pasien 4',
            'umur' => '20',
            'phone' => '081234876098',
        ]);
        //buat kasus
        Kasus::create([
            'pasien_id' => 1,
            'user_id' => 3,
            'penyakit_id' => 1,
            'status' => 'reuse',
        ]);
        Kasus::create([
            'pasien_id' => 2,
            'user_id' => 3,
            'penyakit_id' => 2,
            'status' => 'reuse',
        ]);
        Kasus::create([
            'pasien_id' => 3,
            'user_id' => 3,
            'penyakit_id' => 3,
            'status' => 'reuse',
        ]);
        Kasus::create([
            'pasien_id' => 4,
            'user_id' => 3,
            'penyakit_id' => 4,
            'status' => 'reuse',
        ]);
        //buat basis pengetahuan
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 2, 'bobot_gejala_id' => 2]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 3, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 8, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 9, 'bobot_gejala_id' => 2]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 10, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 11, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 12, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 14, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 15, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 16, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 17, 'bobot_gejala_id' => 2]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 18, 'bobot_gejala_id' => 2]);
        BasisPengetahuan::create(['kasus_id' => 1, 'gejala_id' => 20, 'bobot_gejala_id' => 1]);
        BasisPengetahuan::create(['kasus_id' => 2, 'gejala_id' => 4, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 2, 'gejala_id' => 5, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 2, 'gejala_id' => 6, 'bobot_gejala_id' => 2]);
        BasisPengetahuan::create(['kasus_id' => 2, 'gejala_id' => 16, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 3, 'gejala_id' => 1, 'bobot_gejala_id' => 2]);
        BasisPengetahuan::create(['kasus_id' => 3, 'gejala_id' => 7, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 3, 'gejala_id' => 19, 'bobot_gejala_id' => 2]);
        BasisPengetahuan::create(['kasus_id' => 4, 'gejala_id' => 3, 'bobot_gejala_id' => 2]);
        BasisPengetahuan::create(['kasus_id' => 4, 'gejala_id' => 8, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 4, 'gejala_id' => 13, 'bobot_gejala_id' => 3]);
        BasisPengetahuan::create(['kasus_id' => 4, 'gejala_id' => 18, 'bobot_gejala_id' => 2]);
        BasisPengetahuan::create(['kasus_id' => 4, 'gejala_id' => 20, 'bobot_gejala_id' => 2]);
        //buat basis pengetahuan kompleksitas
        BasisPengetahuanKompleksitas::create(['kasus_id' => 1, 'kompleksitas_id' => 1,]);
        BasisPengetahuanKompleksitas::create(['kasus_id' => 1, 'kompleksitas_id' => 2,]);
        BasisPengetahuanKompleksitas::create(['kasus_id' => 2, 'kompleksitas_id' => 1,]);
        BasisPengetahuanKompleksitas::create(['kasus_id' => 2, 'kompleksitas_id' => 2,]);
        BasisPengetahuanKompleksitas::create(['kasus_id' => 3, 'kompleksitas_id' => 1,]);
        BasisPengetahuanKompleksitas::create(['kasus_id' => 3, 'kompleksitas_id' => 2,]);
        BasisPengetahuanKompleksitas::create(['kasus_id' => 4, 'kompleksitas_id' => 1,]);
        BasisPengetahuanKompleksitas::create(['kasus_id' => 4, 'kompleksitas_id' => 2,]);
    }
}
