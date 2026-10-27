<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TvriBerita;
use App\Models\TvriBeritaRingkasan;
use App\Models\TvriBeritaRealtimeFeed;
use App\Models\TvriBeritaAgendaLiputan;
use App\Models\TvriBeritaCatatan;

class TvriBeritaDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan Data Berita Lama
        TvriBerita::truncate();
        TvriBeritaRealtimeFeed::truncate();
        TvriBeritaAgendaLiputan::truncate();
        TvriBeritaCatatan::truncate();

        // 2. Seed Real Time Newsroom (• LIVE)
        $realtimeFeeds = [
            ['waktu' => '10:24', 'kegiatan' => 'Tim liputan di Ambon kirim footage - Festival Budaya', 'urutan' => 1, 'status' => 'LIVE'],
            ['waktu' => '10:12', 'kegiatan' => 'Editing berita - Penyaluran Bantuan UMKM', 'urutan' => 2, 'status' => 'LIVE'],
            ['waktu' => '09:50', 'kegiatan' => 'Konfirmasi narasumber - Kebijakan Pendidikan', 'urutan' => 3, 'status' => 'LIVE'],
            ['waktu' => '09:30', 'kegiatan' => 'Liputan langsung - Pelabuhan Yos Sudarso', 'urutan' => 4, 'status' => 'LIVE'],
            ['waktu' => '09:15', 'kegiatan' => 'VO dalam proses - Harga Pangan di Ambon', 'urutan' => 5, 'status' => 'LIVE'],
            ['waktu' => '08:40', 'kegiatan' => 'Rapat redaksi pagi selesai', 'urutan' => 6, 'status' => 'LIVE'],
            ['waktu' => '08:10', 'kegiatan' => 'Penugasan tim - Monitoring Infrastruktur SBB', 'urutan' => 7, 'status' => 'LIVE'],
        ];
        foreach ($realtimeFeeds as $f) {
            TvriBeritaRealtimeFeed::create($f);
        }

        // 3. Seed Agenda Liputan Hari Ini
        $agendaLiputans = [
            ['waktu' => '08:00', 'agenda' => 'Rapat koordinasi redaksi', 'lokasi' => 'Ambon', 'pic' => 'Tim Redaksi', 'status' => 'Selesai', 'urutan' => 1],
            ['waktu' => '09:00', 'agenda' => 'Festival Budaya', 'lokasi' => 'Ambon', 'pic' => 'Tim 1', 'status' => 'On Air', 'urutan' => 2],
            ['waktu' => '11:00', 'agenda' => 'UMKM dan Ekonomi', 'lokasi' => 'Maluku Tengah', 'pic' => 'Tim 2', 'status' => 'Proses', 'urutan' => 3],
            ['waktu' => '13:00', 'agenda' => 'Pendidikan', 'lokasi' => 'SBB', 'pic' => 'Tim 3', 'status' => 'Terjadwal', 'urutan' => 4],
            ['waktu' => '15:00', 'agenda' => 'Infrastruktur', 'lokasi' => 'Maluku Tenggara', 'pic' => 'Tim 4', 'status' => 'Terjadwal', 'urutan' => 5],
            ['waktu' => '17:00', 'agenda' => 'Pariwisata', 'lokasi' => 'Banda Neira', 'pic' => 'Tim 5', 'status' => 'Terjadwal', 'urutan' => 6],
        ];
        foreach ($agendaLiputans as $ag) {
            TvriBeritaAgendaLiputan::create($ag);
        }

        // 4. Seed Catatan & Peringatan Redaksi
        $catatans = [
            ['tipe' => 'warning', 'pesan' => '1 liputan tertunda (kendala cuaca)', 'urutan' => 1],
            ['tipe' => 'warning', 'pesan' => 'Footage dari SBT belum masuk', 'urutan' => 2],
            ['tipe' => 'info', 'pesan' => 'Verifikasi tambahan untuk berita ekonomi', 'urutan' => 3],
            ['tipe' => 'info', 'pesan' => 'Agenda liputan besok sudah disetujui', 'urutan' => 4],
            ['tipe' => 'success', 'pesan' => 'Semua berita tayang sesuai standar', 'urutan' => 5],
        ];
        foreach ($catatans as $c) {
            TvriBeritaCatatan::create($c);
        }

        // 5. Seed 120 Berita Sesuai Data Spesifikasi User
        // Target:
        // - Rencana: 120
        // - Selesai: 102 (85%), Dalam Proses: 10 (8%), Terkendala: 5 (4%), Batal: 3 (3%)
        // - Berita Diproduksi: 95
        // - Berita Tayang: 92
        // - Distribusi Digital: 1,2 Juta views (Persis 1.200.000)
        // - Top 5 views: 125.4K, 98.7K, 76.2K, 54.1K, 48.5K
        // - Kategori: Pemerintahan: 22, Sosial Masyarakat: 18, Ekonomi & UMKM: 14, Pendidikan: 10,
        //   Kesehatan: 8, Pariwisata: 8, Budaya: 6, Olahraga: 5, Hukum & Kriminal: 4, Lainnya: 2
        // - Jenis: Berita Reguler: 58, Current Affairs: 18, Breaking News: 8, Live Report: 6, Feature: 5
        // - Lokasi: Ambon: 28, Maluku Tengah: 16, SBB: 10, SBT: 9, Buru: 8, Maluku Tenggara: 7, Kep. Aru: 6, Maluku Barat Daya: 5, Lainnya: 11

        // Alokasi 10 Kategori persis (22, 18, 14, 10, 8, 8, 6, 5, 4, 2)
        $kategoriMaster = array_merge(
            array_fill(0, 22, 'Pemerintahan'),
            array_fill(0, 18, 'Sosial Masyarakat'),
            array_fill(0, 14, 'Ekonomi & UMKM'),
            array_fill(0, 10, 'Pendidikan'),
            array_fill(0, 8, 'Kesehatan'),
            array_fill(0, 8, 'Pariwisata'),
            array_fill(0, 6, 'Budaya'),
            array_fill(0, 5, 'Olahraga'),
            array_fill(0, 4, 'Hukum & Kriminal'),
            array_fill(0, 2, 'Lainnya')
        ); // total 97 (22+18+14+10+8+8+6+5+4+2)

        // Alokasi Jenis Penyiaran persis (58, 18, 8, 6, 5)
        $jenisMaster = array_merge(
            array_fill(0, 58, 'Berita Reguler'),
            array_fill(0, 18, 'Current Affairs'),
            array_fill(0, 8, 'Breaking News'),
            array_fill(0, 6, 'Live Report'),
            array_fill(0, 5, 'Feature')
        ); // total 95

        // Tambah 2 Berita Reguler agar mencakup 97 item kategori
        $jenisMaster[] = 'Berita Reguler';
        $jenisMaster[] = 'Berita Reguler';

        // Alokasi Sebaran Lokasi persis (28, 16, 10, 9, 8, 7, 6, 5, 11) = 100 (+ 2 = 102)
        $lokasiMaster = array_merge(
            array_fill(0, 28, 'Ambon'),
            array_fill(0, 16, 'Maluku Tengah'),
            array_fill(0, 10, 'SBB'),
            array_fill(0, 9, 'SBT'),
            array_fill(0, 8, 'Buru'),
            array_fill(0, 7, 'Maluku Tenggara'),
            array_fill(0, 6, 'Kep. Aru'),
            array_fill(0, 5, 'Maluku Barat Daya'),
            array_fill(0, 11, 'Lainnya'),
            array_fill(0, 2, 'Kota Tual')
        ); // total 102

        $titlesByCat = [
            'Pemerintahan' => [
                'Pembangunan Infrastruktur SBB', 'Perbaikan Jalan di SBB Terus Dikebut',
                'Rapat Paripurna DPRD Maluku Bahas KUA-PPAS', 'Inovasi Layanan Perizinan Maritim Satu Pintu',
                'Sosialisasi Tata Ruang Wilayah Pesisir Kepulauan', 'Penyaluran Dana Desa Tahap II di Maluku Tengah',
                'Kesiapan Pemilukada Serentak di Bumi Raja-Raja', 'Penataan Kawasan Pelabuhan Yos Sudarso Ambon',
                'Pengawasan Wilayah Perbatasan Laut Maluku Tenggara', 'Kunjungan Kerja Komisi IV di Sentra Pangan Seram',
                'Penguatan Tata Kelola Pemerintahan Desa di SBT', 'Digitalisasi Arsip Administrasi Pemprov Maluku',
                'Monitoring Proyek Sanitasi di Kepulauan Aru', 'Rakor Forkopimda Maluku Antisipasi Cuaca Ekstrem',
                'Evaluasi Kinerja BUMD Sektor Maritim', 'Pelatihan Aparatur Desa di Buru Selatan',
                'Peninjauan Tanggul Penahan Ombak di Kota Tual', 'Optimalisasi Pengelolaan Sampah Kota Ambon',
                'Penyerahan Sertifikat Tanah Redistribusi di SBB', 'Bimbingan Teknis Standar Pelayanan Publik SBT',
                'Pembangunan Dermaga Perintis di MBD', 'Peresmian Jembatan Penghubung Antar Desa Seram'
            ],
            'Sosial Masyarakat' => [
                'Gotong Royong Bersih Pantai Teluk Ambon', 'Penyaluran Bantuan Sosial untuk Lansia Kepulauan',
                'Kerukunan Antar Umat Beragama Menyambut Hari Besar', 'Pelatihan Keterampilan Menjahit Pemuda Karang Taruna',
                'Aksi Cepat Tanggap Peduli Nelayan Terdampak Ombak', 'Sosialisasi Pencegahan Perundungan di Komunitas Pemuda',
                'Bakti Sosial Donor Darah PMI Maluku', 'Penyediaan Air Bersih di Wilayah Pelosok Seram',
                'Pemberdayaan Perempuan Pesisir Lewat Olahan Ikan', 'Perayaan Hari Ulang Tahun Kota Ambon Bersama Warga',
                'Revitalisasi Balai Warga di Maluku Tengah', 'Program Keluarga Harapan Sasar 500 KK di SBT',
                'Penyuluhan Bahaya Narkoba Bagi Pelajar Ambon', 'Santunan Anak Yatim di Kepulauan Tanimbar',
                'Pembangunan Sarana Olahraga Komunitas di SBB', 'Penanaman Mangrove di Pesisir Teluk Baguala',
                'Simulasi Siaga Bencana Gempa di Sekolah Pesisir', 'Pemberian Paket Gizi untuk Balita di Buru'
            ],
            'Ekonomi & UMKM' => [
                'Harga Pangan di Maluku Stabil', 'UMKM Maluku Tembus Pasar Nasional', 'Harga Pangan di Ambon Tetap Stabil',
                'Bantuan UMKM untuk Nelayan di Seram', 'Ekspor Perdana Ikan Tuna Segar dari Kota Tual',
                'Sentra Industri Olahan Sagu Seram Diresmikan', 'Petani Rempah Pala Banda Raih Sertifikasi Organik',
                'Bazar UMKM Kuliner Tradisional Maluku di Pattimura Park', 'Digitalisasi Pembayaran QRIS di Pasar Mardika Ambon',
                'Pameran Kain Tenun Khas Maluku Tenggara', 'Pemberdayaan Pengrajin Minyak Kayu Putih Buru',
                'Dukungan Permodalan BPD Maluku untuk Pedagang Kecil', 'Pelatihan Packaging Produk Olahan Rumput Laut Aru',
                'Panen Raya Padi Organik di Dataran Waeapo Buru'
            ],
            'Pendidikan' => [
                'Sekolah di Kep. Aru Dapat Bantuan Fasilitas', 'Beasiswa Prestasi Anak Pulau Diluncurkan',
                'Workshop Guru Penggerak Tingkat Provinsi Maluku', 'Revitalisasi Laboratorium Komputer SMK di Buru',
                'Peringatan Hari Guru Nasional di Kota Ambon', 'Pelatihan Literasi Digital Siswa Madrasah SBT',
                'Pameran Riset Inovasi Mahasiswa Universitas Pattimura', 'Penguatan Kurikulum Vokasi Kemaritiman Politeknik Ambon',
                'Bantuan Bus Sekolah untuk Pelajar Pesisir SBB', 'Olimpiade Sains Terpadu Siswa SMP Se-Maluku'
            ],
            'Kesehatan' => [
                'Pelayanan Rumah Sakit Terapung di Pulau Terluar MBD', 'Gerakan Penurunan Angka Stunting Terpadu Maluku',
                'Vaksinasi Lengkap Anak di Posyandu Terintegrasi', 'Sosialisasi Pola Hidup Bersih di Sentra Nelayan Tual',
                'Pemeriksaan Mata dan Pembagian Kacamata Gratis di Seram', 'Penyuluhan Kesehatan Reproduksi Remaja Ambon',
                'Pemberian Makanan Tambahan Balita Maluku Tenggara', 'Kesiagaan Puskesmas 24 Jam di Kepulauan Aru'
            ],
            'Pariwisata' => [
                'Wisata Banda Neira Makin Diminati', 'Pesona Pasir Panjang Pantai Ngurbloat Maluku Tenggara',
                'Pengembangan Desa Wisata Hila Kaya Sejarah Ambon', 'Festival Snorkeling dan Diving di Kepulauan Banda',
                'Penataan Spot Foto Panorama Pintu Kota Ambon', 'Wisata Edukasi Konservasi Penyu di Seram Timur',
                'Peningkatan Fasilitas Homestay Pesisir SBB', 'Promosi Keindahan Bawah Laut Pulau Pombo'
            ],
            'Budaya' => [
                'Festival Budaya Pela Gandong di Ambon', 'Pementasan Musik Tradisional Totobuang di Ambon',
                'Pelestarian Budaya Tenun Tradisional Tanimbar', 'Atraksi Bambu Gila Pukau Wisatawan di Negeri Mamala',
                'Revitalisasi Baileo Tradisional di Saparua Maluku Tengah', 'Dokumentasi Tutur Lisan Bahasa Daerah Kepulauan Maluku'
            ],
            'Olahraga' => [
                'Kejuaraan Dayung Perahu Belang Tradisional Maluku', 'Turnamen Futsal Antar Pelajar Kota Ambon',
                'Atletik Maluku Raih Medali di Kejurnas Atletik', 'Pembinaan Atlet Dayung PON Maluku di Teluk Ambon',
                'Kejuaraan Tinju Amatir Walikota Ambon Cup'
            ],
            'Hukum & Kriminal' => [
                'Patroli Laut Polda Maluku Gagalkan Penyelundupan Ilegal', 'Penyuluhan Hukum Restorative Justice Kejaksaan',
                'Operasi Patuh Keselamatan Lalu Lintas Polresta Ambon', 'Sosialisasi Pencegahan Tindak Pidana Siber Bagi Remaja'
            ],
            'Lainnya' => [
                'BMKG Stasiun Pattimura Rilis Prakiraan Cuaca Maritim', 'Peringatan Hari Kesiapsiagaan Bencana Daerah Maluku'
            ]
        ];

        // 8 Berita Khusus dengan views pasti:
        $knownViews = [
            'Festival Budaya Pela Gandong di Ambon' => 125400,
            'Harga Pangan di Maluku Stabil' => 98700,
            'UMKM Maluku Tembus Pasar Nasional' => 76200,
            'Pembangunan Infrastruktur SBB' => 54100,
            'Wisata Banda Neira Makin Diminati' => 48500,
            'Bantuan UMKM untuk Nelayan di Seram' => 24000,
            'Perbaikan Jalan di SBB Terus Dikebut' => 21000,
            'Sekolah di Kep. Aru Dapat Bantuan Fasilitas' => 19500,
        ];
        $sumKnown = array_sum($knownViews); // 467.400
        $sisaViewsTotal = 1200000 - $sumKnown; // 732.600
        $countSisaViews = 92 - 8; // 84 berita tayang lainnya
        $baseViews = intdiv($sisaViewsTotal, $countSisaViews); // 8721
        $remViews = $sisaViewsTotal % $countSisaViews; // 36

        $beritaList = [];
        $catPointers = array_fill_keys(array_keys($titlesByCat), 0);
        $sisaViewIdx = 0;

        // 92 Berita Tayang
        for ($i = 0; $i < 92; $i++) {
            $kat = $kategoriMaster[$i];
            $jns = $jenisMaster[$i];
            $lok = $lokasiMaster[$i];
            $ptr = $catPointers[$kat]++;
            $judul = $titlesByCat[$kat][$ptr] ?? ("Liputan {$kat} {$lok} #" . ($i + 1));

            if (isset($knownViews[$judul])) {
                $views = $knownViews[$judul];
            } else {
                $offset = ($sisaViewIdx % 2 === 0) ? ($sisaViewIdx * 10) : (-$sisaViewIdx * 10);
                $views = $baseViews + $offset;
                if ($sisaViewIdx === $countSisaViews - 1) {
                    $views += $remViews;
                }
                $sisaViewIdx++;
            }

            $tgl = date('Y-m-d', strtotime('2025-09-02 - ' . ($i % 28) . ' days'));
            $durasi = sprintf('%02d:%02d', 1 + ($i % 3), 15 + (($i * 7) % 40));

            $beritaList[] = [
                'judul' => $judul,
                'kategori' => $kat,
                'jenis' => $jns,
                'lokasi' => $lok,
                'status' => 'Selesai',
                'reporter' => 'Tim ' . (1 + ($i % 5)),
                'durasi' => $durasi,
                'tanggal_rencana' => $tgl,
                'tanggal_tayang' => $tgl,
                'views' => $views,
            ];
        }

        // 3 Berita Siap Siar (Diproduksi = Ya, Tayang = NULL) -> Total Diproduksi = 95
        for ($i = 92; $i < 95; $i++) {
            $kat = $kategoriMaster[$i];
            $jns = $jenisMaster[$i];
            $lok = $lokasiMaster[$i];
            $ptr = $catPointers[$kat]++;
            $judul = $titlesByCat[$kat][$ptr] ?? ("Produksi Berita {$kat} di {$lok} (Siap Siar)");

            $beritaList[] = [
                'judul' => $judul,
                'kategori' => $kat,
                'jenis' => $jns,
                'lokasi' => $lok,
                'status' => 'Selesai',
                'reporter' => 'Tim Redaksi',
                'durasi' => '02:20',
                'tanggal_rencana' => '2025-09-02',
                'tanggal_tayang' => null,
                'views' => 0,
            ];
        }

        // 7 Berita Selesai Lapangan (Belum Pasca-Produksi/tanpa durasi) -> Total Selesai = 102
        for ($i = 95; $i < 102; $i++) {
            $kat = $kategoriMaster[$i] ?? null;
            $jns = $jenisMaster[$i] ?? null;
            $lok = $lokasiMaster[$i];
            $beritaList[] = [
                'judul' => "Liputan Selesai Lapangan Wilayah {$lok} #" . ($i - 94),
                'kategori' => $kat,
                'jenis' => $jns,
                'lokasi' => $lok,
                'status' => 'Selesai',
                'reporter' => 'Tim Lapangan',
                'durasi' => null,
                'tanggal_rencana' => '2025-09-02',
                'tanggal_tayang' => null,
                'views' => 0,
            ];
        }

        // 10 Berita Dalam Proses
        $lokasiDalamProses = ['Ambon', 'Maluku Tengah', 'SBB', 'SBT', 'Buru', 'Ambon', 'Maluku Tengah', 'SBB', 'SBT', 'Buru'];
        for ($i = 0; $i < 10; $i++) {
            $beritaList[] = [
                'judul' => "Liputan Dalam Proses di " . $lokasiDalamProses[$i] . " #" . ($i + 1),
                'kategori' => null,
                'jenis' => null,
                'lokasi' => $lokasiDalamProses[$i],
                'status' => 'Dalam Proses',
                'reporter' => 'Tim Lapangan',
                'durasi' => null,
                'tanggal_rencana' => '2025-09-02',
                'tanggal_tayang' => null,
                'views' => 0,
            ];
        }

        // 5 Berita Terkendala
        $kendala = [
            'Liputan Tertunda di SBT (Kendala Cuaca Buruk)',
            'Liputan SBB - Konfirmasi Narasumber Tertunda',
            'Liputan Buru Selatan - Kendala Transportasi Laut',
            'Liputan Kepulauan Aru - Jaringan Komunikasi Terputus',
            'Liputan Maluku Barat Daya - Gelombang Pasang Pesisir'
        ];
        $lokasiTerkendala = ['SBT', 'SBB', 'Buru Selatan', 'Kep. Aru', 'Maluku Barat Daya'];
        for ($i = 0; $i < 5; $i++) {
            $beritaList[] = [
                'judul' => $kendala[$i],
                'kategori' => null,
                'jenis' => null,
                'lokasi' => $lokasiTerkendala[$i],
                'status' => 'Terkendala',
                'reporter' => 'Tim Koresponden',
                'durasi' => null,
                'tanggal_rencana' => '2025-09-02',
                'tanggal_tayang' => null,
                'views' => 0,
            ];
        }

        // 3 Berita Batal
        $batal = [
            'Liputan Agenda Kunjungan Kerja Dibatalkan Protokol',
            'Liputan Pameran Seni Batal (Acara Diundur Panitia)',
            'Liputan Turnamen Lokal Batal (Kondisi Lapangan)'
        ];
        $lokasiBatal = ['Ambon', 'Maluku Tengah', 'Kota Tual'];
        for ($i = 0; $i < 3; $i++) {
            $beritaList[] = [
                'judul' => $batal[$i],
                'kategori' => null,
                'jenis' => null,
                'lokasi' => $lokasiBatal[$i],
                'status' => 'Batal',
                'reporter' => 'Tim Redaksi',
                'durasi' => null,
                'tanggal_rencana' => '2025-09-02',
                'tanggal_tayang' => null,
                'views' => 0,
            ];
        }

        // Pisahkan 5 Berita Terbaru agar di-insert di paling akhir sehingga ID-nya tertinggi
        $latestTitles = [
            'Festival Budaya Pela Gandong di Ambon',
            'Bantuan UMKM untuk Nelayan di Seram',
            'Perbaikan Jalan di SBB Terus Dikebut',
            'Sekolah di Kep. Aru Dapat Bantuan Fasilitas',
            'Harga Pangan di Maluku Stabil',
        ];

        // Pengaturan khusus untuk 5 berita terbaru agar persis sesuai prompt
        $latestMeta = [
            'Festival Budaya Pela Gandong di Ambon' => ['durasi' => '02:35', 'lokasi' => 'Ambon', 'tanggal' => '2025-09-02', 'kategori' => 'Budaya', 'jenis' => 'Feature', 'views' => 125400],
            'Bantuan UMKM untuk Nelayan di Seram' => ['durasi' => '01:48', 'lokasi' => 'Maluku Tengah', 'tanggal' => '2025-09-02', 'kategori' => 'Ekonomi & UMKM', 'jenis' => 'Berita Reguler', 'views' => 24000],
            'Perbaikan Jalan di SBB Terus Dikebut' => ['durasi' => '03:12', 'lokasi' => 'SBB', 'tanggal' => '2025-09-02', 'kategori' => 'Pemerintahan', 'jenis' => 'Live Report', 'views' => 21000],
            'Sekolah di Kep. Aru Dapat Bantuan Fasilitas' => ['durasi' => '03:21', 'lokasi' => 'Kep. Aru', 'tanggal' => '2025-09-01', 'kategori' => 'Pendidikan', 'jenis' => 'Berita Reguler', 'views' => 19500],
            'Harga Pangan di Maluku Stabil' => ['durasi' => '01:55', 'lokasi' => 'Ambon', 'tanggal' => '2025-09-01', 'kategori' => 'Ekonomi & UMKM', 'jenis' => 'Berita Reguler', 'views' => 98700],
        ];

        $normalItems = [];
        $latestItems = [];

        foreach ($beritaList as $item) {
            if (in_array($item['judul'], $latestTitles)) {
                $item['durasi'] = $latestMeta[$item['judul']]['durasi'];
                $item['lokasi'] = $latestMeta[$item['judul']]['lokasi'];
                $item['kategori'] = $latestMeta[$item['judul']]['kategori'];
                $item['jenis'] = $latestMeta[$item['judul']]['jenis'];
                $item['tanggal_rencana'] = $latestMeta[$item['judul']]['tanggal'];
                $item['tanggal_tayang'] = $latestMeta[$item['judul']]['tanggal'];
                $item['views'] = $latestMeta[$item['judul']]['views'];
                $latestItems[$item['judul']] = $item;
            } else {
                $normalItems[] = $item;
            }
        }

        // Simpan berita normal
        foreach ($normalItems as $item) {
            TvriBerita::create($item);
        }

        // Simpan 5 Berita Terbaru paling akhir
        $order = [
            'Harga Pangan di Maluku Stabil',
            'Sekolah di Kep. Aru Dapat Bantuan Fasilitas',
            'Perbaikan Jalan di SBB Terus Dikebut',
            'Bantuan UMKM untuk Nelayan di Seram',
            'Festival Budaya Pela Gandong di Ambon',
        ];
        foreach ($order as $title) {
            if (isset($latestItems[$title])) {
                TvriBerita::create($latestItems[$title]);
            }
        }

        // Presisikan views agar jumlah totalnya persis 1.200.000
        $sumViews = (int) TvriBerita::sum('views');
        $selisih = 1200000 - $sumViews;
        if ($selisih !== 0) {
            $adjustTarget = TvriBerita::where('views', '>', 5000)->where('views', '<', 20000)->first();
            if ($adjustTarget) {
                $adjustTarget->increment('views', $selisih);
            }
        }

        // 6. Update Ringkasan Berita Periode September 2025
        TvriBeritaRingkasan::updateOrCreate(
            ['periode' => 'September 2025'],
            [
                'rencana_liputan' => 120,
                'liputan_dilakukan' => 102,
                'berita_diproduksi' => 95,
                'berita_tayang' => 92,
                'views_digital' => 1200000,
                'performance_index' => 92,
                'kecepatan_publikasi_menit' => 45,
                'dist_tv' => 92,
                'dist_website' => 95,
                'dist_youtube' => 82,
                'dist_instagram' => 60,
                'dist_tiktok' => 48,
                'kualitas_fakta' => 98,
                'kualitas_etik' => 96,
                'kualitas_akurasi' => 97,
                'kualitas_visual' => 94,
                'kualitas_sop' => 95,
            ]
        );
    }
}
