<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class DummyJobSeeder extends Seeder
{
    public function run(): void
    {
        Job::query()->delete();

        Job::insert([

            [
                'id' => 1001,
                'posisi' => 'Lead Experience Architect',
                'kategori' => 'PEKERJA TETAP',
                'jenis_bidang' => 'IT',
                'gaji' => 'Rp 8.000.000 - Rp 10.000.000',
                'deadline' => '2026-12-31',
                'tanggung_jawab' => json_encode([
                    'Mendesain UI/UX yang intuitif dan responsif untuk platform web dan mobile.',
                    'Melakukan user research dan usability testing untuk memahami kebutuhan pengguna.',
                    'Berkolaborasi dengan tim engineering untuk memastikan kesesuaian implementasi desain.'
                ]),
                'kualifikasi' => json_encode([
                    'Pengalaman kerja minimal 3 tahun di bidang UI/UX Design.',
                    'Menguasai tools desain seperti Figma, Adobe XD, atau Sketch.',
                    'Memiliki portofolio desain yang kuat dan berorientasi pada pengguna.'
                ]),
                'status' => 'buka',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 1002,
                'posisi' => 'Senior React Engineer',
                'kategori' => 'PEKERJA TETAP',
                'jenis_bidang' => 'IT',
                'gaji' => 'Rp 10.000.000 - Rp 15.000.000',
                'deadline' => '2026-12-31',
                'tanggung_jawab' => json_encode([
                    'Membangun dan mengembangkan aplikasi web menggunakan React.js.',
                    'Mengoptimalkan performa aplikasi agar cepat dan responsif.',
                    'Menulis kode yang bersih, efisien, dan mudah dipelihara.'
                ]),
                'kualifikasi' => json_encode([
                    'Pengalaman minimal 3 tahun menggunakan React.js dan ekosistemnya (Redux, React Router).',
                    'Pemahaman mendalam tentang HTML5, CSS3, ES6+, dan Tailwind CSS.',
                    'Berpengalaman dengan RESTful API integration.'
                ]),
                'status' => 'buka',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 1003,
                'posisi' => 'Growth Lead',
                'kategori' => 'KONTRAK',
                'jenis_bidang' => 'Marketing',
                'gaji' => 'Rp 12.000.000 - Rp 18.000.000',
                'deadline' => '2026-12-31',
                'tanggung_jawab' => json_encode([
                    'Merancang dan mengeksekusi strategi pertumbuhan pengguna (growth strategy).',
                    'Menganalisis data perilaku pengguna untuk mengidentifikasi peluang pertumbuhan.',
                    'Memimpin kampanye marketing digital multi-saluran.'
                ]),
                'kualifikasi' => json_encode([
                    'Pengalaman minimal 2 tahun sebagai Growth Lead atau posisi sejenis.',
                    'Keahlian kuat dalam analitik data (Google Analytics, Mixpanel, SQL).',
                    'Pemahaman mendalam tentang teknik growth hacking dan digital marketing.'
                ]),
                'status' => 'buka',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 1004,
                'posisi' => 'Video Editor',
                'kategori' => 'KONTRAK',
                'jenis_bidang' => 'Marketing',
                'gaji' => 'Rp 5.000.000 - Rp 8.000.000',
                'deadline' => '2026-12-31',
                'tanggung_jawab' => json_encode([
                    'Melakukan editing video untuk konten media sosial perusahaan.',
                    'Mengembangkan konsep visual kreatif bersama tim konten.',
                    'Menyusun storyboards dan mengolah efek audio-visual.'
                ]),
                'kualifikasi' => json_encode([
                    'Menguasai software editing video seperti Adobe Premiere Pro, After Effects, atau DaVinci Resolve.',
                    'Kreatif dan memiliki perhatian tinggi terhadap detail visual dan ritme video.',
                    'Mampu bekerja di bawah tenggat waktu yang ketat.'
                ]),
                'status' => 'buka',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 1005,
                'posisi' => 'Financial Analyst',
                'kategori' => 'PEKERJA TETAP',
                'jenis_bidang' => 'Finance',
                'gaji' => 'Rp 9.000.000 - Rp 14.000.000',
                'deadline' => '2026-09-30',
                'tanggung_jawab' => json_encode([
                    'Menyusun laporan analisis keuangan bulanan dan tahunan.',
                    'Melakukan evaluasi kelayakan investasi dan analisis risiko keuangan.',
                    'Membantu manajemen dalam perencanaan anggaran (budgeting).'
                ]),
                'kualifikasi' => json_encode([
                    'Minimal S1 Akuntansi, Keuangan, atau bidang relevan.',
                    'Memiliki sertifikasi CFA atau WPPE merupakan nilai tambah.',
                    'Menguasai software keuangan dan mahir menggunakan Microsoft Excel tingkat lanjut.'
                ]),
                'status' => 'buka',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 1006,
                'posisi' => 'HR Recruitment Specialist',
                'kategori' => 'PEKERJA TETAP',
                'jenis_bidang' => 'HR',
                'gaji' => 'Rp 6.000.000 - Rp 9.000.000',
                'deadline' => '2026-10-15',
                'tanggung_jawab' => json_encode([
                    'Mengelola seluruh siklus rekrutmen dari sourcing hingga offering.',
                    'Bekerja sama dengan user (line manager) untuk memahami profil kandidat yang dicari.',
                    'Melakukan wawancara kompetensi (BEI) dan memfasilitasi psikotes.'
                ]),
                'kualifikasi' => json_encode([
                    'Pendidikan minimal S1 Psikologi atau Manajemen SDM.',
                    'Pengalaman minimal 2 tahun sebagai Recruiter di industri teknologi atau startup.',
                    'Kemampuan komunikasi verbal dan interpersonal yang sangat baik.'
                ]),
                'status' => 'buka',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 1007,
                'posisi' => 'Social Media Manager',
                'kategori' => 'KONTRAK',
                'jenis_bidang' => 'Marketing',
                'gaji' => 'Rp 7.000.000 - Rp 11.000.000',
                'deadline' => '2026-08-31',
                'tanggung_jawab' => json_encode([
                    'Merencanakan dan mengeksekusi konten harian di berbagai saluran media sosial.',
                    'Menganalisis performa konten dan mengidentifikasi tren sosial media terbaru.',
                    'Membangun interaksi aktif dengan audiens dan komunitas digital.'
                ]),
                'kualifikasi' => json_encode([
                    'Pengalaman minimal 2 tahun mengelola akun media sosial brand/korporat.',
                    'Kreatif, memiliki kemampuan copy-writing, dan memahami dasar-dasar desain grafis.',
                    'Terbiasa dengan tools analitik media sosial seperti Hootsuite atau Sprout Social.'
                ]),
                'status' => 'buka',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 1008,
                'posisi' => 'DevOps Engineer',
                'kategori' => 'PEKERJA TETAP',
                'jenis_bidang' => 'IT',
                'gaji' => 'Rp 12.000.000 - Rp 18.000.000',
                'deadline' => '2026-11-30',
                'tanggung_jawab' => json_encode([
                    'Mengelola dan mengoptimalkan infrastruktur cloud (AWS/GCP/Azure).',
                    'Membangun serta memelihara pipa integrasi dan penyebaran berkelanjutan (CI/CD).',
                    'Memastikan keamanan, ketersediaan tinggi, dan skalabilitas sistem.'
                ]),
                'kualifikasi' => json_encode([
                    'Pengalaman minimal 2 tahun sebagai DevOps Engineer atau System Administrator.',
                    'Keahlian dalam containerization (Docker, Kubernetes) dan IAC (Terraform).',
                    'Memiliki pemahaman kuat tentang Linux OS dan scripting (Bash/Python).'
                ]),
                'status' => 'buka',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 1009,
                'posisi' => 'Accounting Staff',
                'kategori' => 'PEKERJA TETAP',
                'jenis_bidang' => 'Finance',
                'gaji' => 'Rp 5.500.000 - Rp 7.500.000',
                'deadline' => '2026-07-31',
                'tanggung_jawab' => json_encode([
                    'Memproses transaksi keuangan harian dan melakukan rekonsiliasi bank.',
                    'Menyiapkan invoice, faktur pajak, dan dokumentasi pendukung lainnya.',
                    'Menyusun laporan neraca dan laba-rugi perusahaan.'
                ]),
                'kualifikasi' => json_encode([
                    'Pendidikan minimal D3/S1 Akuntansi.',
                    'Memiliki pemahaman yang baik tentang perpajakan Indonesia (PPh 21/23/25, PPN).',
                    'Teliti, jujur, dan terbiasa menggunakan software akuntansi (Accurate/Xero).'
                ]),
                'status' => 'buka',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 1010,
                'posisi' => 'Content Writer Intern',
                'kategori' => 'MAGANG',
                'jenis_bidang' => 'Marketing',
                'gaji' => 'Rp 2.000.000 - Rp 3.500.000',
                'deadline' => '2026-06-30',
                'tanggung_jawab' => json_encode([
                    'Menulis artikel SEO-friendly untuk blog dan website perusahaan.',
                    'Membantu membuat naskah/script konten video pendek.',
                    'Melakukan riset topik yang relevan dan menarik bagi target audiens.'
                ]),
                'kualifikasi' => json_encode([
                    'Mahasiswa aktif tingkat akhir atau lulusan baru dari jurusan Komunikasi/Sastra/Jurnalistik.',
                    'Memiliki portofolio tulisan/artikel dalam Bahasa Indonesia maupun Bahasa Inggris.',
                    'Mampu bekerja secara mandiri dengan pengawasan minimal.'
                ]),
                'status' => 'buka',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}