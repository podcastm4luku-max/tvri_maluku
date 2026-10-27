@extends('layouts.app')

@section('title', 'Executive Command Center - TVRI Maluku')

@php
    $idr = fn ($v) => 'Rp ' . number_format($v / 1e6, 1) . ' Jt';
    $ringColor = fn ($s) => $s >= 90 ? '#22c55e' : ($s >= 75 ? '#eab308' : '#ef4444');
    $unitColor = [
        'blue' => 'bg-blue-500', 'emerald' => 'bg-emerald-500', 'cyan' => 'bg-cyan-500', 'amber' => 'bg-amber-500',
        'teal' => 'bg-teal-500', 'orange' => 'bg-orange-500', 'purple' => 'bg-purple-500', 'rose' => 'bg-rose-500',
        'pink' => 'bg-pink-500', 'indigo' => 'bg-indigo-500',
    ];
@endphp

@section('content')
<div class="space-y-5">

    <!-- ===== HEADER ECC ===== -->
    <div class="bg-gradient-to-r from-[#001D38] via-[#00264A] to-[#003B70] rounded-3xl p-6 sm:p-7 text-white shadow-xl relative overflow-hidden border border-blue-400/20">
        <div class="absolute -right-10 -top-16 w-72 h-72 bg-cyan-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-2xl bg-white p-2 shadow-lg flex-shrink-0">
                    <img src="{{ asset('images/logo_tvri.png') }}" alt="Logo TVRI" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-black tracking-tight uppercase leading-tight">Executive Command Center</h1>
                    <p class="text-sm font-extrabold text-cyan-300 tracking-widest uppercase">TVRI Maluku</p>
                    <p class="text-[11px] text-blue-200 font-semibold mt-1">SATU DATA, SATU ARAH, UNTUK PENYIARAN YANG LEBIH KUAT</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/10 text-right">
                    <p class="text-[10px] text-blue-200 font-bold uppercase tracking-wider">Hari Ini</p>
                    <p class="text-xs font-extrabold text-white global-live-datetime-bullet">{{ now()->isoFormat('dddd, D MMMM Y') }} &bull; {{ now()->format('H:i') }} WIT</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-[11px] font-bold text-emerald-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> LIVE DATA
                </span>
            </div>
        </div>
    </div>

    <!-- ===== KPI STRIP ===== -->
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3">
        <div class="bg-[#00264A] rounded-2xl p-4 text-white shadow-lg col-span-2 sm:col-span-1 flex items-center justify-between border border-blue-400/20">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-cyan-300">TVRI Maluku Performance Index</p>
                <p class="text-3xl font-black mt-1">{{ $performanceIndex }}<span class="text-sm font-bold text-blue-300"> / 100</span></p>
                <p class="text-[10px] font-semibold {{ $performanceIndex >= 90 ? 'text-emerald-400' : 'text-amber-400' }} mt-0.5">{{ $performanceIndex >= 90 ? 'Sangat Baik' : 'Baik' }} &bull; On Track</p>
            </div>
            <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background: conic-gradient({{ $ringColor($performanceIndex) }} {{ $performanceIndex * 3.6 }}deg, rgba(255,255,255,.12) 0deg);">
                <div class="w-10 h-10 rounded-full bg-[#00264A] flex items-center justify-center text-[11px] font-black">{{ $performanceIndex }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">PNBP</p>
            <p class="text-2xl font-black text-[#00264A] mt-1">{{ $pctPnbp }}%</p>
            <p class="text-[11px] text-slate-500 font-semibold">{{ $idr($pnbpRealisasi) }} / target {{ $idr($pnbpTarget) }}</p>
            <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold {{ $pctPnbp >= 90 ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $pctPnbp >= 90 ? 'ON TRACK' : 'PERLU PERHATIAN' }}</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Program & Siaran</p>
            <p class="text-2xl font-black text-[#00264A] mt-1">{{ $pctProgram }}%</p>
            <p class="text-[11px] text-slate-500 font-semibold">{{ $programTayang }} / {{ $programTotal }} Program</p>
            <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-700">ON TRACK</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Audiens & Digital</p>
            <p class="text-2xl font-black text-[#00264A] mt-1">{{ number_format($kontenViews / 1e6, 1) }} Jt</p>
            <p class="text-[11px] text-slate-500 font-semibold">Views &bull; Reach {{ number_format($kontenReach / 1e6, 1) }} Jt</p>
            <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-700">ON TRACK</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Keuangan</p>
            <p class="text-2xl font-black text-[#00264A] mt-1">{{ $pctAnggaran }}%</p>
            <p class="text-[11px] text-slate-500 font-semibold">Serapan {{ $idr($realisasiAnggaran) }} / {{ $idr($pagu) }}</p>
            <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold {{ $pctAnggaran >= 60 ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $pctAnggaran >= 60 ? 'ON TRACK' : 'PERLU PERHATIAN' }}</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Technical Readiness</p>
            <p class="text-2xl font-black text-[#00264A] mt-1">{{ round($alatBaik / max(1, $alatTotal) * 100) }}%</p>
            <p class="text-[11px] text-slate-500 font-semibold">Sistem Siap Siar</p>
            <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-700">ON TRACK</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Operasional & Aset</p>
            <p class="text-2xl font-black text-[#00264A] mt-1">{{ round($asetBaik / max(1, $totalAset) * 100) }}%</p>
            <p class="text-[11px] text-slate-500 font-semibold">Fasilitas & Layanan</p>
            <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-700">ON TRACK</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tata Kelola & Administrasi</p>
            <p class="text-2xl font-black text-[#00264A] mt-1">{{ $suratMasuk + $suratKeluar }}</p>
            <p class="text-[11px] text-slate-500 font-semibold">Surat Terkelola &bull; {{ $layananAdm }} Layanan</p>
            <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-100 text-emerald-700">ON TRACK</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border {{ $criticalCount > 0 ? 'border-rose-300 bg-rose-50/50' : 'border-slate-200/80' }} shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Critical Issues</p>
            <p class="text-2xl font-black mt-1 {{ $criticalCount > 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $criticalCount }}</p>
            <p class="text-[11px] text-slate-500 font-semibold">Perlu Tindak Lanjut</p>
            <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[9px] font-extrabold {{ $criticalCount > 0 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">{{ $criticalCount > 0 ? 'CRITICAL' : 'NORMAL' }}</span>
        </div>
    </div>

    <!-- ===== KINERJA UNIT + SIDE PANELS ===== -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <!-- KINERJA SETIAP UNIT KERJA -->
        <div class="xl:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-5 py-3.5 bg-gradient-to-r from-[#00264A] to-[#005B9F] flex items-center justify-between">
                <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">Kinerja Setiap Unit Kerja</h3>
                <span class="text-[10px] font-bold text-blue-200">{{ count($units) }} Bidang &bull; Real-time</span>
            </div>
            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($units as $u)
                <a href="{{ route('tvri.' . $u['key'] . '.dashboard') }}" class="group border border-slate-200 rounded-2xl p-3.5 hover:border-[#005B9F] hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[11px] font-extrabold uppercase text-[#00264A]">{{ $u['nama'] }}</p>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black {{ $u['skor'] >= 90 ? 'bg-emerald-100 text-emerald-700' : ($u['skor'] >= 75 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $u['skor'] >= 90 ? 'bg-emerald-500' : ($u['skor'] >= 75 ? 'bg-amber-500' : 'bg-rose-500') }}"></span>{{ $u['skor'] }}%
                        </span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden mb-2.5">
                        <div class="h-full {{ $unitColor[$u['warna']] ?? 'bg-blue-500' }} rounded-full" style="width: {{ min(100, $u['skor']) }}%"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-1.5">
                        @foreach($u['metrics'] as $m)
                        <div class="bg-slate-50 rounded-lg px-1.5 py-1.5 text-center">
                            <p class="text-[9px] font-semibold text-slate-400 uppercase leading-tight">{{ $m['label'] }}</p>
                            <p class="text-[11px] font-black text-[#00264A] mt-0.5">{{ $m['value'] }}</p>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-[10px] font-bold text-[#005B9F] group-hover:text-[#003B70] mt-2 text-right">Lihat Dashboard Bidang &rarr;</p>
                </a>
                @endforeach
            </div>
        </div>

        <!-- PANEL KANAN -->
        <div class="space-y-5">
            <!-- CAPAIAN PNBP -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 bg-gradient-to-r from-[#00264A] to-[#005B9F]">
                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">Capaian PNBP Tahun Berjalan</h3>
                </div>
                <div class="p-5">
                    <p class="text-2xl font-black text-[#00264A]">{{ $idr($pnbpRealisasi) }}</p>
                    <p class="text-[11px] font-semibold text-slate-500 mb-3">dari Target {{ $idr($pnbpTarget) }}</p>
                    <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#005B9F] to-cyan-400 rounded-full" style="width: {{ min(100, $pctPnbp) }}%"></div>
                    </div>
                    <p class="text-[10px] font-bold text-slate-500 mt-1.5 text-right">{{ $pctPnbp }}%</p>
                </div>
            </div>

            <!-- REALISASI ANGGARAN -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 bg-gradient-to-r from-[#00264A] to-[#005B9F]">
                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">Realisasi Anggaran</h3>
                </div>
                <div class="p-5">
                    <p class="text-2xl font-black text-[#00264A]">{{ $idr($realisasiAnggaran) }}</p>
                    <p class="text-[11px] font-semibold text-slate-500 mb-3">dari Pagu {{ $idr($pagu) }} &bull; Sisa {{ $idr($pagu - $realisasiAnggaran) }}</p>
                    <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width: {{ min(100, $pctAnggaran) }}%"></div>
                    </div>
                    <p class="text-[10px] font-bold text-slate-500 mt-1.5 text-right">{{ $pctAnggaran }}%</p>
                </div>
            </div>

            <!-- STATUS OPERASIONAL -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 bg-gradient-to-r from-[#00264A] to-[#005B9F]">
                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">Status Operasional</h3>
                </div>
                <div class="p-5 grid grid-cols-4 gap-3 text-center">
                    @php
                        $op = [
                            ['label' => 'Siapan Studio', 'pct' => round($alatBaik / max(1, $alatTotal) * 100)],
                            ['label' => 'Transmisi Stabil', 'pct' => round($siteOnAir / max(1, $siteTotal) * 100)],
                            ['label' => 'Fasilitas Layak', 'pct' => round($asetBaik / max(1, $totalAset) * 100)],
                            ['label' => 'Kendaraan Siap', 'pct' => round($kendaraanSiap / max(1, $kendaraanTotal) * 100)],
                        ];
                    @endphp
                    @foreach($op as $o)
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background: conic-gradient({{ $ringColor($o['pct']) }} {{ $o['pct'] * 3.6 }}deg, #e2e8f0 0deg);">
                            <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center text-[11px] font-black text-[#00264A]">{{ $o['pct'] }}%</div>
                        </div>
                        <p class="text-[9px] font-bold text-slate-500 uppercase mt-1.5 leading-tight">{{ $o['label'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ALERTS + ACTION REQUIRED ===== -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-5 py-3.5 bg-gradient-to-r from-rose-700 to-[#005B9F] flex items-center justify-between">
                <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">Top Executive Alerts</h3>
                <span class="text-[10px] font-bold bg-white/20 text-white px-2 py-0.5 rounded-full">{{ $criticalCount }} Kritis &bull; {{ count($alerts) - $criticalCount }} Perhatian</span>
            </div>
            <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto">
                @forelse($alerts as $a)
                <div class="px-5 py-3 flex items-start gap-3">
                    <span class="mt-1 w-2.5 h-2.5 rounded-full flex-shrink-0 {{ $a['prioritas'] === 'Kritis' ? 'bg-rose-500' : 'bg-amber-400' }}"></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ $a['isu'] }}</p>
                        <p class="text-[10px] text-slate-500 font-semibold">Unit: {{ $a['unit'] }} &bull; Dampak: {{ $a['dampak'] }}</p>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold flex-shrink-0 {{ $a['prioritas'] === 'Kritis' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }}">{{ strtoupper($a['prioritas']) }}</span>
                </div>
                @empty
                <div class="px-5 py-8 text-center text-xs font-semibold text-slate-400">Tidak ada alert. Seluruh unit dalam kondisi normal.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-5 py-3.5 bg-gradient-to-r from-[#00264A] to-[#005B9F]">
                <h3 class="text-xs font-extrabold uppercase tracking-widest text-white">Agenda & Aktivitas Terkini</h3>
            </div>
            <div class="p-5 space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <p class="text-[9px] font-bold uppercase text-slate-400">Agenda Hari Ini</p>
                        <p class="text-lg font-black text-[#00264A]">{{ $agendaHariIni }} Kegiatan</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <p class="text-[9px] font-bold uppercase text-slate-400">Layanan Administrasi</p>
                        <p class="text-lg font-black text-[#00264A]">{{ $layananAdm }} Permohonan</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <p class="text-[9px] font-bold uppercase text-slate-400">Mitra / Klien Aktif</p>
                        <p class="text-lg font-black text-[#00264A]">{{ $mitraAktif }} Mitra</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <p class="text-[9px] font-bold uppercase text-slate-400">Kampanye Promo</p>
                        <p class="text-lg font-black text-[#00264A]">{{ $kampanyeTotal }} Aktif</p>
                    </div>
                </div>
                <div class="border border-slate-100 rounded-xl p-3.5">
                    <p class="text-[10px] font-extrabold uppercase text-slate-400 mb-2">Ringkasan Siaran</p>
                    <div class="flex items-center justify-between text-center">
                        <div><p class="text-sm font-black text-emerald-600">{{ $siteOnAir }}</p><p class="text-[9px] font-bold text-slate-400 uppercase">Site On-Air</p></div>
                        <div><p class="text-sm font-black text-amber-600">{{ $siteGangguan }}</p><p class="text-[9px] font-bold text-slate-400 uppercase">Gangguan</p></div>
                        <div><p class="text-sm font-black text-[#00264A]">{{ number_format((float) $kualitasRata, 1) }}</p><p class="text-[9px] font-bold text-slate-400 uppercase">Kualitas Sinyal</p></div>
                        <div><p class="text-sm font-black text-[#00264A]">{{ $beritaTayang }}</p><p class="text-[9px] font-bold text-slate-400 uppercase">Berita Tayang</p></div>
                        <div><p class="text-sm font-black text-[#00264A]">{{ $programTayang }}</p><p class="text-[9px] font-bold text-slate-400 uppercase">Program Tayang</p></div>
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 font-semibold text-center">Data setiap unit bersumber dari dashboard bidang masing-masing dan tervalidasi otomatis ke Command Center.</p>
            </div>
        </div>
    </div>
</div>
@endsection
