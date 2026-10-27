<?php

namespace App\Http\Controllers\Tvri;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EccDashboardController extends Controller
{
    public function index()
    {
        // ===== TATA USAHA =====
        $ringkasanTu = \App\Models\TvriTuRingkasan::first();
        $suratMasuk = $ringkasanTu ? $ringkasanTu->surat_masuk : DB::table('tvri_surat_masuks')->count();
        $suratMasukSelesai = $ringkasanTu ? $ringkasanTu->disposisi_selesai : DB::table('tvri_surat_masuks')->where('status', 'Selesai')->count();
        $suratKeluar = $ringkasanTu ? $ringkasanTu->surat_keluar : DB::table('tvri_surat_keluars')->count();
        $layananAdm = $ringkasanTu ? $ringkasanTu->layanan_adm : (int) DB::table('tvri_layanan_adms')->sum('jumlah');
        $agendaHariIni = $ringkasanTu ? $ringkasanTu->agenda_kegiatan : DB::table('tvri_agenda_kegiatans')->whereDate('tanggal', today())->count();

        // ===== UMUM & LOGISTIK =====
        $ringkasanUmum = \App\Models\TvriUmumRingkasan::first();
        $totalAset = $ringkasanUmum ? $ringkasanUmum->total_aset : (int) DB::table('tvri_asets')->sum('jumlah');
        $asetBaik = $ringkasanUmum ? $ringkasanUmum->aset_baik : (int) DB::table('tvri_asets')->where('kondisi', 'Baik')->sum('jumlah');
        $kendaraanTotal = $ringkasanUmum ? $ringkasanUmum->kendaraan_total : DB::table('tvri_kendaraans')->count();
        $kendaraanSiap = $ringkasanUmum ? $ringkasanUmum->kendaraan_siap : DB::table('tvri_kendaraans')->where('status', 'Siap Operasi')->count();
        $permintaanTotal = $ringkasanUmum ? $ringkasanUmum->permintaan_total : DB::table('tvri_permintaan_layanans')->count();
        $permintaanSelesai = $ringkasanUmum ? $ringkasanUmum->permintaan_selesai : DB::table('tvri_permintaan_layanans')->where('status', 'Selesai')->count();

        // ===== TRANSMISI =====
        $ringkasanTransmisi = \App\Models\TvriTransmisiRingkasan::first();
        $siteTotal = $ringkasanTransmisi ? $ringkasanTransmisi->total_site : DB::table('tvri_stasiun_pemancars')->count();
        $siteOnAir = DB::table('tvri_stasiun_pemancars')->where('status', 'On-Air')->count() ?: ($ringkasanTransmisi ? round($ringkasanTransmisi->total_site * $ringkasanTransmisi->on_air_pct / 100) : 28);
        $siteGangguan = DB::table('tvri_stasiun_pemancars')->whereIn('status', ['Gangguan', 'Maintenance'])->count() ?: ($ringkasanTransmisi ? $ringkasanTransmisi->gangguan_aktif : 2);
        $kualitasRata = $ringkasanTransmisi ? $ringkasanTransmisi->kualitas_rata : (DB::table('tvri_stasiun_pemancars')->avg('kualitas') ?? 4.6);
        $gangguanAktif = $ringkasanTransmisi ? $ringkasanTransmisi->gangguan_aktif : DB::table('tvri_gangguans')->where('status', 'Proses')->count();
        $pctTransmisi = $ringkasanTransmisi ? $ringkasanTransmisi->on_air_pct : ($siteTotal > 0 ? round($siteOnAir / $siteTotal * 100) : 100);

        // ===== TEKNIK =====
        $ringkasanTeknik = \App\Models\TvriTeknikRingkasan::first();
        $alatTotal = 78; // 24 kamera + 12 editing + 8 server + 16 transmisi + 6 genset + 12 software
        $alatBaik = 71; // 21 + 11 + 7 + 15 + 5 + 12
        $insidenHariIni = $ringkasanTeknik ? (int) $ringkasanTeknik->insiden_hari_ini : 1;
        $pemeliharaanProses = 1; // Studio 4 dalam perbaikan
        $skorTeknik = $ringkasanTeknik ? (int) $ringkasanTeknik->readiness_overall : 94; // Technical Readiness Index 94% (Sangat Baik)

        // ===== KEUANGAN =====
        $currentYear = (int) date('Y');
        $ringkasanKeuangan = \App\Models\TvriKeuanganRingkasan::where('tahun', $currentYear)->first()
            ?? \App\Models\TvriKeuanganRingkasan::latest('tahun')->first();
        $pagu = $ringkasanKeuangan ? (float) $ringkasanKeuangan->pagu_anggaran : ((float) DB::table('tvri_anggarans')->where('tahun', $currentYear)->sum('pagu') ?: 45750000000);
        $realisasiAnggaran = $ringkasanKeuangan ? (float) $ringkasanKeuangan->realisasi_anggaran : ((float) DB::table('tvri_anggarans')->where('tahun', $currentYear)->sum('realisasi') ?: 34356500000);
        $sisaAnggaran = max(0, $pagu - $realisasiAnggaran);
        $pctAnggaran = $pagu > 0 ? round(($realisasiAnggaran / $pagu) * 100, 2) : 75.1;
        $piutangTotal = $ringkasanKeuangan ? (float) $ringkasanKeuangan->piutang_tagihan : ((float) DB::table('tvri_piutangs')->sum('nilai') ?: 425000000);
        $piutangBelumBayar = DB::table('tvri_piutangs')->where('status', 'Belum Bayar')->count();
        $ikpaSkor = $ringkasanKeuangan ? (float) $ringkasanKeuangan->ikpa_skor : 92.13;

        // ===== PENGEMBANGAN USAHA =====
        $ringkasanUsaha = \App\Models\TvriUsahaRingkasan::first();
        $pnbpTarget = $ringkasanUsaha ? (float) $ringkasanUsaha->target_pendapatan : (float) DB::table('tvri_pnbps')->sum('target');
        $pnbpRealisasi = $ringkasanUsaha ? (float) $ringkasanUsaha->total_pendapatan : (float) DB::table('tvri_pnbps')->sum('realisasi');
        $pctPnbp = $ringkasanUsaha ? (float) $ringkasanUsaha->capaian_target : ($pnbpTarget > 0 ? round($pnbpRealisasi / $pnbpTarget * 100, 1) : 0);
        $mitraAktif = $ringkasanUsaha ? (int) $ringkasanUsaha->jumlah_mitra : DB::table('tvri_mitras')->where('status', 'Aktif')->count();
        $kegiatanUsaha = $ringkasanUsaha ? (int) $ringkasanUsaha->kegiatan_usaha : DB::table('tvri_kegiatan_usahas')->count();
        $indeksKinerjaUsaha = $ringkasanUsaha ? (int) $ringkasanUsaha->indeks_kinerja : 82;

        // ===== PROGRAM =====
        $progRingkasan = Schema::hasTable('tvri_program_ringkasans') ? DB::table('tvri_program_ringkasans')->latest()->first() : null;
        $programTotal = $progRingkasan->total_direncanakan ?? DB::table('tvri_programs')->count();
        $programTayang = $progRingkasan->tayang ?? DB::table('tvri_programs')->where('status', 'Tayang')->count();
        $programProduksi = $progRingkasan->dalam_produksi ?? (DB::table('tvri_programs')->whereIn('status', ['Dalam Produksi', 'Produksi', 'Pra Produksi', 'Pasca Produksi', 'Editing'])->count() ?: 18);
        $programTerlambat = $progRingkasan->terlambat ?? DB::table('tvri_programs')->where('status', 'Terlambat')->count();
        $pctProgram = $progRingkasan->schedule_compliance ?? 94;

        // ===== BERITA =====
        $beritaRencana = DB::table('tvri_beritas')->count();
        $beritaSelesai = DB::table('tvri_beritas')->where('status', 'Selesai')->count();
        $beritaTayang = DB::table('tvri_beritas')->whereNotNull('tanggal_tayang')->count();
        $beritaTerkendala = DB::table('tvri_beritas')->where('status', 'Terkendala')->count();
        $pctBerita = $beritaRencana > 0 ? round($beritaSelesai / $beritaRencana * 100) : 0;

        // ===== KONTEN MEDIA BARU =====
        $ringkasanKmb = \App\Models\TvriKmbRingkasan::first();
        $kontenTotal = $ringkasanKmb ? (int) $ringkasanKmb->total_konten : DB::table('tvri_kontens')->count();
        $kontenViews = $ringkasanKmb ? (int) $ringkasanKmb->total_views : (int) DB::table('tvri_kontens')->sum('views');
        $kontenReach = $ringkasanKmb ? (int) $ringkasanKmb->total_reach : (int) DB::table('tvri_kontens')->sum('reach');
        $kontenEngagement = $ringkasanKmb ? (int) $ringkasanKmb->engagement : (int) DB::table('tvri_kontens')->sum('engagement');

        // ===== PROMO =====
        $ringkasanPromo = \Illuminate\Support\Facades\Schema::hasTable('tvri_promo_ringkasans') ? \App\Models\TvriPromoRingkasan::first() : null;
        $kampanyeTotal = $ringkasanPromo ? $ringkasanPromo->total_kampanye : DB::table('tvri_kampanyes')->count();
        $materiTotal = $ringkasanPromo ? $ringkasanPromo->materi_diproduksi : DB::table('tvri_materi_promos')->count();
        $materiSelesai = $ringkasanPromo && isset($ringkasanPromo->status_produksi_json['items'][0]['jumlah'])
            ? (int) $ringkasanPromo->status_produksi_json['items'][0]['jumlah']
            : DB::table('tvri_materi_promos')->where('status', 'Selesai')->count();
        $kampanyeReach = 1800000; // 1,8 Juta (+42%)
        $kampanyeEngagement = 286000; // 286 Ribu (+35%)
        $penayanganSpot = $ringkasanPromo ? $ringkasanPromo->penayangan_onair : '1.230 spot';
        $pctPromo = $ringkasanPromo ? (int) $ringkasanPromo->tingkat_capaian : 92;
        $reachPromoLabel = $ringkasanPromo ? $ringkasanPromo->reach_total : '1,8 Jt';

        $pct = fn ($a, $b) => $b > 0 ? min(100, round($a / $b * 100)) : 0;

        // ===== SKOR KINERJA PER UNIT KERJA =====
        $units = [
            ['key' => 'tu', 'nama' => 'Tata Usaha', 'ikon' => 'clipboard', 'warna' => 'blue',
             'skor' => $ringkasanTu ? (int) $ringkasanTu->service_completion_rate : $pct($suratMasukSelesai + $permintaanSelesai, max(1, $suratMasuk + $permintaanTotal)),
             'metrics' => [
                 ['label' => 'Surat Masuk', 'value' => number_format($suratMasuk)],
                 ['label' => 'Disposisi Selesai', 'value' => ($ringkasanTu ? $ringkasanTu->disposisi_selesai . ' / ' . $ringkasanTu->disposisi : $pct($suratMasukSelesai, max(1, $suratMasuk)) . '%')],
                 ['label' => 'Service Rate', 'value' => ($ringkasanTu ? $ringkasanTu->service_completion_rate . '%' : '94%')]
             ]],
            ['key' => 'umum', 'nama' => 'Umum', 'ikon' => 'building', 'warna' => 'emerald',
             'skor' => $ringkasanUmum ? (int) $ringkasanUmum->operational_readiness : $pct($asetBaik + $kendaraanSiap, max(1, $totalAset + $kendaraanTotal)),
             'metrics' => [
                 ['label' => 'Aset Siap Pakai', 'value' => number_format($asetBaik) . ' / ' . number_format($totalAset)],
                 ['label' => 'Kendaraan Siap', 'value' => $kendaraanSiap . ' / ' . $kendaraanTotal],
                 ['label' => 'Layanan Selesai', 'value' => $permintaanSelesai . ' / ' . $permintaanTotal]
             ]],
            ['key' => 'transmisi', 'nama' => 'Transmisi', 'ikon' => 'broadcast', 'warna' => 'cyan',
             'skor' => $pctTransmisi,
             'metrics' => [
                 ['label' => 'Site On-Air', 'value' => $siteOnAir . ' / ' . $siteTotal],
                 ['label' => 'Kualitas Rata-rata', 'value' => number_format((float) $kualitasRata, 1) . ' / 5 (' . ($ringkasanTransmisi->kualitas_diff ?? '+0.2') . ')'],
                 ['label' => 'Gangguan Aktif', 'value' => $gangguanAktif . ' (' . ($ringkasanTransmisi->gangguan_diff ?? '-60%') . ')']
             ]],
            ['key' => 'teknik', 'nama' => 'Teknik', 'ikon' => 'wrench', 'warna' => 'amber',
             'skor' => $skorTeknik,
             'metrics' => [['label' => 'Technical Readiness', 'value' => $skorTeknik . '%'], ['label' => 'Peralatan Siap', 'value' => $alatBaik . ' / ' . $alatTotal], ['label' => 'Insiden Hari Ini', 'value' => $insidenHariIni]]],
            ['key' => 'keuangan', 'nama' => 'Keuangan', 'ikon' => 'money', 'warna' => 'teal',
             'skor' => (int) round($pctAnggaran),
             'metrics' => [
                 ['label' => 'Serapan Anggaran', 'value' => number_format($pctAnggaran, 1, ',', '.') . '%'],
                 ['label' => 'Realisasi', 'value' => 'Rp ' . number_format($realisasiAnggaran / 1e9, 2, ',', '.') . ' M'],
                 ['label' => 'Sisa Anggaran', 'value' => 'Rp ' . number_format($sisaAnggaran / 1e9, 2, ',', '.') . ' M'],
                 ['label' => 'Nilai IKPA', 'value' => number_format($ikpaSkor, 2, ',', '.') . ' (Sangat Baik)']
             ]],
            ['key' => 'usaha', 'nama' => 'Pengembangan Usaha', 'ikon' => 'handshake', 'warna' => 'orange',
             'skor' => (int) round($pctPnbp),
             'metrics' => [
                 ['label' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($pnbpRealisasi / 1e6, 0) . ' Jt'],
                 ['label' => 'Capaian Target', 'value' => $pctPnbp . '% (' . ($ringkasanUsaha->diff_total_pendapatan ?? '+18.6%') . ')'],
                 ['label' => 'Mitra / Klien', 'value' => $mitraAktif . ' Mitra']
             ]],
            ['key' => 'program', 'nama' => 'Program & Siaran', 'ikon' => 'tv', 'warna' => 'purple',
             'skor' => $pctProgram,
             'metrics' => [
                 ['label' => 'Program Tayang', 'value' => $programTayang . ' / ' . $programTotal],
                 ['label' => 'Schedule Compliance', 'value' => $pctProgram . '%'],
                 ['label' => 'Dalam Produksi', 'value' => $programProduksi]
             ]],
            ['key' => 'berita', 'nama' => 'Berita', 'ikon' => 'news', 'warna' => 'rose',
             'skor' => $pctBerita,
             'metrics' => [
                 ['label' => 'Berita Tayang', 'value' => $beritaTayang],
                 ['label' => 'Current Affairs', 'value' => DB::table('tvri_beritas')->where('jenis', 'Current Affairs')->count()],
                 ['label' => 'Breaking News', 'value' => DB::table('tvri_beritas')->where('jenis', 'Breaking News')->count()]
             ]],
            ['key' => 'mbn', 'nama' => 'Konten Media Baru', 'ikon' => 'mobile', 'warna' => 'pink',
             'skor' => $ringkasanKmb ? min(100, 60 + (int) $ringkasanKmb->growth_rate) : min(100, 90 + (int) round($kontenTotal / 30)),
             'metrics' => [
                 ['label' => 'Total Konten', 'value' => number_format($kontenTotal) . ' Konten'],
                 ['label' => 'Total Views', 'value' => number_format($kontenViews / 1e6, 1) . ' Jt (' . ($ringkasanKmb->diff_total_views ?? '+35%') . ')'],
                 ['label' => 'Engagement', 'value' => number_format($kontenEngagement / 1e3, 0) . ' K (' . ($ringkasanKmb->diff_engagement ?? '+38%') . ')']
             ]],
            ['key' => 'promo', 'nama' => 'Promo', 'ikon' => 'megaphone', 'warna' => 'indigo',
             'skor' => $pctPromo,
             'metrics' => [['label' => 'Tingkat Capaian', 'value' => $pctPromo . '%'], ['label' => 'Total Kampanye', 'value' => $kampanyeTotal], ['label' => 'Reach Total', 'value' => $reachPromoLabel]]],
        ];

        $performanceIndex = count($units) ? (int) round(array_sum(array_column($units, 'skor')) / count($units)) : 0;

        // ===== TOP EXECUTIVE ALERTS =====
        $alerts = [];
        foreach (DB::table('tvri_stasiun_pemancars')->where('status', 'Gangguan')->get() as $s) {
            $alerts[] = ['prioritas' => 'Kritis', 'isu' => 'Transmitter ' . $s->nama . ' berstatus gangguan', 'unit' => 'Transmisi', 'dampak' => 'Risiko siaran'];
        }
        foreach (DB::table('tvri_gangguans')->where('status', 'Proses')->get() as $g) {
            $alerts[] = ['prioritas' => 'Kritis', 'isu' => $g->site . ': ' . $g->jenis . ' belum tertangani', 'unit' => 'Teknik', 'dampak' => 'Kualitas siaran'];
        }
        foreach (DB::table('tvri_piutangs')->where('status', 'Belum Bayar')->get() as $p) {
            $alerts[] = ['prioritas' => 'Perhatian', 'isu' => 'Piutang ' . $p->klien . ' (Rp ' . number_format($p->nilai / 1e6, 0) . ' Jt) belum tertagih', 'unit' => 'Keuangan', 'dampak' => 'Arus kas'];
        }
        if ($beritaTerkendala > 0) {
            $catatanWarning = DB::table('tvri_berita_catatans')->where('tipe', 'warning')->value('pesan');
            $alerts[] = ['prioritas' => 'Perhatian', 'isu' => $catatanWarning ?: ($beritaTerkendala . ' rencana liputan terkendala'), 'unit' => 'Berita', 'dampak' => 'Jadwal tayang'];
        }
        if ($programTerlambat > 0) {
            $alerts[] = ['prioritas' => 'Perhatian', 'isu' => $programTerlambat . ' program terlambat dari jadwal produksi', 'unit' => 'Program', 'dampak' => 'Schedule compliance'];
        }
        if ($pctPnbp < 75) {
            $alerts[] = ['prioritas' => 'Kritis', 'isu' => 'Capaian PNBP ' . $pctPnbp . '% masih di bawah 75%', 'unit' => 'Usaha', 'dampak' => 'Capaian tahunan'];
        } elseif ($pctPnbp < 85) {
            $alerts[] = ['prioritas' => 'Perhatian', 'isu' => 'Capaian PNBP ' . $pctPnbp . '% on-track menuju target tahunan', 'unit' => 'Usaha', 'dampak' => 'Optimalisasi sisa triwulan'];
        }

        $criticalCount = collect($alerts)->where('prioritas', 'Kritis')->count();

        return view('tvri.ecc', compact(
            'units', 'performanceIndex', 'alerts', 'criticalCount',
            'suratMasuk', 'suratKeluar', 'layananAdm', 'agendaHariIni',
            'totalAset', 'asetBaik', 'kendaraanSiap', 'kendaraanTotal', 'permintaanTotal', 'permintaanSelesai',
            'siteTotal', 'siteOnAir', 'siteGangguan', 'kualitasRata', 'gangguanAktif',
            'alatBaik', 'alatTotal', 'insidenHariIni', 'pemeliharaanProses',
            'pagu', 'realisasiAnggaran', 'pctAnggaran', 'piutangTotal', 'piutangBelumBayar',
            'pnbpTarget', 'pnbpRealisasi', 'pctPnbp', 'mitraAktif', 'kegiatanUsaha',
            'programTotal', 'programTayang', 'programTerlambat', 'pctProgram',
            'beritaRencana', 'beritaTayang', 'beritaTerkendala', 'pctBerita',
            'kontenTotal', 'kontenViews', 'kontenReach', 'kontenEngagement',
            'materiTotal', 'materiSelesai', 'kampanyeTotal', 'kampanyeReach', 'pctPromo'
        ));
    }
}
