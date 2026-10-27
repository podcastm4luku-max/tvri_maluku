@extends('layouts.app')

@section('title', 'Dashboard Tata Usaha - TVRI Maluku')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER UTAMA TATA USAHA ===== -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#001D38] via-[#002B54] to-[#004080] text-white shadow-2xl p-6 md:p-8 border border-blue-400/20">
        <div class="absolute -right-12 -top-16 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-16 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-start md:items-center space-x-4">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-white p-2.5 shadow-xl flex-shrink-0 flex items-center justify-center border border-white/20">
                    <img src="{{ asset('images/logo_tvri.png') }}" alt="Logo TVRI" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-cyan-300">TVRI MALUKU</span>
                        <span class="text-xs text-blue-200/60">•</span>
                        <span class="text-xs text-blue-200">Media Pemersatu Bangsa di Bumi Raja-Raja</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse mr-1"></span>
                            {{ $ringkasan->online_status ?? 'Online | Periode: September 2025' }}
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-black tracking-tight uppercase text-white drop-shadow-sm">
                        DASHBOARD TATA USAHA TVRI MALUKU
                    </h1>
                    <p class="text-xs md:text-sm font-semibold text-blue-100/90 mt-1">
                        {{ $ringkasan->slogan_header ?? 'TERTIB ADMINISTRASI • CEPAT LAYANAN • AKURAT DATA • MENDUKUNG KINERJA' }}
                        <span class="text-amber-300 font-bold ml-1">{{ $ringkasan->slogan_sub ?? 'Maluku Bisa!' }}</span>
                    </p>
                    <div class="flex items-center space-x-2 text-[11px] text-blue-200/80 mt-2 font-mono">
                        <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="global-live-datetime-pipe">{{ $ringkasan->header_waktu ?? 'Selasa, 2 September 2025 | 10:24 WIT' }}</span>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Cepat -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('tvri.tu.manage') }}"
                   class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-[#005B9F] hover:bg-[#004a82] text-white text-xs font-bold shadow-lg shadow-blue-900/30 border border-blue-400/30 transition-all hover:-translate-y-0.5">
                    <svg class="w-4 h-4 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Input & Kelola Data TU</span>
                </a>
                <a href="{{ route('tvri.ecc.dashboard') }}"
                   class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold backdrop-blur-md border border-white/20 transition-all">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Monitoring ECC</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ===== 6 METRIK UTAMA ATAS ===== -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
        <!-- 1. Surat Masuk -->
        <a href="#surat-masuk" class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8m-4-4l4 4-4 4"/></svg>
                </span>
                <span class="inline-flex items-center text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                    ▲ {{ $ringkasan->diff_surat_masuk ?? '+12%' }}
                </span>
            </div>
            <p class="text-2xl md:text-3xl font-black text-slate-800">{{ $ringkasan->surat_masuk ?? $suratMasukCount }}</p>
            <p class="text-xs font-bold text-slate-700 mt-0.5">Surat Masuk</p>
            <p class="text-[10px] text-slate-400 font-medium">Bulan September 2025</p>
        </a>

        <!-- 2. Surat Keluar -->
        <a href="#surat-keluar" class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <span class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8-4l4 4-4 4"/></svg>
                </span>
                <span class="inline-flex items-center text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                    ▲ {{ $ringkasan->diff_surat_keluar ?? '+8%' }}
                </span>
            </div>
            <p class="text-2xl md:text-3xl font-black text-slate-800">{{ $ringkasan->surat_keluar ?? $suratKeluarCount }}</p>
            <p class="text-xs font-bold text-slate-700 mt-0.5">Surat Keluar</p>
            <p class="text-[10px] text-slate-400 font-medium">Naskah dinas keluar</p>
        </a>

        <!-- 3. Disposisi -->
        <a href="#status-disposisi" class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </span>
                <span class="inline-flex items-center text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                    ▲ {{ $ringkasan->diff_disposisi ?? '+15%' }}
                </span>
            </div>
            <p class="text-2xl md:text-3xl font-black text-slate-800">{{ $ringkasan->disposisi ?? 110 }}</p>
            <p class="text-xs font-bold text-slate-700 mt-0.5">Disposisi</p>
            <p class="text-[10px] text-slate-400 font-medium">{{ $ringkasan->disposisi_selesai ?? 78 }} selesai diproses</p>
        </a>

        <!-- 4. Agenda Kegiatan -->
        <a href="#agenda" class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                <span class="inline-flex items-center text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                    ▲ {{ $ringkasan->diff_agenda ?? '+20%' }}
                </span>
            </div>
            <p class="text-2xl md:text-3xl font-black text-slate-800">{{ $ringkasan->agenda_kegiatan ?? $agendaCount }}</p>
            <p class="text-xs font-bold text-slate-700 mt-0.5">Agenda Kegiatan</p>
            <p class="text-[10px] text-slate-400 font-medium">Bulan September</p>
        </a>

        <!-- 5. Layanan Administrasi -->
        <a href="#layanan-adm" class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all group">
            <div class="flex items-center justify-between mb-2">
                <span class="w-8 h-8 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h6m-9 12h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                <span class="inline-flex items-center text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                    ▲ {{ $ringkasan->diff_layanan ?? '+10%' }}
                </span>
            </div>
            <p class="text-2xl md:text-3xl font-black text-slate-800">{{ $ringkasan->layanan_adm ?? $layananCount }}</p>
            <p class="text-xs font-bold text-slate-700 mt-0.5">Layanan Adm</p>
            <p class="text-[10px] text-slate-400 font-medium">SK, data & rekomendasi</p>
        </a>

        <!-- 6. Service Completion Rate -->
        <a href="#monitoring-kinerja" class="bg-white rounded-2xl p-4 border border-blue-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all group bg-gradient-to-br from-blue-50/50 to-white">
            <div class="flex items-center justify-between mb-2">
                <span class="w-8 h-8 rounded-xl bg-[#005B9F] text-white flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-blue-100 text-blue-800">TARGET {{ $ringkasan->target_completion_rate ?? 90 }}%</span>
            </div>
            <p class="text-2xl md:text-3xl font-black text-blue-900">{{ $ringkasan->service_completion_rate ?? 94 }}%</p>
            <p class="text-xs font-bold text-blue-950 mt-0.5">Service Completion</p>
            <p class="text-[10px] text-emerald-600 font-bold">▲ Sangat Memuaskan</p>
        </a>
    </div>

    <!-- ===== BAGIAN TENGAH ATAS: TREN & STATUS DISPOSISI & KATEGORI ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- 1. TREN SURAT MASUK & KELUAR (Jan - Sep) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm" id="laporan">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span>Tren Surat Masuk & Keluar</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Perkembangan surat masuk, surat keluar & disposisi (Jan - Sep 2025)</p>
                </div>
                <a href="{{ route('tvri.tu.manage', ['tab' => 'surat-masuk']) }}" class="text-xs font-bold text-[#005B9F] hover:underline flex items-center space-x-1">
                    <span>Lihat Detail</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <!-- Mini Visual Chart (Bar Chart CSS) -->
            @php
                $trenBulanan = [
                    ['bulan' => 'Jan', 'masuk' => 84, 'keluar' => 62, 'disp' => 70],
                    ['bulan' => 'Feb', 'masuk' => 90, 'keluar' => 68, 'disp' => 78],
                    ['bulan' => 'Mar', 'masuk' => 95, 'keluar' => 72, 'disp' => 82],
                    ['bulan' => 'Apr', 'masuk' => 102, 'keluar' => 76, 'disp' => 88],
                    ['bulan' => 'Mei', 'masuk' => 108, 'keluar' => 80, 'disp' => 92],
                    ['bulan' => 'Jun', 'masuk' => 112, 'keluar' => 84, 'disp' => 96],
                    ['bulan' => 'Jul', 'masuk' => 118, 'keluar' => 88, 'disp' => 102],
                    ['bulan' => 'Agu', 'masuk' => 122, 'keluar' => 90, 'disp' => 105],
                    ['bulan' => 'Sep', 'masuk' => 128, 'keluar' => 96, 'disp' => 110],
                ];
                $maxTren = 135;
            @endphp
            <div class="space-y-4 pt-2">
                <div class="flex items-center space-x-4 text-xs font-semibold text-slate-600 pb-2 border-b border-slate-100">
                    <span class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded bg-[#005B9F]"></span><span>Surat Masuk</span></span>
                    <span class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded bg-indigo-500"></span><span>Surat Keluar</span></span>
                    <span class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded bg-amber-500"></span><span>Disposisi</span></span>
                </div>

                <div class="grid grid-cols-9 gap-2 text-center pt-2">
                    @foreach($trenBulanan as $t)
                    <div class="flex flex-col items-center">
                        <div class="w-full h-36 flex items-end justify-center space-x-1 bg-slate-50/80 rounded-xl p-1 border border-slate-100">
                            <!-- Surat Masuk Bar -->
                            <div class="w-2.5 bg-[#005B9F] rounded-t transition-all duration-500 hover:opacity-80" style="height: {{ round(($t['masuk'] / $maxTren) * 100) }}%" title="Surat Masuk {{ $t['bulan'] }}: {{ $t['masuk'] }}"></div>
                            <!-- Surat Keluar Bar -->
                            <div class="w-2.5 bg-indigo-500 rounded-t transition-all duration-500 hover:opacity-80" style="height: {{ round(($t['keluar'] / $maxTren) * 100) }}%" title="Surat Keluar {{ $t['bulan'] }}: {{ $t['keluar'] }}"></div>
                            <!-- Disposisi Bar -->
                            <div class="w-2.5 bg-amber-500 rounded-t transition-all duration-500 hover:opacity-80" style="height: {{ round(($t['disp'] / $maxTren) * 100) }}%" title="Disposisi {{ $t['bulan'] }}: {{ $t['disp'] }}"></div>
                        </div>
                        <span class="text-[11px] font-bold text-slate-700 mt-2 {{ $t['bulan'] === 'Sep' ? 'text-blue-700 font-extrabold' : '' }}">{{ $t['bulan'] }}</span>
                        <span class="text-[9px] text-slate-400 font-mono">{{ $t['masuk'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 2. STATUS DISPOSISI & KATEGORI SURAT -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Card Status Disposisi -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm" id="status-disposisi">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <span>Status Disposisi</span>
                    </h3>
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">Total: {{ $ringkasan->disposisi ?? 110 }} Disposisi</span>
                </div>

                @php
                    $dispTotal = max(1, $ringkasan->disposisi ?? 110);
                    $dispSelesai = $ringkasan->disposisi_selesai ?? 78;
                    $dispProses = $ringkasan->disposisi_proses ?? 18;
                    $dispMenunggu = $ringkasan->disposisi_menunggu ?? 9;
                    $dispTerlambat = $ringkasan->disposisi_terlambat ?? 5;
                @endphp

                <!-- Progress Bar Bertingkat -->
                <div class="w-full h-3 rounded-full overflow-hidden flex bg-slate-100 my-3">
                    <div class="bg-emerald-500 h-full" style="width: {{ round(($dispSelesai / $dispTotal) * 100) }}%" title="Selesai: {{ $dispSelesai }}"></div>
                    <div class="bg-blue-500 h-full" style="width: {{ round(($dispProses / $dispTotal) * 100) }}%" title="Proses: {{ $dispProses }}"></div>
                    <div class="bg-amber-400 h-full" style="width: {{ round(($dispMenunggu / $dispTotal) * 100) }}%" title="Menunggu: {{ $dispMenunggu }}"></div>
                    <div class="bg-rose-500 h-full" style="width: {{ round(($dispTerlambat / $dispTotal) * 100) }}%" title="Terlambat: {{ $dispTerlambat }}"></div>
                </div>

                <div class="grid grid-cols-2 gap-2.5 text-xs pt-1">
                    <div class="p-2.5 rounded-xl bg-emerald-50/70 border border-emerald-100 flex items-center justify-between">
                        <div class="flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="font-semibold text-slate-700">Selesai</span>
                        </div>
                        <span class="font-black text-emerald-700">{{ $dispSelesai }} (71%)</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-blue-50/70 border border-blue-100 flex items-center justify-between">
                        <div class="flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span class="font-semibold text-slate-700">Proses</span>
                        </div>
                        <span class="font-black text-blue-700">{{ $dispProses }} (16%)</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-amber-50/70 border border-amber-100 flex items-center justify-between">
                        <div class="flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            <span class="font-semibold text-slate-700">Menunggu</span>
                        </div>
                        <span class="font-black text-amber-700">{{ $dispMenunggu }} (8%)</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-rose-50/70 border border-rose-100 flex items-center justify-between">
                        <div class="flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span class="font-semibold text-slate-700">Terlambat</span>
                        </div>
                        <span class="font-black text-rose-700">{{ $dispTerlambat }} (5%)</span>
                    </div>
                </div>
            </div>

            <!-- Card Kategori Surat Masuk -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm" id="surat-masuk">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span>Kategori Surat Masuk</span>
                    </h3>
                    <span class="text-xs font-bold text-slate-500">Total: {{ $ringkasan->surat_masuk ?? 128 }}</span>
                </div>
                @php
                    $kategoriList = [
                        ['nama' => 'Kementerian / Lembaga', 'jumlah' => $ringkasan->kat_kementerian ?? 32, 'pct' => '25%'],
                        ['nama' => 'LPP TVRI Pusat / Stasiun', 'jumlah' => $ringkasan->kat_lpp ?? 24, 'pct' => '19%'],
                        ['nama' => 'Pemerintah Daerah (Prov/Kab/Kota)', 'jumlah' => $ringkasan->kat_pemda ?? 20, 'pct' => '16%'],
                        ['nama' => 'Instansi Vertikal / TNI / Polri', 'jumlah' => $ringkasan->kat_vertikal ?? 16, 'pct' => '13%'],
                        ['nama' => 'Mitra Kerja / BUMN / Swasta', 'jumlah' => $ringkasan->kat_mitra ?? 14, 'pct' => '11%'],
                        ['nama' => 'Masyarakat / Komunitas', 'jumlah' => $ringkasan->kat_masyarakat ?? 12, 'pct' => '9%'],
                        ['nama' => 'Lainnya', 'jumlah' => $ringkasan->kat_lainnya ?? 10, 'pct' => '8%'],
                    ];
                @endphp
                <div class="space-y-2 text-xs">
                    @foreach($kategoriList as $k)
                    <div>
                        <div class="flex justify-between font-semibold text-slate-700 mb-0.5">
                            <span class="truncate max-w-[220px]">{{ $k['nama'] }}</span>
                            <span class="font-bold text-[#005B9F]">{{ $k['jumlah'] }} <span class="text-slate-400 font-normal">({{ $k['pct'] }})</span></span>
                        </div>
                        <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#005B9F] rounded-full" style="width: {{ $k['pct'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ===== BAGIAN TENGAH BAWAH: SURAT MASUK TERBARU & AGENDA & KALENDER ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- 1. DAFTAR SURAT MASUK TERBARU -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm" id="surat-keluar">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span>Daftar Surat Masuk Terbaru</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Naskah dinas masuk prioritas dan status disposisi</p>
                </div>
                <a href="{{ route('tvri.tu.manage', ['tab' => 'surat-masuk']) }}" class="text-xs font-bold text-[#005B9F] hover:underline flex items-center space-x-1">
                    <span>Kelola Semua Surat</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="space-y-3">
                @forelse($suratMasukList->take(5) as $sm)
                <div class="p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-blue-50/40 transition">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">
                                {{ \Carbon\Carbon::parse($sm->tanggal)->format('d M Y') }}
                            </span>
                            <span class="text-xs font-mono font-bold text-slate-700">{{ $sm->nomor }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($sm->kategori)
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ in_array($sm->kategori, ['Rahasia', 'Penting']) ? 'bg-rose-100 text-rose-700 border border-rose-200' : 'bg-slate-100 text-slate-700' }}">
                                {{ $sm->kategori }}
                            </span>
                            @endif
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $sm->status === 'Selesai' ? 'bg-emerald-100 text-emerald-700' : ($sm->status === 'Didisposisikan' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ $sm->status }}
                            </span>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-slate-800">{{ $sm->perihal }}</p>
                    <p class="text-[11px] text-slate-500 mt-0.5 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Pengirim: <span class="font-medium text-slate-700">{{ $sm->pengirim }}</span></span>
                    </p>
                </div>
                @empty
                <p class="text-xs text-slate-400 text-center py-4">Belum ada surat masuk terbaru.</p>
                @endforelse
            </div>
        </div>

        <!-- 2. AGENDA KEGIATAN & KALENDER -->
        <div class="lg:col-span-5 space-y-6" id="agenda">

            <!-- Card Agenda Hari Ini & Minggu Ini -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span>Agenda Hari Ini & Minggu Ini</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Selasa, 02 September 2025</p>
                    </div>
                    <a href="{{ route('tvri.tu.manage', ['tab' => 'agenda']) }}" class="text-xs font-bold text-[#005B9F] hover:underline">Kelola Agenda &rarr;</a>
                </div>

                <div class="space-y-2.5 text-xs">
                    @forelse($agendaList->take(5) as $ag)
                    <div class="p-3 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-slate-100/70 transition">
                        <div class="flex items-center justify-between mb-1">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $ag->jenis === 'Hari Ini' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-blue-100 text-blue-800' }}">
                                {{ $ag->waktu }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-500">{{ \Carbon\Carbon::parse($ag->tanggal)->format('d M') }}</span>
                        </div>
                        <p class="font-bold text-slate-800">{{ $ag->kegiatan }}</p>
                        <div class="flex items-center justify-between text-[11px] text-slate-500 mt-1">
                            <span>📍 {{ $ag->lokasi }}</span>
                            <span class="text-slate-600 font-medium">{{ $ag->pic }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 text-center py-4">Belum ada agenda terjadwal.</p>
                    @endforelse
                </div>
            </div>

            <!-- Card Visual Kalender Kegiatan September 2025 -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm" id="kalender">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#005B9F]"></span>
                        <span>Kalender Kegiatan</span>
                    </h3>
                    <span class="text-xs font-bold text-blue-800 bg-blue-50 px-2.5 py-0.5 rounded-full">September 2025</span>
                </div>

                <!-- Mini Grid Kalender September 2025 -->
                <div class="grid grid-cols-7 gap-1 text-center text-xs">
                    @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $hari)
                        <div class="py-1 text-[10px] font-bold text-slate-400 uppercase">{{ $hari }}</div>
                    @endforeach
                    <!-- 1 September (Senin) -->
                    <div class="py-1.5 rounded-lg text-slate-700 hover:bg-slate-100">1</div>
                    <!-- 2 September (Selasa - Disorot Hari Ini) -->
                    <div class="py-1.5 rounded-lg font-black bg-[#005B9F] text-white shadow-md ring-2 ring-blue-300">2</div>
                    <!-- 3 September - 30 September -->
                    @for($d = 3; $d <= 30; $d++)
                        <div class="py-1.5 rounded-lg text-slate-700 hover:bg-slate-100 {{ in_array($d, [3, 4, 5]) ? 'bg-amber-50 text-amber-800 font-bold border border-amber-200/50' : '' }}">{{ $d }}</div>
                    @endfor
                </div>
                <div class="flex items-center justify-between text-[11px] text-slate-500 mt-3 pt-2 border-t border-slate-100">
                    <span class="flex items-center space-x-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#005B9F]"></span><span>Hari Ini (2 Sep)</span></span>
                    <span class="flex items-center space-x-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span><span>Agenda Terjadwal</span></span>
                </div>
            </div>

        </div>
    </div>

    <!-- ===== BAGIAN BAWAH: LAYANAN ADM, ARSIP, MONITORING SOP ===== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- 1. LAYANAN ADMINISTRASI & PERSURATAN -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm" id="layanan-adm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                    <span>Layanan Administrasi</span>
                </h3>
                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-teal-50 text-teal-800">Total: {{ $ringkasan->layanan_adm ?? 86 }}</span>
            </div>

            @php
                $layananItems = [
                    ['label' => 'SK & Keputusan', 'selesai' => '24 Selesai', 'pct' => '96%'],
                    ['label' => 'Permintaan Data & Informasi', 'selesai' => '18 Selesai', 'pct' => '90%'],
                    ['label' => 'Surat Keterangan Internal', 'selesai' => '22 Selesai', 'pct' => '100%'],
                    ['label' => 'Layanan Tamu & Eksternal', 'selesai' => '16 Selesai', 'pct' => '94%'],
                    ['label' => 'Legalisasi Dokumen', 'selesai' => '6 Selesai', 'pct' => '83%'],
                ];
            @endphp
            <div class="space-y-3 text-xs">
                @foreach($layananItems as $li)
                <div>
                    <div class="flex justify-between font-semibold text-slate-700 mb-1">
                        <span>{{ $li['label'] }}</span>
                        <span class="font-bold text-teal-700">{{ $li['selesai'] }} <span class="text-slate-400 font-normal">({{ $li['pct'] }})</span></span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-teal-500 rounded-full" style="width: {{ $li['pct'] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-5 p-3 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-600 flex justify-between items-center">
                <span>Rata-rata Penyelesaian: <strong class="text-teal-700 font-bold">94%</strong></span>
                <span>Waktu Proses: <strong class="text-slate-800 font-bold">1,4 Hari</strong></span>
            </div>
        </div>

        <!-- 2. ARSIP & DOKUMENTASI -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm" id="arsip-dokumen">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                    <span>Arsip & Dokumentasi</span>
                </h3>
                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-800">2.462 Berkas</span>
            </div>

            <div class="grid grid-cols-2 gap-3 text-xs mb-4">
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <p class="text-slate-500 font-medium">Arsip Aktif</p>
                    <p class="text-lg font-black text-slate-800">{{ number_format($ringkasan->arsip_aktif ?? 1250) }}</p>
                    <p class="text-[10px] text-blue-600 font-semibold">51% terkelola</p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <p class="text-slate-500 font-medium">Arsip Inaktif</p>
                    <p class="text-lg font-black text-slate-800">{{ number_format($ringkasan->arsip_inaktif ?? 320) }}</p>
                    <p class="text-[10px] text-slate-500 font-semibold">13% tersimpan</p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <p class="text-slate-500 font-medium">Arsip Digital</p>
                    <p class="text-lg font-black text-indigo-700">{{ number_format($ringkasan->arsip_digital ?? 850) }}</p>
                    <p class="text-[10px] text-indigo-600 font-semibold">35% digitalisasi</p>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <p class="text-slate-500 font-medium">Usul Retensi</p>
                    <p class="text-lg font-black text-rose-600">{{ number_format($ringkasan->arsip_retensi ?? 42) }}</p>
                    <p class="text-[10px] text-rose-500 font-semibold">2% terjadwal</p>
                </div>
            </div>

            <div class="space-y-2 text-xs pt-1">
                <div>
                    <div class="flex justify-between font-semibold text-slate-700 mb-1">
                        <span>Tingkat Digitalisasi Arsip</span>
                        <span class="font-bold text-indigo-700">68% <span class="text-slate-400 font-normal">(Target 75%)</span></span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-500 rounded-full" style="width: 68%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between font-semibold text-slate-700 mb-1">
                        <span>Kapasitas Ruang Arsip Utama</span>
                        <span class="font-bold text-slate-800">85% Terisi</span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. MONITORING SOP & KEPATUHAN -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm" id="sop-regulasi">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span>Monitoring SOP & Regulasi</span>
                </h3>
                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Kepatuhan: 96%</span>
            </div>

            <div class="space-y-2 text-xs mb-4">
                <div class="flex justify-between text-slate-700 font-medium">
                    <span>SOP Persuratan & Disposisi</span>
                    <span class="font-bold text-emerald-600">98%</span>
                </div>
                <div class="flex justify-between text-slate-700 font-medium">
                    <span>SOP Pengelolaan Arsip</span>
                    <span class="font-bold text-blue-600">92%</span>
                </div>
                <div class="flex justify-between text-slate-700 font-medium">
                    <span>SOP Layanan Tamu & Administrasi</span>
                    <span class="font-bold text-emerald-600">96%</span>
                </div>
                <div class="flex justify-between text-slate-700 font-medium">
                    <span>SOP Tata Naskah Dinas</span>
                    <span class="font-bold text-emerald-600">98%</span>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-3">
                <p class="text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-2">Checklist SOP Aktif:</p>
                <div class="space-y-1.5 text-xs">
                    @forelse($sops as $sop)
                    <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100/80 transition">
                        <div class="flex items-center space-x-2 truncate">
                            <svg class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="font-medium text-slate-800 truncate">{{ $sop->judul }}</span>
                        </div>
                        <span class="text-[10px] font-mono px-1.5 py-0.5 bg-white border border-slate-200 rounded text-slate-600">{{ $sop->versi }}</span>
                    </div>
                    @empty
                    <p class="text-slate-400 text-center py-2">Belum ada checklist SOP.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <!-- ===== NOTIFIKASI & TINDAK LANJUT ===== -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm">
        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 mb-4 flex items-center space-x-2">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
            <span>Notifikasi & Tindak Lanjut Prioritas</span>
        </h3>

        @php
            $notifList = [
                ['tipe' => 'Surat Perlu Disposisi', 'judul' => 'Surat Menkominfo perihal Rakor Digital butuh disposisi Kastasiun', 'level' => 'Baru', 'warna' => 'bg-blue-100 text-blue-800 border-blue-200'],
                ['tipe' => 'Batas Waktu Disposisi', 'judul' => 'Disposisi TVRI Pusat perihal Juknis Pilkada tersisa 2 hari', 'level' => 'Penting', 'warna' => 'bg-rose-100 text-rose-800 border-rose-200'],
                ['tipe' => 'Agenda Hari Ini', 'judul' => 'Rakor Evaluasi Siaran pukul 09:00 WIT di R. Rapat Lt. 2', 'level' => 'Hari Ini', 'warna' => 'bg-amber-100 text-amber-800 border-amber-200'],
                ['tipe' => 'Layanan Tertunda', 'judul' => '1 permohonan legalisasi dokumen menunggu verifikasi kasubbag', 'level' => 'Tertunda', 'warna' => 'bg-orange-100 text-orange-800 border-orange-200'],
                ['tipe' => 'Pengingat Arsip', 'judul' => 'Jadwal pemusnahan arsip retensi 2020 direncanakan akhir September', 'level' => 'Info', 'warna' => 'bg-slate-100 text-slate-800 border-slate-200'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($notifList as $nf)
            <div class="p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[11px] font-bold text-slate-700">{{ $nf['tipe'] }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold border {{ $nf['warna'] }}">{{ $nf['level'] }}</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-snug">{{ $nf['judul'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ===== TABEL RINGKASAN KINERJA TATA USAHA (KPI) ===== -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden" id="monitoring-kinerja">
        <div class="p-6 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <span>Tabel Ringkasan Kinerja Tata Usaha</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Indikator Kinerja Utama (IKU) Periode September 2025</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">Kinerja Keseluruhan: 104% (Sangat Baik)</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-100/75 text-slate-600 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="p-3.5">No</th>
                        <th class="p-3.5">Indikator Kinerja</th>
                        <th class="p-3.5">Target</th>
                        <th class="p-3.5">Realisasi</th>
                        <th class="p-3.5">Capaian (%)</th>
                        <th class="p-3.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-bold text-slate-400">1</td>
                        <td class="p-3.5 font-semibold text-slate-800">Persuratan Masuk</td>
                        <td class="p-3.5 text-slate-600">120 Surat</td>
                        <td class="p-3.5 font-bold text-slate-800">128 Surat</td>
                        <td class="p-3.5 font-bold text-emerald-600">107%</td>
                        <td class="p-3.5"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Tercapai</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-bold text-slate-400">2</td>
                        <td class="p-3.5 font-semibold text-slate-800">Persuratan Keluar</td>
                        <td class="p-3.5 text-slate-600">90 Surat</td>
                        <td class="p-3.5 font-bold text-slate-800">96 Surat</td>
                        <td class="p-3.5 font-bold text-emerald-600">107%</td>
                        <td class="p-3.5"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Tercapai</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-bold text-slate-400">3</td>
                        <td class="p-3.5 font-semibold text-slate-800">Kecepatan Disposisi (&lt;24 Jam)</td>
                        <td class="p-3.5 text-slate-600">85%</td>
                        <td class="p-3.5 font-bold text-slate-800">89%</td>
                        <td class="p-3.5 font-bold text-emerald-600">105%</td>
                        <td class="p-3.5"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Sangat Baik</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-bold text-slate-400">4</td>
                        <td class="p-3.5 font-semibold text-slate-800">Penyelesaian Layanan Administrasi</td>
                        <td class="p-3.5 text-slate-600">90%</td>
                        <td class="p-3.5 font-bold text-slate-800">94%</td>
                        <td class="p-3.5 font-bold text-emerald-600">104%</td>
                        <td class="p-3.5"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Sangat Baik</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-bold text-slate-400">5</td>
                        <td class="p-3.5 font-semibold text-slate-800">Digitalisasi Arsip</td>
                        <td class="p-3.5 text-slate-600">75%</td>
                        <td class="p-3.5 font-bold text-slate-800">68%</td>
                        <td class="p-3.5 font-bold text-amber-600">91%</td>
                        <td class="p-3.5"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">Dalam Proses</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== DOKUMEN & LINK PENTING ===== -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm" id="kontak-link">
        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 mb-4 flex items-center space-x-2">
            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
            <span>Dokumen & Tautan Penting Tata Usaha</span>
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 text-xs">
            <a href="#" class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-blue-50/50 hover:border-blue-300 transition text-center group">
                <div class="w-8 h-8 mx-auto rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center mb-2 group-hover:scale-110 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h6m-9 12h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="font-bold text-slate-700 block">SIMAS TVRI</span>
                <span class="text-[10px] text-slate-400">Arsip & Surat</span>
            </a>
            <a href="#" class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-blue-50/50 hover:border-blue-300 transition text-center group">
                <div class="w-8 h-8 mx-auto rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center mb-2 group-hover:scale-110 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="font-bold text-slate-700 block">E-Disposisi</span>
                <span class="text-[10px] text-slate-400">TVRI Maluku</span>
            </a>
            <a href="#" class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-blue-50/50 hover:border-blue-300 transition text-center group">
                <div class="w-8 h-8 mx-auto rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center mb-2 group-hover:scale-110 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="font-bold text-slate-700 block">Tata Naskah</span>
                <span class="text-[10px] text-slate-400">Template 2025</span>
            </a>
            <a href="#" class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-blue-50/50 hover:border-blue-300 transition text-center group">
                <div class="w-8 h-8 mx-auto rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center mb-2 group-hover:scale-110 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <span class="font-bold text-slate-700 block">Buku Panduan</span>
                <span class="text-[10px] text-slate-400">Administrasi Kantor</span>
            </a>
            <a href="#" class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-blue-50/50 hover:border-blue-300 transition text-center group">
                <div class="w-8 h-8 mx-auto rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center mb-2 group-hover:scale-110 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <span class="font-bold text-slate-700 block">Portal Pegawai</span>
                <span class="text-[10px] text-slate-400">Layanan TVRI</span>
            </a>
            <a href="#" class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 hover:bg-blue-50/50 hover:border-blue-300 transition text-center group">
                <div class="w-8 h-8 mx-auto rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center mb-2 group-hover:scale-110 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <span class="font-bold text-slate-700 block">Kontak Penting</span>
                <span class="text-[10px] text-slate-400">Direktorat & Pemda</span>
            </a>
        </div>
    </div>

    <!-- ===== TEKS PENUTUP & FOOTER ===== -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-blue-900 to-indigo-950 text-white shadow-md text-center">
        <p class="text-base font-extrabold italic tracking-wide text-cyan-200">
            "Administrasi Tertib, Siaran Lancar, Maluku Bangga!"
        </p>
        <p class="text-xs text-blue-200/80 mt-1">
            Bagian Tata Usaha - LPP TVRI Stasiun Maluku | Jl. Wolter Monginsidi, Ambon, Maluku
        </p>
    </div>

</div>
@endsection
