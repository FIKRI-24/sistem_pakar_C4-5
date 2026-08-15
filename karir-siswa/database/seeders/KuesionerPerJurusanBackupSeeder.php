<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\PilihanJawaban;
use App\Models\Soal;
use App\Models\Tes;
use Illuminate\Database\Seeder;

class KuesionerPerJurusanBackupSeeder extends Seeder
{
    /**
     * Seeder Cadangan (Backup / Standby):
     * Menyediakan 3 Paket Kuesioner Spesifik Per Jurusan (TKJ, DPIB, Kriya Kayu).
     *
     * Tes ini diset 'status_aktif' => false secara default agar tidak mengganggu
     * tes terpadu utama di web. Admin/Guru BK dapat mengaktifkannya sewaktu-waktu
     * jika sekolah/dosen menghendaki pengujian spesifik per jurusan.
     */
    public function run(): void
    {
        $kriterias = Kriteria::with('opsis')->get()->keyBy('nama_kriteria');

        $packages = [
            // =========================================================================
            // 1. PAKET KHUSUS JURUSAN TKJ (Teknik Komputer dan Jaringan)
            // =========================================================================
            [
                'nama_tes' => 'Tes Potensi Karir Khusus - Jurusan TKJ',
                'deskripsi' => 'Asesmen bimbingan karir khusus siswa kompetensi keahlian Teknik Komputer dan Jaringan (fokus IT, Networking, System & Software).',
                'durasi_menit' => 30,
                'status_aktif' => false, // Standby / Backup
                'definitions' => [
                    // --- MINAT (RIASEC) ---
                    // Realistic
                    ['urutan' => 1, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Merakit komputer PC, memasang kabel jaringan LAN, dan instalasi konektor RJ45.'],
                    ['urutan' => 2, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Melakukan penarikan kabel Fiber Optic (FO) dan penyambungan core menggunakan splicer.'],
                    ['urutan' => 3, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Memasang perangkat access point WiFi, antena jaringan nirkabel, atau kamera CCTV IP.'],
                    ['urutan' => 4, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Memperbaiki dan membersihkan komponen hardware motherboard, power supply, atau printer.'],

                    // Investigative
                    ['urutan' => 5, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Menganalisis konfigurasi routing protokol (MikroTik/Cisco) dan troubleshooting subnetting IP.'],
                    ['urutan' => 6, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Mendiagnosis penyebab server down, gangguan koneksi internet, atau serangan keamanan firewall.'],
                    ['urutan' => 7, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Mempelajari cara kerja sistem operasi server (Linux/Windows Server) dan virtualisasi server.'],
                    ['urutan' => 8, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Mengeksplorasi bahasa pemrograman, scripting automasi jaringan, atau teknologi cloud computing.'],

                    // Artistic
                    ['urutan' => 9, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Mendesain tata letak antarmuka pengguna (UI/UX) website atau landing page aplikasi.'],
                    ['urutan' => 10, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Merancang diagram topologi jaringan visual yang rapi, estetis, dan mudah dipahami.'],
                    ['urutan' => 11, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Membuat konten banner promosi digital, logo teknologi, atau infografis arsitektur IT.'],
                    ['urutan' => 12, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Mengeksplorasi perpaduan palet warna dan animasi interaktif pada aplikasi web/mobile.'],

                    // Social
                    ['urutan' => 13, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Membimbing teman sekelas dalam praktik instalasi sistem operasi dan setting jaringan.'],
                    ['urutan' => 14, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Melayani permintaan bantuan pengguna (Helpdesk/IT Support) dengan ramah dan sabar.'],
                    ['urutan' => 15, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Menjadi admin komunitas IT sekolah, aktif berbagi ilmu tips komputer dan keamanan siber.'],
                    ['urutan' => 16, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Memberikan edukasi literasi digital dan keamanan internet kepada masyarakat umum.'],

                    // Enterprising
                    ['urutan' => 17, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Membuka usaha jasa servis komputer/laptop, maintenance PC, dan instalasi software mandiri.'],
                    ['urutan' => 18, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Menawarkan jasa perakitan jaringan WiFi hotspot, voucher internet RT/RW Net, atau warnet.'],
                    ['urutan' => 19, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Menjual perangkat keras komputer, modem, kabel, dan periferal IT ke pelanggan.'],
                    ['urutan' => 20, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Memimpin proyek tim IT sekolah, mencari peluang tender pengadaan lab komputer.'],

                    // Conventional
                    ['urutan' => 21, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Mencatat nomor inventaris perangkat router, switch, server, dan kabel di rak server.'],
                    ['urutan' => 22, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Mendokumentasikan log pemeliharaan berkala, backup database, dan kartu garansi hardware.'],
                    ['urutan' => 23, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Membuat rekapitulasi data akun pengguna WiFi dan jadwal pergantian password server.'],
                    ['urutan' => 24, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Bekerja mengikuti Standar Operasional Prosedur (SOP) keselamatan kerja listrik & jaringan.'],

                    // --- BAKAT (DAT) ---
                    ['urutan' => 25, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mampu memahami maksud buku manual teknis perangkat IT berbahasa teknis dengan cepat.'],
                    ['urutan' => 26, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mudah menulis dokumentasi panduan konfigurasi jaringan dengan urutan langkah yang jelas.'],
                    ['urutan' => 27, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya percaya diri mempresentasikan topologi jaringan dan solusi IT di hadapan kelompok.'],
                    ['urutan' => 28, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mampu menjelaskan istilah teknis komputer kepada orang awam secara sederhana.'],

                    ['urutan' => 29, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya mampu menghitung subnetting IP (CIDR/VLSM) dan pembagian host secara cepat.'],
                    ['urutan' => 30, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya mudah menganalisis grafik throughput bandwidth, lalu lintas paket data, dan ping latency.'],
                    ['urutan' => 31, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya terbiasa menggunakan logika alur if-else yang runut saat mengatasi error komputer.'],
                    ['urutan' => 32, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya teliti menemukan kesalahan baris konfigurasi atau perbedaan angka IP pada script.'],

                    ['urutan' => 33, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya mampu membayangkan skema arsitektur jaringan skala luas di dalam pikiran.'],
                    ['urutan' => 34, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya pandai menggambar diagram skema tata letak penempatan server dan access point.'],
                    ['urutan' => 35, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya cepat mengenali kesalahan urutan susunan warna kabel UTP (T568A/T568B).'],
                    ['urutan' => 36, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya mudah membaca denah gedung untuk menentukan jalur penarikan kabel jaringan.'],

                    ['urutan' => 37, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya terampil menggunakan tang crimping untuk memasang konektor kabel LAN secara presisi.'],
                    ['urutan' => 38, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya memiliki jari jemari yang lincah saat mengupas serat kaca fiber optic dan menyolder.'],
                    ['urutan' => 39, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya kuat memanjat tangga atau tiang untuk memasang perangkat antena jaringan luar ruangan.'],
                    ['urutan' => 40, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya cekatan menggunakan perkakas obeng, tester kabel LAN, dan toolkit perbaikan PC.'],

                    // --- KEPRIBADIAN (DISC) ---
                    ['urutan' => 41, 'kriteria' => 'Kepribadian', 'opsi' => 'Dominance', 'pertanyaan' => 'Saya berani mengambil tindakan cepat dan tegas saat terjadi insiden darurat server down.'],
                    ['urutan' => 42, 'kriteria' => 'Kepribadian', 'opsi' => 'Dominance', 'pertanyaan' => 'Saya terpacu untuk memecahkan problem IT yang rumit dan ingin menjadi yang terbaik di tim.'],
                    ['urutan' => 43, 'kriteria' => 'Kepribadian', 'opsi' => 'Influence', 'pertanyaan' => 'Saya mudah berkomunikasi ramah dengan pengguna saat melayani kebutuhan teknis IT.'],
                    ['urutan' => 44, 'kriteria' => 'Kepribadian', 'opsi' => 'Influence', 'pertanyaan' => 'Saya senang mengajak teman mencoba inovasi aplikasi baru dan berbagi semangat teknologi.'],
                    ['urutan' => 45, 'kriteria' => 'Kepribadian', 'opsi' => 'Steadiness', 'pertanyaan' => 'Saya adalah orang yang sabar dalam menghadapi komplain pengguna dan tekun mencari error.'],
                    ['urutan' => 46, 'kriteria' => 'Kepribadian', 'opsi' => 'Steadiness', 'pertanyaan' => 'Saya menyukai jadwal kerja monitoring server yang teratur, damai, dan kompak bersama tim.'],
                    ['urutan' => 47, 'kriteria' => 'Kepribadian', 'opsi' => 'Compliance', 'pertanyaan' => 'Saya selalu teliti memeriksa ulang konfigurasi port dan keamanan firewall sebelum online.'],
                    ['urutan' => 48, 'kriteria' => 'Kepribadian', 'opsi' => 'Compliance', 'pertanyaan' => 'Saya taat pada aturan protokol keamanan data dan standar operasional perangkat IT.'],

                    // --- NILAI AKADEMIK ---
                    ['urutan' => 49, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Produktif TKJ (Administrasi Jaringan, Komputer & Jaringan Dasar) Anda?'],
                    ['urutan' => 50, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Umum & Eksakta (Matematika, Bahasa Inggris, dll) Anda?'],
                ],
            ],

            // =========================================================================
            // 2. PAKET KHUSUS JURUSAN DPIB (Desain Pemodelan dan Informasi Bangunan)
            // =========================================================================
            [
                'nama_tes' => 'Tes Potensi Karir Khusus - Jurusan DPIB',
                'deskripsi' => 'Asesmen bimbingan karir khusus siswa kompetensi keahlian Desain Pemodelan dan Informasi Bangunan (fokus Arsitektur, CAD, BIM & Konstruksi).',
                'durasi_menit' => 30,
                'status_aktif' => false, // Standby / Backup
                'definitions' => [
                    // --- MINAT (RIASEC) ---
                    ['urutan' => 1, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Mengoperasikan alat ukur tanah waterpass/theodolite untuk mengukur beda tinggi lahan proyek.'],
                    ['urutan' => 2, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Menggambar teknik denah bangunan, potongan, dan tampak menggunakan software AutoCAD 2D/3D.'],
                    ['urutan' => 3, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Membuat maket fisik miniatur bangunan atau memeriksa langsung pelaksanaan fisik di proyek.'],
                    ['urutan' => 4, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Menggunakan mistar gambar, jangka teknik, dan peralatan survei lapangan secara praktis.'],

                    ['urutan' => 5, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Menganalisis kekuatan struktur rangka beton bertulang, kuda-kuda atap baja ringan, dan pondasi.'],
                    ['urutan' => 6, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Mempelajari integrasi pemodelan informasi gedung terpadu 3D menggunakan software BIM (Revit).'],
                    ['urutan' => 7, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Mengkalkulasi volume kebutuhan bahan material (semen, pasir, besi beton) dan spesifikasi teknik.'],
                    ['urutan' => 8, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Meneliti peta topografi tanah, analisis tata air drainase, dan peraturan garis sempadan bangunan.'],

                    ['urutan' => 9, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Merancang konsep desain arsitektur rumah tinggal modern, fasad depan bangunan yang estetis.'],
                    ['urutan' => 10, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Membuat visualisasi 3D rendering interior ruangan dengan pencahayaan dan material realistis (SketchUp/Lumion).'],
                    ['urutan' => 11, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Menggambar sketsa perspektif eksterior bangunan secara bebas dengan komposisi estetika yang indah.'],
                    ['urutan' => 12, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Memadukan warna cat dinding, tekstur lantai, dan elemen dekorasi taman pada rancangan bangunan.'],

                    ['urutan' => 13, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Membimbing teman sekelas dalam menguasai shortcut perintah software gambar AutoCAD/Revit.'],
                    ['urutan' => 14, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Mendengarkan keinginan klien tentang kebutuhan ruang rumah idaman mereka dengan penuh perhatian.'],
                    ['urutan' => 15, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Bekerja sama secara rukun dalam tim proyek studio gambar untuk menyelesaikan tugas kelompok.'],
                    ['urutan' => 16, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Memberikan edukasi tentang rumah sehat, ramah lingkungan, dan tahan gempa kepada warga.'],

                    ['urutan' => 17, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Menawarkan jasa pembuatan gambar kerja IMB/PBG dan desain rumah kepada calon pemilik rumah.'],
                    ['urutan' => 18, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Mempresentasikan konsep desain bangunan di depan pemilik proyek untuk memenangkan kontrak.'],
                    ['urutan' => 19, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Mengembangkan usaha biro jasa drafter bangunan, konsultan arsitektur, atau kontraktor mandiri.'],
                    ['urutan' => 20, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Memimpin tim pengawas lapangan dan menegosiasikan target waktu pengerjaan dengan mandor.'],

                    ['urutan' => 21, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Mengarsipkan dokumen gambar kerja bestek, file CAD, dan lembar spesifikasi teknis sesuai folder.'],
                    ['urutan' => 22, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Menyusun tabel Rencana Anggaran Biaya (RAB) dan rincian Analisa Harga Satuan Pekerjaan (AHSP).'],
                    ['urutan' => 23, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Mengecek kesesuaian ukuran di gambar kerja dengan kondisi riil di lapangan secara teliti.'],
                    ['urutan' => 24, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Mencatat laporan harian/mingguan kemajuan progres proyek konstruksi sesuai format resmi.'],

                    // --- BAKAT (DAT) ---
                    ['urutan' => 25, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mampu membaca dan memahami isi dokumen Kerangka Acuan Kerja (KAK) proyek dengan cepat.'],
                    ['urutan' => 26, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mudah menulis laporan hasil survei lapangan dan notulen rapat proyek secara runtut.'],
                    ['urutan' => 27, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya percaya diri mempresentasikan konsep perancangan bangunan di hadapan guru/juri.'],
                    ['urutan' => 28, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mampu menjelaskan maksud gambar detail potongan teknik kepada mandor/tukang.'],

                    ['urutan' => 29, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya mampu menghitung luas, volume galian/timbunan, dan kebutuhan material secara tepat.'],
                    ['urutan' => 30, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya mudah menghitung total anggaran biaya (RAB) bangunan berdasarkan koefisien harga satuan.'],
                    ['urutan' => 31, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya terbiasa menghitung titik koordinat dan sudut poligon pengukuran tanah secara matematis.'],
                    ['urutan' => 32, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya peka terhadap ketidakseimbangan angka dimensi pada notasi ukuran denah gambar.'],

                    ['urutan' => 33, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya mampu membayangkan bentuk bangunan 3D di kepala hanya dengan melihat denah 2D datar.'],
                    ['urutan' => 34, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya pandai memperkirakan perbandingan skala gambar, proporsi tinggi pintu, dan lebar ruangan.'],
                    ['urutan' => 35, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya mudah menemukan kesalahan garis overlapping atau ketidaksinkronan elevasi pada gambar.'],
                    ['urutan' => 36, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya sangat menguasai proyeksi ortogonal, gambar potongan melintang, dan pandangan isometri.'],

                    ['urutan' => 37, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya terampil dan stabil saat memegang alat perata nivo theodolite/waterpass di lapangan.'],
                    ['urutan' => 38, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya memiliki jari jemari yang lincah dan koordinasi cepat saat mengoperasikan mouse & keyboard CAD.'],
                    ['urutan' => 39, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya memiliki daya tahan fisik yang kuat untuk berjalan kaki dan mengukur lahan di bawah terik matahari.'],
                    ['urutan' => 40, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya terampil menggunakan meteran ukur pita baja, mistar segitiga, dan alat survei lapangan.'],

                    // --- KEPRIBADIAN (DISC) ---
                    ['urutan' => 41, 'kriteria' => 'Kepribadian', 'opsi' => 'Dominance', 'pertanyaan' => 'Saya berani menginstruksikan mandor untuk membongkar pasangan bata yang miring tidak sesuai gambar.'],
                    ['urutan' => 42, 'kriteria' => 'Kepribadian', 'opsi' => 'Dominance', 'pertanyaan' => 'Saya fokus pada pencapaian target batas waktu (deadline) penyerahan gambar kerja proyek.'],
                    ['urutan' => 43, 'kriteria' => 'Kepribadian', 'opsi' => 'Influence', 'pertanyaan' => 'Saya pandai meyakinkan pemilik bangunan bahwa konsep desain arsitektur saya adalah yang terbaik.'],
                    ['urutan' => 44, 'kriteria' => 'Kepribadian', 'opsi' => 'Influence', 'pertanyaan' => 'Saya ramah dalam menjalin komunikasi yang baik dengan semua pekerja di lingkungan proyek.'],
                    ['urutan' => 45, 'kriteria' => 'Kepribadian', 'opsi' => 'Steadiness', 'pertanyaan' => 'Saya sabar dan tekun saat menyelesaikan gambar detail tulangan beton yang membutuhkan ketelitian tinggi.'],
                    ['urutan' => 46, 'kriteria' => 'Kepribadian', 'opsi' => 'Steadiness', 'pertanyaan' => 'Saya menyukai atmosfer kerja studio gambar yang tenang, teratur, dan kompak bersama tim.'],
                    ['urutan' => 47, 'kriteria' => 'Kepribadian', 'opsi' => 'Compliance', 'pertanyaan' => 'Saya selalu mengecek kembali setiap dimensi angka dan garis grid sebelum mencetak gambar bestek.'],
                    ['urutan' => 48, 'kriteria' => 'Kepribadian', 'opsi' => 'Compliance', 'pertanyaan' => 'Saya taat pada standar aturan gambar teknik bangunan (SNI) dan peraturan keselamatan kerja (K3).'],

                    // --- NILAI AKADEMIK ---
                    ['urutan' => 49, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Produktif DPIB (Aplikasi Perangkat Lunak, Gambar Konstruksi) Anda?'],
                    ['urutan' => 50, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Umum & Eksakta (Matematika, Fisika, B. Indonesia) Anda?'],
                ],
            ],

            // =========================================================================
            // 3. PAKET KHUSUS JURUSAN KRIYA KAYU (Kriya Kreatif Kayu dan Rotan)
            // =========================================================================
            [
                'nama_tes' => 'Tes Potensi Karir Khusus - Jurusan Kriya Kayu',
                'deskripsi' => 'Asesmen bimbingan karir khusus siswa kompetensi keahlian Kriya Kreatif Kayu dan Rotan (fokus Desain Furnitur, Ukir, Woodworking & Finishing).',
                'durasi_menit' => 30,
                'status_aktif' => false, // Standby / Backup
                'definitions' => [
                    // --- MINAT (RIASEC) ---
                    ['urutan' => 1, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Memotong kayu menggunakan gergaji mesin (circular saw) dan meratakan permukaan dengan mesin serut.'],
                    ['urutan' => 2, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Memahat ornamen seni ukiran tradisional/modern pada papan kayu jati/mahoni menggunakan pahat ukir.'],
                    ['urutan' => 3, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Merakit konstruksi sambungan mebel (sambungan ekor burung, pen, lubang) menjadi kursi/meja.'],
                    ['urutan' => 4, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Mengerjakan finishing kayu: mengamplas halus, memberi warna melamin, plitur, dan pernis semprot.'],

                    ['urutan' => 5, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Menganalisis kadar kekeringan air kayu (moisture content) agar kayu tidak retak saat diproses.'],
                    ['urutan' => 6, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Mempelajari cara kerja pemrograman dan pengaturan koordinat mesin router CNC ukir kayu.'],
                    ['urutan' => 7, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Menguji daya rekat lem kayu dan kekuatan sambungan konstruksi mebel terhadap beban berat.'],
                    ['urutan' => 8, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Meneliti sifat serat dan karakteristik berbagai jenis kayu (Jati, Mahoni, Sungkai, Rotan, MDF).'],

                    ['urutan' => 9, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Merancang sketsa desain model furnitur kayu/rotan minimalis modern yang estetis dan fungsional.'],
                    ['urutan' => 10, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Mengembangkan motif ornamen ukir kayu yang bernilai seni tinggi untuk dekorasi interior.'],
                    ['urutan' => 11, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Membuat produk kerajinan cinderamata kayu artistik (jam meja kayu, kotak perhiasan, plakat ukir).'],
                    ['urutan' => 12, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Mengeksplorasi keindahan corak serat alami kayu dan memadukan teknik pewarnaan rustic/vintage.'],

                    ['urutan' => 13, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Membimbing adik kelas dalam teknik memegang pahat ukir dan keselamatan kerja mesin kayu.'],
                    ['urutan' => 14, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Mendengarkan keinginan pesanan mebel custom dari pelanggan dengan penuh perhatian dan ramah.'],
                    ['urutan' => 15, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Bekerja sama secara gotong royong dalam tim bengkel mebel untuk menyelesaikan pesanan besar.'],
                    ['urutan' => 16, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Melestarikan warisan budaya seni ukir kayu tradisional kepada generasi muda.'],

                    ['urutan' => 17, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Mendirikan bengkel mebel mandiri dan memproduksi perabot rumah tangga siap jual.'],
                    ['urutan' => 18, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Memasarkan produk souvenir kayu dan mebel custom lewat media sosial dan marketplace.'],
                    ['urutan' => 19, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Menegosiasikan harga borongan pesanan kusen pintu, jendela, atau perabot kantor dengan pembeli.'],
                    ['urutan' => 20, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Memimpin bengkel produksi kriya kayu dan mengelola modal kerja serta upah tukang.'],

                    ['urutan' => 21, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Mencatat kartu stok masuk/keluar bahan baku papan kayu balok dan persediaan bahan finishing.'],
                    ['urutan' => 22, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Menghitung estimasi kebutuhan kubikasi kayu dan biaya produksi mebel secara tertib.'],
                    ['urutan' => 23, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Melakukan inspeksi quality control (QC) kelurusan sudut mebel sebelum pengiriman ke konsumen.'],
                    ['urutan' => 24, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Menyimpan dan merawat peralatan pahat, mata bor, dan mata gergaji pada tempatnya sesuai SOP.'],

                    // --- BAKAT (DAT) ---
                    ['urutan' => 25, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mampu memahami maksud lembar instruksi kerja pembuatan mebel dan pesanan custom.'],
                    ['urutan' => 26, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mudah menulis laporan hasil praktik pembuatan kriya kayu dan rincian bahan yang dipakai.'],
                    ['urutan' => 27, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya percaya diri mempresentasikan karya kerajinan kriya kayu di pameran/bazar sekolah.'],
                    ['urutan' => 28, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mampu menjelaskan keunggulan jenis kayu dan finishing produk kepada calon pembeli.'],

                    ['urutan' => 29, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya mampu menghitung volume kubikasi kayu (PxLxT) dan efisiensi pemotongan bahan.'],
                    ['urutan' => 30, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya mudah menghitung harga pokok produksi (HPP) dan persentase keuntungan jual mebel.'],
                    ['urutan' => 31, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya teliti mengukur derajat sudut sambungan kayu siku 90 derajat atau sudut miring 45 derajat.'],
                    ['urutan' => 32, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya peka terhadap selisih milimeter pada ketebalan papan kayu yang diserut.'],

                    ['urutan' => 33, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya mampu membayangkan bentuk 3D perabot mebel secara utuh sebelum mulai memotong kayu.'],
                    ['urutan' => 34, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya pandai menggambar sketsa pola ukiran simetris dan denah konstruksi sambungan mebel.'],
                    ['urutan' => 35, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya cepat mendeteksi ketidakrataan permukaan kayu, cacat mata kayu, atau ketimpangan warna pernis.'],
                    ['urutan' => 36, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya sangat menguasai pembacaan gambar kerja produk kriya dan gambar detail sambungan.'],

                    ['urutan' => 37, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya memiliki jari jemari yang sangat terampil dan kuat saat memegang pahat ukir dan palu kayu.'],
                    ['urutan' => 38, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya memiliki koordinasi tangan-mata yang presisi saat menggergaji dan mengamplas profil lengkung.'],
                    ['urutan' => 39, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya memiliki ketahanan fisik yang baik untuk bekerja berdiri di bengkel kayu dalam waktu lama.'],
                    ['urutan' => 40, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya terbiasa dan terampil mengoperasikan mesin bubut kayu, mesin serut, dan spray gun finishing.'],

                    // --- KEPRIBADIAN (DISC) ---
                    ['urutan' => 41, 'kriteria' => 'Kepribadian', 'opsi' => 'Dominance', 'pertanyaan' => 'Saya bersikap tegas dalam memimpin pengerjaan proyek mebel agar selesai tepat waktu.'],
                    ['urutan' => 42, 'kriteria' => 'Kepribadian', 'opsi' => 'Dominance', 'pertanyaan' => 'Saya tertantang untuk membuat karya mebel/ukiran yang rumit dan belum pernah dibuat orang lain.'],
                    ['urutan' => 43, 'kriteria' => 'Kepribadian', 'opsi' => 'Influence', 'pertanyaan' => 'Saya pandai menawarkan nilai seni produk kerajinan kayu kepada peminat barang unik.'],
                    ['urutan' => 44, 'kriteria' => 'Kepribadian', 'opsi' => 'Influence', 'pertanyaan' => 'Saya senang berdiskusi ramah dengan desainer interior dan pelanggan mebel custom.'],
                    ['urutan' => 45, 'kriteria' => 'Kepribadian', 'opsi' => 'Steadiness', 'pertanyaan' => 'Saya memiliki kesabaran dan ketekunan tinggi saat memahat ukiran detail yang butuh waktu lama.'],
                    ['urutan' => 46, 'kriteria' => 'Kepribadian', 'opsi' => 'Steadiness', 'pertanyaan' => 'Saya menyukai suasana kerja bengkel yang tertib, harmonis, dan saling membantu antar pengrajin.'],
                    ['urutan' => 47, 'kriteria' => 'Kepribadian', 'opsi' => 'Compliance', 'pertanyaan' => 'Saya selalu memeriksa kehalusan permukaan kayu dan kerapian sambungan sebelum tahap finishing.'],
                    ['urutan' => 48, 'kriteria' => 'Kepribadian', 'opsi' => 'Compliance', 'pertanyaan' => 'Saya disiplin menggunakan alat pelindung diri (masker, kacamata kerja) sesuai SOP bengkel kriya.'],

                    // --- NILAI AKADEMIK ---
                    ['urutan' => 49, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Produktif Kriya Kayu (Desain Produk Kriya, Kerja Kayu) Anda?'],
                    ['urutan' => 50, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Umum & Seni (Matematika, Seni Budaya, B. Indonesia) Anda?'],
                ],
            ],
        ];

        foreach ($packages as $pkg) {
            $tes = Tes::updateOrCreate(
                ['nama_tes' => $pkg['nama_tes']],
                [
                    'deskripsi' => $pkg['deskripsi'],
                    'durasi_menit' => $pkg['durasi_menit'],
                    'status_aktif' => $pkg['status_aktif'],
                ]
            );

            // Bersihkan sisa soal lama jika urutan > 50
            $tes->soals()->where('urutan', '>', count($pkg['definitions']))->delete();

            foreach ($pkg['definitions'] as $def) {
                $kriteria = $kriterias->get($def['kriteria']);
                $soal = Soal::updateOrCreate(
                    ['tes_id' => $tes->id, 'urutan' => $def['urutan']],
                    [
                        'kriteria_id' => $kriteria->id,
                        'pertanyaan' => $def['pertanyaan'],
                    ]
                );

                if ($kriteria->tipe_data === Kriteria::TYPE_NUMERIK) {
                    $soal->pilihanJawabans()->delete();
                    continue;
                }

                $choiceTexts = [];
                if ($def['kriteria'] === 'Minat') {
                    $choiceTexts = [
                        5 => 'Sangat Suka',
                        4 => 'Suka',
                        3 => 'Biasa Saja',
                        2 => 'Kurang Suka',
                        1 => 'Tidak Suka',
                    ];
                } elseif ($def['kriteria'] === 'Bakat') {
                    $choiceTexts = [
                        5 => 'Sangat Mampu',
                        4 => 'Mampu',
                        3 => 'Cukup Mampu',
                        2 => 'Kurang Mampu',
                        1 => 'Tidak Mampu',
                    ];
                } elseif ($def['kriteria'] === 'Kepribadian') {
                    $choiceTexts = [
                        5 => 'Sangat Setuju',
                        4 => 'Setuju',
                        3 => 'Netral',
                        2 => 'Kurang Setuju',
                        1 => 'Tidak Setuju',
                    ];
                }

                $opsi = null;
                if (isset($def['opsi']) && $def['opsi']) {
                    $opsi = $kriteria->opsis->firstWhere('label', $def['opsi']);
                }

                foreach ($choiceTexts as $skor => $pilihanText) {
                    PilihanJawaban::updateOrCreate(
                        [
                            'soal_id' => $soal->id,
                            'pilihan' => $pilihanText,
                        ],
                        [
                            'skor' => $skor,
                            'kriteria_opsi_id' => $opsi ? $opsi->id : null,
                        ]
                    );
                }

                $soal->pilihanJawabans()->whereNotIn('pilihan', array_values($choiceTexts))->delete();
            }
        }
    }
}
