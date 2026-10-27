@extends('layouts.app')

@section('title', 'Dashboard Berita TVRI Maluku')

@php
    $formatNum = fn($n) => number_format($n, 0, ',', '.');
    $user = auth()->user();
    $isKepalaStasiun = $user && ($user->hasRole('KEPALA_DINAS') || $user->hasRole('Kepala Stasiun') || $user->username === 'kepala.stasiun' || str_contains(strtolower($user->name ?? ''), 'kepala stasiun'));
@endphp

@section('content')
<div class="space-y-5 pb-12" id="beranda" x-data="newsroomDashboard()">

    <!-- ===== HEADER NEWSROOM INFOGRAFIS ===== -->
    <div class="relative bg-gradient-to-r from-[#00142A] via-[#002244] to-[#003B70] rounded-3xl p-6 sm:p-7 text-white shadow-xl overflow-hidden border border-cyan-400/20">
        <div class="absolute -right-12 -top-16 w-80 h-80 bg-cyan-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-16 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">
            <!-- Brand & Info -->
            <div class="flex items-start sm:items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-white p-2 shadow-xl flex-shrink-0 flex items-center justify-center border-2 border-cyan-300/40">
                    <img src="{{ asset('images/logo_tvri.png') }}" alt="Logo TVRI" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-cyan-400/20 text-cyan-300 border border-cyan-400/30">
                            BIDANG PEMBERITAAN (NEWSROOM)
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-400/20 text-amber-300 border border-amber-400/30 italic">
                            Jendela Maluku untuk Indonesia
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white mt-1 leading-tight uppercase">
                        Dashboard Berita TVRI Maluku
                    </h1>
                    <p class="text-xs text-blue-200 font-extrabold tracking-wider uppercase mt-0.5">
                        CEPAT &bull; AKURAT &bull; TERPERCAYA &bull; UNTUK MALUKU DAN INDONESIA
                    </p>
                </div>
            </div>

            <!-- Live Status & Action Buttons -->
            <div class="flex flex-col sm:flex-row xl:flex-col items-start xl:items-end justify-between gap-3">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/15 text-left xl:text-right">
                        <div class="flex items-center xl:justify-end space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[10px] text-emerald-300 font-black uppercase tracking-wider">Live Newsroom</span>
                        </div>
                        <p class="text-xs font-black text-white global-live-datetime-bullet" id="liveClockWidget">{{ $periode === 'September 2025' ? 'Selasa, 2 September 2025 • 10:24 WIT' : (now()->isoFormat('dddd, D MMMM Y') . ' • ' . now()->format('H:i') . ' WIT') }}</p>
                    </div>

                    <div class="bg-white/10 px-3.5 py-2 rounded-2xl border border-white/15 text-xs font-bold text-cyan-200">
                        Periode: <strong class="text-white">{{ $periode }}</strong>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="button" 
                       @click="openNewsCrudModal()"
                       class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl text-xs font-black bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white shadow-md border border-amber-300/30 transition-all hover:scale-[1.02] cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span>Input Data Berita</span>
                    </button>
                    <a href="{{ route('dokumen.documents.index') }}" 
                       class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/15 transition-all">
                        <svg class="w-4 h-4 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Pangkalan Dokumen</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MENU NAVIGASI NEWSROOM ===== -->
    <div class="bg-white rounded-2xl p-2.5 border border-slate-200 shadow-sm flex items-center justify-between overflow-x-auto gap-2">
        <div class="flex items-center space-x-1.5 flex-nowrap">
            <a href="#beranda" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-[#00264A] transition-colors whitespace-nowrap">Dashboard</a>
            <a href="#kategori" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-[#00264A] transition-colors whitespace-nowrap">Kategori Berita</a>
            <a href="#sebaran" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-[#00264A] transition-colors whitespace-nowrap">Sebaran Lokasi</a>
            <a href="#status-liputan" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-[#00264A] transition-colors whitespace-nowrap">Status Liputan</a>
            <a href="#realtime" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-[#00264A] transition-colors whitespace-nowrap">Real Time Newsroom</a>
            <a href="#top-berita" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-[#00264A] transition-colors whitespace-nowrap">Top 5 Digital</a>
            <a href="#distribusi" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-[#00264A] transition-colors whitespace-nowrap">Distribusi Media</a>
            <a href="#agenda" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-[#00264A] transition-colors whitespace-nowrap">Agenda Liputan</a>
            <a href="#sop" class="px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-[#00264A] transition-colors whitespace-nowrap">Dokumen & SOP</a>
        </div>

        <div class="flex items-center space-x-2 pl-3 border-l border-slate-200 flex-shrink-0">
            <button type="button" 
               @click="openNewsCrudModal()"
               class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-amber-50 text-amber-800 hover:bg-amber-100 border border-amber-200 transition-colors whitespace-nowrap cursor-pointer">
                <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Input & Kelola Berita</span>
            </button>
            @if(auth()->user() && auth()->user()->username !== 'berita' && in_array(auth()->user()->username, ['admin', 'superadmin', 'keuangan']))
                <a href="{{ route('tvri.keuangan.dashboard') }}" 
                   class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 transition-colors whitespace-nowrap">
                    <span>Ke Dashboard Keuangan &rarr;</span>
                </a>
            @endif
        </div>
    </div>

    <!-- ===== 6 TOP KPI CARDS UTAMA ===== -->
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-4">
        <!-- 1. Rencana Liputan -->
        <div class="bg-white rounded-2xl p-4 border border-blue-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">Rencana Liputan</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-2xl font-black text-[#00264A] tracking-tight" x-text="metrics.rencana_liputan">{{ $ringkasan->rencana_liputan }}</p>
                <div class="flex items-center space-x-1 mt-1 text-[11px] font-bold" :class="metrics.rencana_trend_class">
                    <span x-text="metrics.rencana_trend">{{ $dynamicMetrics['rencana_trend'] ?? '▲ +12%' }}</span>
                    <span class="text-slate-400 font-semibold text-[10px]">dari bln lalu</span>
                </div>
            </div>
            <div class="mt-3 w-full bg-blue-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-blue-600 h-full rounded-full w-full"></div>
            </div>
        </div>

        <!-- 2. Liputan Dilakukan -->
        <div class="bg-white rounded-2xl p-4 border border-emerald-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-700">Liputan Dilakukan</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-2xl font-black text-emerald-700 tracking-tight" x-text="metrics.liputan_dilakukan">{{ $ringkasan->liputan_dilakukan }}</p>
                <div class="flex items-center space-x-1 mt-1 text-[11px] font-bold text-slate-600">
                    <span class="px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px]" x-text="metrics.pct_dilakukan + '%'">{{ $dynamicMetrics['pct_dilakukan'] ?? 85 }}%</span>
                    <span class="text-slate-400 text-[10px]">dari rencana</span>
                </div>
            </div>
            <div class="mt-3 w-full bg-emerald-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" :style="'width: ' + Math.min(100, metrics.pct_dilakukan) + '%'" style="width: {{ min(100, $dynamicMetrics['pct_dilakukan'] ?? 85) }}%"></div>
            </div>
        </div>

        <!-- 3. Berita Diproduksi -->
        <div class="bg-white rounded-2xl p-4 border border-amber-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-wider text-amber-700">Berita Diproduksi</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-2xl font-black text-amber-700 tracking-tight" x-text="metrics.berita_diproduksi">{{ $ringkasan->berita_diproduksi }}</p>
                <div class="flex items-center space-x-1 mt-1 text-[11px] font-bold text-emerald-600">
                    <span x-text="metrics.diproduksi_trend">{{ $dynamicMetrics['diproduksi_trend'] ?? '▲ +8%' }}</span>
                    <span class="text-slate-400 text-[10px]">selesai edit</span>
                </div>
            </div>
            <div class="mt-3 w-full bg-amber-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-amber-500 h-full rounded-full transition-all duration-500" :style="'width: ' + Math.min(100, metrics.pct_diproduksi) + '%'" style="width: {{ min(100, $dynamicMetrics['pct_diproduksi'] ?? 80) }}%"></div>
            </div>
        </div>

        <!-- 4. Berita Tayang -->
        <div class="bg-white rounded-2xl p-4 border border-rose-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-wider text-rose-700">Berita Tayang</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-2xl font-black text-rose-700 tracking-tight" x-text="metrics.berita_tayang">{{ $ringkasan->berita_tayang }}</p>
                <div class="flex items-center space-x-1 mt-1 text-[11px] font-bold text-emerald-600">
                    <span x-text="metrics.tayang_trend">{{ $dynamicMetrics['tayang_trend'] ?? '▲ +12%' }}</span>
                    <span class="text-slate-400 text-[10px]">siap siar</span>
                </div>
            </div>
            <div class="mt-3 w-full bg-rose-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-rose-500 h-full rounded-full transition-all duration-500" :style="'width: ' + Math.min(100, metrics.pct_tayang) + '%'" style="width: {{ min(100, $dynamicMetrics['pct_tayang'] ?? 78) }}%"></div>
            </div>
        </div>

        <!-- 5. Distribusi Digital -->
        <div class="bg-white rounded-2xl p-4 border border-purple-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-wider text-purple-700">Distribusi Digital</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-2xl font-black text-purple-800 tracking-tight" x-text="metrics.distribusi_digital_formatted">{{ $dynamicMetrics['distribusi_digital_formatted'] ?? '1,2 Juta' }}</p>
                <div class="flex items-center space-x-1 mt-1 text-[11px] font-bold text-emerald-600">
                    <span x-text="metrics.views_trend">{{ $dynamicMetrics['views_trend'] ?? '▲ +35%' }}</span>
                    <span class="text-slate-400 text-[10px]">Views</span>
                </div>
            </div>
            <div class="mt-3 w-full bg-purple-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-purple-600 h-full rounded-full transition-all duration-500" :style="'width: ' + Math.min(100, metrics.pct_views) + '%'" style="width: {{ min(100, $dynamicMetrics['pct_views'] ?? 90) }}%"></div>
            </div>
        </div>

        <!-- 6. Newsroom Performance Index -->
        <div class="bg-white rounded-2xl p-4 border border-cyan-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-wider text-cyan-800">Newsroom Index</span>
                <span class="text-[10px] font-bold text-slate-400">Target 90%</span>
            </div>
            <div class="flex items-center space-x-3 mt-1">
                <div class="relative w-12 h-12 flex-shrink-0 flex items-center justify-center">
                    <canvas id="gaugeIndexChart"></canvas>
                    <span class="absolute text-xs font-black text-[#00264A]" x-text="metrics.performance_index + '%'">{{ $ringkasan->performance_index }}%</span>
                </div>
                <div>
                    <p class="text-xs font-black" :class="metrics.index_color" x-text="metrics.index_label">{{ $dynamicMetrics['index_label'] ?? 'Sangat Baik' }}</p>
                    <p class="text-[10px] text-slate-500 font-semibold" x-html="metrics.index_sublabel">{!! $dynamicMetrics['index_sublabel'] ?? 'Tercapai &bull; On Track' !!}</p>
                </div>
            </div>
            <div class="mt-3 w-full bg-cyan-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-cyan-500 h-full rounded-full transition-all duration-500" :style="'width: ' + Math.min(100, metrics.performance_index) + '%'" style="width: {{ min(100, $ringkasan->performance_index) }}%"></div>
            </div>
        </div>
    </div>

    <!-- ===== SECTION 1: TREN, KATEGORI & SEBARAN ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6" id="kategori">
        <!-- Tren Produksi & Tayang Berita (5 Kolom) -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">
                        Tren Produksi & Tayang Berita
                    </h3>
                    <p class="text-xs text-slate-500">Pergerakan harian 1 Sep - 10 Sep 2025</p>
                </div>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">Harian</span>
            </div>
            <div class="relative w-full h-[260px]">
                <canvas id="trenBeritaChart"></canvas>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-center space-x-5 text-xs font-semibold text-slate-600">
                <div class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded-full bg-blue-500"></span><span>Rencana</span></div>
                <div class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500"></span><span>Produksi</span></div>
                <div class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded-full bg-amber-500"></span><span>Tayang</span></div>
            </div>
        </div>

        <!-- Kategori Berita (Donut - 4 Kolom) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Kategori Berita</h3>
                    <p class="text-xs text-slate-500">Distribusi topik penyiaran</p>
                </div>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">95 Berita</span>
            </div>
            <div class="relative w-full h-[200px] flex items-center justify-center">
                <canvas id="kategoriDonutChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-x-3 gap-y-1 mt-2 text-[11px]">
                @foreach($kategoriList as $kat)
                    <div class="flex items-center justify-between py-0.5 border-b border-slate-50">
                        <div class="flex items-center space-x-1.5 truncate">
                            <span class="w-2 h-2 rounded-full flex-shrink-0" style="background-color: {{ $kat['color'] }}"></span>
                            <span class="text-slate-700 truncate text-[10px]">{{ $kat['nama'] }}</span>
                        </div>
                        <span class="font-bold text-slate-900 text-[10px]">{{ $kat['jumlah'] }} ({{ $kat['persen'] }}%)</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Sebaran Lokasi Liputan (3 Kolom) -->
        <div class="lg:col-span-3 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between" id="sebaran">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Sebaran Lokasi</h3>
                    <p class="text-xs text-slate-500">Liputan Kab/Kota Maluku</p>
                </div>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700">11 Wilayah</span>
            </div>

            <!-- Mini Map Graphic Card -->
            <div class="p-2.5 rounded-xl bg-gradient-to-br from-[#001D38] to-[#003B70] text-white text-center shadow-inner relative overflow-hidden mb-2">
                <p class="text-[10px] font-extrabold text-cyan-300 uppercase tracking-widest">Gugus Kepulauan Maluku</p>
                <p class="text-xs font-black mt-0.5">Liputan Berimbang & Merata</p>
            </div>

            <div class="space-y-1 text-xs divide-y divide-slate-100">
                @foreach($sebaranLokasi as $wil => $jml)
                    @if($jml > 0)
                        <div class="flex items-center justify-between py-1 text-[11px]">
                            <span class="text-slate-600">{{ $wil }}</span>
                            <span class="font-black text-[#00264A] bg-slate-100 px-2 py-0.5 rounded">{{ $jml }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- ===== SECTION 2: STATUS, REAL TIME FEED & TOP 5 DIGITAL ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6" id="status-liputan">
        <!-- Status Liputan (3 Kolom) -->
        <div class="lg:col-span-3 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Status Liputan</h3>
                    <p class="text-xs text-slate-500">120 Rencana Liputan</p>
                </div>
            </div>
            <div class="relative w-full h-[180px] flex items-center justify-center">
                <canvas id="statusLiputanChart"></canvas>
            </div>
            <div class="space-y-1.5 mt-2 text-xs">
                @foreach($statusList as $stName => $stVal)
                    <div class="flex items-center justify-between py-1 border-b border-slate-50">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $stVal['color'] }}"></span>
                            <span class="text-slate-700 font-medium">{{ $stName }}</span>
                        </div>
                        <span class="font-bold text-slate-900">{{ $stVal['jumlah'] }} ({{ $stVal['persen'] }}%)</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Real Time Newsroom (• LIVE) (5 Kolom) -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between" id="realtime">
            <div>
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <div class="flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-600 animate-ping"></span>
                        <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Real Time Newsroom</h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-700">LIVE FEED</span>
                </div>

                <div class="space-y-2.5">
                    @forelse($realtimeFeeds as $feed)
                        <div class="flex items-start space-x-2.5 text-xs p-2 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 font-black text-[10px] flex-shrink-0">{{ $feed->waktu }}</span>
                            <p class="text-slate-700 font-semibold leading-relaxed">{{ $feed->kegiatan }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada feed live redaksi.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                <span>Tim Newsroom Terhubung di Seluruh Titik Siar</span>
                <a href="{{ route('tvri.berita.manage') }}?tab=realtime" class="text-blue-600 font-bold hover:underline">+ Update Feed</a>
            </div>
        </div>

        <!-- Top 5 Berita (Digital) (4 Kolom) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between" id="top-berita">
            <div>
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Top 5 Berita (Digital)</h3>
                    <span class="text-[10px] font-bold text-slate-400">Paling Banyak Ditonton</span>
                </div>

                <div class="space-y-2">
                    @foreach($topBerita as $idx => $tb)
                        <div class="flex items-center space-x-2.5 p-2 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                            <span class="w-6 h-6 rounded-lg bg-[#00264A] text-white flex items-center justify-center font-black text-xs flex-shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <div class="min-w-0 flex-1 truncate">
                                <p class="text-xs font-bold text-slate-800 truncate">{{ $tb->judul }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">{{ number_format($tb->views) }} views &bull; {{ $tb->tanggal ?? '2 Sep 2025' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 text-right">
                <a href="{{ route('tvri.berita.manage') }}" class="text-xs text-blue-600 font-bold hover:underline">Kelola Konten Digital &rarr;</a>
            </div>
        </div>
    </div>

    <!-- ===== SECTION 3: JENIS PENYIARAN, DISTRIBUSI & KUALITAS ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6" id="distribusi">
        <!-- Jenis Penyiaran Berita (4 Kolom) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide mb-1">Jenis Penyiaran Berita</h3>
                <p class="text-xs text-slate-500 mb-3">Distribusi format penayangan</p>

                <div class="space-y-3 text-xs">
                    @foreach($jenisPenyiaran as $jName => $jVal)
                        <div>
                            <div class="flex items-center justify-between font-bold mb-1">
                                <span class="text-slate-700">{{ $jName }}</span>
                                <span class="text-slate-900">{{ $jVal['jumlah'] }} ({{ $jVal['persen'] }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $jVal['persen'] }}%; background-color: {{ $jVal['color'] }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Kecepatan Publikasi & Media Distribusi (4 Kolom) -->
        <div class="lg:col-span-4 space-y-4">
            <!-- Kecepatan Publikasi -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Kecepatan Publikasi</p>
                        <p class="text-xl font-black text-[#00264A]">{{ $ringkasan->kecepatan_publikasi_menit }} Menit</p>
                        <p class="text-[10px] text-slate-500">Dari liputan ke tayang</p>
                    </div>
                </div>
                <span class="px-2 py-1 rounded-md text-[10px] font-black bg-emerald-100 text-emerald-800">▼ -20% Lebih Cepat</span>
            </div>

            <!-- Media Distribusi -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2.5">Media Distribusi Berita</p>
                <div class="grid grid-cols-5 gap-2 text-center text-xs">
                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-blue-600 text-base font-bold block">📺</span>
                        <span class="font-black text-slate-800 block text-xs mt-1">{{ $ringkasan->dist_tv }}</span>
                        <span class="text-[9px] text-slate-400 font-bold">TV</span>
                    </div>
                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-teal-600 text-base font-bold block">🌐</span>
                        <span class="font-black text-slate-800 block text-xs mt-1">{{ $ringkasan->dist_website }}</span>
                        <span class="text-[9px] text-slate-400 font-bold">Web</span>
                    </div>
                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-rose-600 text-base font-bold block">▶️</span>
                        <span class="font-black text-slate-800 block text-xs mt-1">{{ $ringkasan->dist_youtube }}</span>
                        <span class="text-[9px] text-slate-400 font-bold">YouTube</span>
                    </div>
                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-pink-600 text-base font-bold block">📸</span>
                        <span class="font-black text-slate-800 block text-xs mt-1">{{ $ringkasan->dist_instagram }}</span>
                        <span class="text-[9px] text-slate-400 font-bold">IG</span>
                    </div>
                    <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-900 text-base font-bold block">🎵</span>
                        <span class="font-black text-slate-800 block text-xs mt-1">{{ $ringkasan->dist_tiktok }}</span>
                        <span class="text-[9px] text-slate-400 font-bold">TikTok</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kualitas Berita (Checklist - 4 Kolom) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center space-x-2 mb-3 pb-2 border-b border-slate-100">
                    <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">✓</div>
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Kualitas Berita</h3>
                </div>

                <div class="space-y-2 text-xs">
                    <div class="flex items-center justify-between p-2 rounded-xl bg-emerald-50/70 border border-emerald-100">
                        <span class="font-bold text-emerald-900">☑ Fakta Terverifikasi</span>
                        <span class="font-black text-emerald-700">{{ $ringkasan->kualitas_fakta }}%</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-xl bg-emerald-50/70 border border-emerald-100">
                        <span class="font-bold text-emerald-900">☑ Sesuai Kode Etik Jurnalistik</span>
                        <span class="font-black text-emerald-700">{{ $ringkasan->kualitas_etik }}%</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-xl bg-emerald-50/70 border border-emerald-100">
                        <span class="font-bold text-emerald-900">☑ Akurasi Data & Narasumber</span>
                        <span class="font-black text-emerald-700">{{ $ringkasan->kualitas_akurasi }}%</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-xl bg-emerald-50/70 border border-emerald-100">
                        <span class="font-bold text-emerald-900">☑ Penggunaan Visual / Footage Berkualitas</span>
                        <span class="font-black text-emerald-700">{{ $ringkasan->kualitas_visual }}%</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-xl bg-emerald-50/70 border border-emerald-100">
                        <span class="font-bold text-emerald-900">☑ Kepatuhan SOP Newsroom</span>
                        <span class="font-black text-emerald-700">{{ $ringkasan->kualitas_sop }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== SECTION 4: BERITA TERBARU (VIDEO CARDS), AGENDA & CATATAN ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6" id="agenda">
        <!-- Berita Terbaru Video Cards (12 Kolom) -->
        <div class="lg:col-span-12 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Berita Terbaru (Siap Siar)</h3>
                    <p class="text-xs text-slate-500">Tayangan berita terkini TVRI Stasiun Maluku</p>
                </div>
                <a href="{{ route('tvri.berita.manage') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua Berita &rarr;</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3.5">
                @foreach($beritaTerbaru as $b)
                    <div class="group rounded-2xl bg-slate-50 border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                        <!-- Video Mock / Real Video Thumbnail -->
                        <div class="relative h-28 bg-gradient-to-tr from-[#001D38] to-[#003B70] flex items-center justify-center p-3 text-center cursor-pointer select-none"
                             @if(!empty($b['video_url']))
                                onclick="openVideoPlayer('{{ $b['video_url'] }}', '{{ addslashes($b['judul']) }}')"
                                title="Klik untuk memutar video"
                             @endif>
                            @if(!empty($b['video_url']))
                                <span class="w-10 h-10 rounded-full bg-emerald-500 hover:bg-emerald-600 flex items-center justify-center text-white group-hover:scale-110 transition-transform shadow-lg">
                                    <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                                <span class="absolute top-2 right-2 px-1.5 py-0.5 rounded bg-emerald-600/90 text-white font-black text-[8px] uppercase tracking-wider shadow">
                                    Video Ready
                                </span>
                            @else
                                <span class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:scale-110 transition-transform shadow-lg">
                                    ▶
                                </span>
                            @endif
                            <span class="absolute bottom-2 right-2 px-1.5 py-0.5 rounded bg-black/70 text-white font-black text-[9px]">
                                {{ $b['durasi'] }}
                            </span>
                            <span class="absolute top-2 left-2 px-1.5 py-0.5 rounded bg-blue-600/80 text-white font-bold text-[8px] uppercase">
                                {{ $b['kategori'] }}
                            </span>
                        </div>
                        <div class="p-3">
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-tight">
                                {{ $b['judul'] }}
                            </h4>
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-200/60 text-[10px] text-slate-400 font-semibold">
                                <span>📍 {{ $b['lokasi'] }}</span>
                                <span>{{ $b['tanggal'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Agenda Liputan Hari Ini (7 Kolom) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Agenda Liputan Hari Ini</h3>
                    <a href="{{ route('tvri.berita.manage') }}?tab=agenda" class="text-xs font-bold text-blue-600 hover:underline">+ Tambah Agenda</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 text-[10px] uppercase font-bold">
                                <th class="py-2">Waktu</th>
                                <th class="py-2">Agenda Liputan</th>
                                <th class="py-2">Lokasi</th>
                                <th class="py-2">PIC Tim</th>
                                <th class="py-2 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($agendaLiputan as $ag)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-2 font-black text-slate-700">{{ $ag->waktu }}</td>
                                    <td class="py-2 font-bold text-slate-800">{{ $ag->agenda }}</td>
                                    <td class="py-2 text-slate-600">{{ $ag->lokasi }}</td>
                                    <td class="py-2 text-slate-500 font-semibold">{{ $ag->pic }}</td>
                                    <td class="py-2 text-center">
                                        @php
                                            $stClass = match($ag->status) {
                                                'Selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                                'On Air' => 'bg-rose-100 text-rose-800 border-rose-300 animate-pulse',
                                                'Proses' => 'bg-blue-100 text-blue-800 border-blue-300',
                                                default => 'bg-slate-100 text-slate-700 border-slate-200',
                                            };
                                        @endphp
                                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold border {{ $stClass }}">
                                            {{ $ag->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Peringatan & Catatan Redaksi (5 Kolom) -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Peringatan & Catatan Redaksi</h3>
                    <a href="{{ route('tvri.berita.manage') }}?tab=catatan" class="text-xs font-bold text-blue-600 hover:underline">+ Kelola</a>
                </div>

                <div class="space-y-2">
                    @foreach($catatanPeringatan as $cp)
                        <div class="flex items-start space-x-2.5 p-2.5 rounded-xl border text-xs {{ $cp->tipe === 'warning' ? 'bg-amber-50/80 border-amber-200 text-amber-900' : ($cp->tipe === 'info' ? 'bg-blue-50/80 border-blue-200 text-blue-900' : 'bg-emerald-50/80 border-emerald-200 text-emerald-900') }}">
                            <span class="text-sm flex-shrink-0">
                                @if($cp->tipe === 'warning') ⚠️ @elseif($cp->tipe === 'info') ℹ️ @else ✅ @endif
                            </span>
                            <span class="font-semibold leading-relaxed">{{ $cp->pesan }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                <span>Standar Jurnalistik LPP TVRI Stasiun Maluku</span>
                <span class="text-emerald-600 font-bold">Siap Siar</span>
            </div>
        </div>
    </div>

    <!-- ===== SECTION: DOKUMEN & SOP NEWSROOM TVRI MALUKU ===== -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm" id="sop">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-4 border-b border-slate-100 gap-3">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-teal-500"></span>
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">
                        Standar Operasional Prosedur (SOP) & Dokumen Newsroom
                    </h3>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Pedoman teknis peliputan, produksi, siaran on-air, kode etik jurnalistik, dan penyiaran multiplatform TVRI Stasiun Maluku
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-teal-50 text-teal-700 border border-teal-200">
                    {{ count($sops) }} Dokumen SOP Aktif
                </span>
                <a href="{{ route('tvri.berita.manage', ['tab' => 'sop']) }}" 
                   class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white shadow-sm transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Kelola SOP Berita</span>
                </a>
                <a href="{{ route('dokumen.documents.index') }}" 
                   class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-all">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Pangkalan Dokumen</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($sops as $sop)
                <div class="p-4 rounded-xl border border-slate-200 hover:border-teal-300 hover:shadow-md transition-all flex flex-col justify-between bg-slate-50/50">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-0.5 rounded-md bg-teal-100 text-teal-800 font-mono text-[10px] font-bold">
                                {{ $sop->kode }}
                            </span>
                            <div class="flex items-center space-x-1.5">
                                <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 text-[9px] font-semibold">
                                    {{ $sop->versi }}
                                </span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-extrabold {{ $sop->status == 'Aktif' ? 'bg-emerald-100 text-emerald-700' : ($sop->status == 'Revisi' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $sop->status == 'Aktif' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                    {{ $sop->status }}
                                </span>
                            </div>
                        </div>

                        <h4 class="text-xs font-bold text-slate-900 leading-snug">
                            {{ $sop->judul }}
                        </h4>

                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            {{ $sop->keterangan ?: 'Prosedur operasional baku penyiaran dan produksi berita TVRI Maluku.' }}
                        </p>
                    </div>

                    <div class="mt-3 pt-3 border-t border-slate-200/60 flex items-center justify-between text-[10px]">
                        <span class="font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded">
                            {{ $sop->kategori }}
                        </span>
                        <a href="{{ route('dokumen.documents.index') }}" class="font-bold text-[#005B9F] hover:underline flex items-center space-x-0.5">
                            <span>Lihat Arsip</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-6 text-slate-400 text-xs">
                    Belum ada dokumen SOP terdata.
                </div>
            @endforelse
        </div>
    </div>

    <!-- ===== FOOTER SLOGAN NEWSROOM ===== -->
    <div class="bg-gradient-to-r from-[#00142A] via-[#002244] to-[#003B70] rounded-3xl p-5 text-white shadow-xl flex flex-col md:flex-row md:items-center md:justify-between gap-4 border border-cyan-400/20">
        <div class="flex flex-wrap items-center gap-2">
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/10 border border-white/15">⚡ Cepat Menyampaikan Fakta</span>
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/10 border border-white/15">🎙 Menguatkan Suara Maluku</span>
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/10 border border-white/15">🛡 Profesional & Berintegritas</span>
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/10 border border-white/15">🤝 Kolaboratif</span>
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/10 border border-white/15">👥 Berorientasi Publik</span>
        </div>

        <div class="text-left md:text-right flex-shrink-0">
            <span class="text-sm font-black text-amber-300 italic tracking-wider">Maluku Bisa! Indonesia Maju!</span>
            <p class="text-[10px] text-blue-300">© 2026 LPP TVRI Stasiun Maluku</p>
        </div>
    </div>

    <!-- ==================== MODAL CRUD INPUT DATA BERITA & RENCANA LIPUTAN ==================== -->
    <div x-show="crudModal" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-3 sm:p-5 bg-slate-900/60 backdrop-blur-sm"
         @keydown.escape.window="crudModal = false">
        <div class="relative w-full max-w-4xl bg-white rounded-3xl p-5 sm:p-7 shadow-2xl border border-slate-200 max-h-[92vh] overflow-y-auto"
             @click.away="crudModal = false">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <h3 class="text-base font-black text-[#00264A] uppercase tracking-wide">Input & Kelola Data Berita</h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span>
                                Real-Time Sync
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">CRUD data berita dan rencana liputan. Setiap input/perubahan otomatis memperbarui 6 KPI Utama secara langsung.</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('tvri.berita.manage') }}" target="_blank" class="hidden sm:inline-flex items-center space-x-1 px-2.5 py-1.5 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                        <span>Buka Halaman Kelola Penuh</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                    <button @click="crudModal = false" class="text-slate-400 hover:text-slate-600 text-2xl font-bold leading-none p-1">&times;</button>
                </div>
            </div>

            <!-- Tab Switcher -->
            <div class="flex items-center space-x-2 my-4 p-1.5 bg-slate-100 rounded-xl">
                <button type="button" 
                        @click="activeModalTab = 'create'" 
                        :class="activeModalTab === 'create' ? 'bg-[#00264A] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="flex-1 py-2 rounded-lg text-xs font-bold transition flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span x-text="isEdit ? 'Ubah Data Berita' : '+ Input Berita / Rencana Liputan Baru'"></span>
                </button>
                <button type="button" 
                        @click="activeModalTab = 'list'; loadBeritaList();" 
                        :class="activeModalTab === 'list' ? 'bg-[#00264A] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="flex-1 py-2 rounded-lg text-xs font-bold transition flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    <span>Daftar Data Berita (CRUD & Hapus)</span>
                </button>
            </div>

            <!-- Alert Toast Message -->
            <div x-show="alertMessage" x-cloak class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-800 flex items-center justify-between transition">
                <span x-text="alertMessage"></span>
                <button type="button" @click="alertMessage = ''" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
            </div>

            <!-- ================= TAB 1: FORM INPUT / EDIT BERITA ================= -->
            <div x-show="activeModalTab === 'create'">
                <form id="modalNewsForm" @submit.prevent="submitNewsForm()" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="periode" value="{{ $periode }}">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Liputan / Berita <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" x-model="formData.judul" required 
                               placeholder="Contoh: Rencana Liputan Peringatan Hari Pahlawan di Ambon"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kategori <span class="text-rose-500">*</span></label>
                            <select name="kategori" x-model="formData.kategori" required 
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach(\App\Http\Controllers\Tvri\BeritaController::KATEGORI as $kat)
                                    <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Format Penyiaran <span class="text-rose-500">*</span></label>
                            <select name="jenis" x-model="formData.jenis" required 
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach(\App\Http\Controllers\Tvri\BeritaController::JENIS as $j)
                                    <option value="{{ $j }}">{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Liputan</label>
                            <select name="lokasi" x-model="formData.lokasi" 
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach(\App\Http\Controllers\Tvri\BeritaController::LOKASI as $lok)
                                    <option value="{{ $lok }}">{{ $lok }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Status Liputan <span class="text-rose-500">*</span></label>
                            <select name="status" x-model="formData.status" required 
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="Rencana">Rencana (Target Liputan)</option>
                                <option value="Dalam Proses">Dalam Proses (Sedang Liputan)</option>
                                <option value="Selesai">Selesai (Liputan Dilakukan)</option>
                                <option value="Terkendala">Terkendala</option>
                                <option value="Batal">Batal</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Reporter / Tim</label>
                            <input type="text" name="reporter" x-model="formData.reporter" placeholder="mis. Tim Redaksi 1"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Durasi Video</label>
                            <input type="text" name="durasi" x-model="formData.durasi" placeholder="mis. 02:30"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Views Digital</label>
                            <input type="number" name="views" x-model="formData.views" min="0"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Rencana Liputan <span class="text-rose-500">*</span></label>
                            <input type="date" name="tanggal_rencana" x-model="formData.tanggal_rencana" required 
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Siar / Tayang</label>
                            <input type="date" name="tanggal_tayang" x-model="formData.tanggal_tayang" 
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <span class="text-[10px] text-slate-400 block mt-1">Mengisi tanggal tayang otomatis menghitung metrik Berita Tayang.</span>
                        </div>
                    </div>

                    <!-- Upload Video Berita (Maks 500 MB) -->
                    <div class="p-3.5 bg-blue-50/70 border border-blue-200 rounded-2xl">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-[#00264A] flex items-center space-x-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span>Upload Video Berita (Maks 500 MB)</span>
                            </label>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-blue-200 text-blue-800">Opsional</span>
                        </div>
                        <input type="file" id="modalVideoFile" name="video_file" accept="video/mp4,video/webm,video/ogg,video/quicktime,video/x-matroska,video/avi"
                               class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#00264A] file:text-white hover:file:bg-[#003B70] cursor-pointer">
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                        <button type="button" @click="resetForm()" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                            Reset Form
                        </button>
                        <div class="flex items-center space-x-2">
                            <button type="button" @click="crudModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                                Batal
                            </button>
                            <button type="submit" :disabled="loading" 
                                    class="px-5 py-2.5 rounded-xl text-xs font-black bg-[#00264A] hover:bg-[#003B70] text-white shadow-md transition flex items-center space-x-1.5">
                                <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span x-text="isEdit ? 'Simpan Perubahan Berita' : 'Simpan & Sinkronkan ke Dashboard'"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ================= TAB 2: DAFTAR BERITA (CRUD & HAPUS) ================= -->
            <div x-show="activeModalTab === 'list'" class="space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2 border-b border-slate-100">
                    <div class="relative flex-1 max-w-sm">
                        <input type="text" x-model="searchQuery" @input.debounce.300ms="loadBeritaList(1)" 
                               placeholder="Cari judul, reporter, lokasi..."
                               class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <div class="flex items-center space-x-2">
                        <select x-model="filterStatus" @change="loadBeritaList(1)" 
                                class="text-xs px-2.5 py-1.5 rounded-xl border border-slate-200 bg-white font-semibold">
                            <option value="Semua">Semua Status</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dalam Proses">Dalam Proses</option>
                            <option value="Rencana">Rencana</option>
                            <option value="Terkendala">Terkendala</option>
                            <option value="Batal">Batal</option>
                        </select>
                        <button type="button" @click="loadBeritaList(1)" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs" title="Segarkan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto max-h-[50vh] border border-slate-100 rounded-2xl">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-[11px] font-extrabold uppercase text-slate-500 border-b border-slate-200 sticky top-0 bg-slate-50">
                            <tr>
                                <th class="py-2.5 px-3">Judul Berita & Kategori</th>
                                <th class="py-2.5 px-3">Lokasi / Tim</th>
                                <th class="py-2.5 px-3 text-center">Status</th>
                                <th class="py-2.5 px-3">Tgl Rencana / Tayang</th>
                                <th class="py-2.5 px-3 text-center">Views</th>
                                <th class="py-2.5 px-3 text-center">Aksi (CRUD)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            <template x-for="item in beritaList" :key="item.id">
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-2 px-3">
                                        <div class="font-bold text-[#00264A]" x-text="item.judul"></div>
                                        <div class="flex items-center space-x-1.5 text-[10px] text-slate-400 mt-0.5">
                                            <span class="px-1.5 py-0.5 rounded bg-blue-50 text-blue-700 font-bold" x-text="item.kategori"></span>
                                            <span>•</span>
                                            <span x-text="item.jenis"></span>
                                        </div>
                                    </td>
                                    <td class="py-2 px-3 text-[11px]">
                                        <div class="font-semibold text-slate-700" x-text="item.lokasi || '-'"></div>
                                        <div class="text-[10px] text-slate-400" x-text="item.reporter || '-'"></div>
                                    </td>
                                    <td class="py-2 px-3 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold" 
                                              :class="{
                                                  'bg-emerald-100 text-emerald-800': item.status === 'Selesai',
                                                  'bg-blue-100 text-blue-800': item.status === 'Dalam Proses',
                                                  'bg-slate-100 text-slate-700': item.status === 'Rencana',
                                                  'bg-amber-100 text-amber-800': item.status === 'Terkendala',
                                                  'bg-rose-100 text-rose-800': item.status === 'Batal'
                                              }" 
                                              x-text="item.status"></span>
                                    </td>
                                    <td class="py-2 px-3 text-[11px] whitespace-nowrap">
                                        <div class="text-slate-600 font-mono" x-text="item.tanggal_rencana ? item.tanggal_rencana.substring(0, 10) : '-'"></div>
                                        <div class="text-[10px] text-emerald-600 font-mono" x-text="item.tanggal_tayang ? 'Tayang: ' + item.tanggal_tayang.substring(0, 10) : 'Belum tayang'"></div>
                                    </td>
                                    <td class="py-2 px-3 text-center font-mono font-bold text-slate-700 text-[11px]" x-text="item.views ? Number(item.views).toLocaleString('id-ID') : 0"></td>
                                    <td class="py-2 px-3 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-1.5">
                                            <button type="button" @click="editBerita(item)" 
                                                    class="inline-flex items-center space-x-1 px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-[10px] font-bold transition"
                                                    title="Edit Berita">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Edit</span>
                                            </button>
                                            <button type="button" @click="deleteBerita(item.id, item.judul)" 
                                                    class="p-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 transition"
                                                    title="Hapus Berita">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template x-if="beritaList.length === 0">
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-slate-400 text-xs">
                                        Tidak ada data berita yang ditemukan.
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100">
                    <div>
                        Menampilkan <span class="font-bold text-slate-700" x-text="beritaList.length"></span> dari <span class="font-bold text-slate-700" x-text="listPagination.total"></span> data berita
                    </div>
                    <div class="flex items-center space-x-1.5">
                        <button type="button" 
                                @click="loadBeritaList(listPagination.current_page - 1)" 
                                :disabled="listPagination.current_page <= 1"
                                class="px-2.5 py-1 rounded-lg border border-slate-200 text-xs font-bold disabled:opacity-40 disabled:cursor-not-allowed hover:bg-slate-50">
                            &larr; Prev
                        </button>
                        <span class="px-2 font-bold text-slate-700" x-text="listPagination.current_page + ' / ' + listPagination.last_page"></span>
                        <button type="button" 
                                @click="loadBeritaList(listPagination.current_page + 1)" 
                                :disabled="listPagination.current_page >= listPagination.last_page"
                                class="px-2.5 py-1 rounded-lg border border-slate-200 text-xs font-bold disabled:opacity-40 disabled:cursor-not-allowed hover:bg-slate-50">
                            Next &rarr;
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== SCRIPT CHART.JS NEWSROOM ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Gauge Newsroom Performance Index
    const gCtx = document.getElementById('gaugeIndexChart').getContext('2d');
    window.gaugeChart = new Chart(gCtx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [{{ $ringkasan->performance_index }}, {{ max(0, 100 - $ringkasan->performance_index) }}],
                backgroundColor: ['#06b6d4', '#e2e8f0'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            circumference: 240,
            rotation: 240,
            cutout: '80%',
            plugins: { legend: { display: false }, tooltip: { enabled: false } }
        }
    });

    // 2. Tren Produksi & Tayang Berita (1 Sep - 10 Sep)
    const trenCtx = document.getElementById('trenBeritaChart').getContext('2d');
    new Chart(trenCtx, {
        type: 'line',
        data: {
            labels: ['1 Sep', '2 Sep', '3 Sep', '4 Sep', '5 Sep', '6 Sep', '7 Sep', '8 Sep', '9 Sep', '10 Sep'],
            datasets: [
                {
                    label: 'Rencana Liputan',
                    data: [45, 48, 52, 58, 65, 72, 78, 84, 90, 95],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: false,
                    tension: 0.2
                },
                {
                    label: 'Berita Diproduksi',
                    data: [38, 41, 45, 50, 58, 64, 70, 76, 82, 86],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2.5,
                    pointRadius: 4,
                    fill: false,
                    tension: 0.2
                },
                {
                    label: 'Berita Tayang',
                    data: [36, 40, 44, 48, 55, 62, 68, 74, 80, 85],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderWidth: 2.5,
                    pointRadius: 4,
                    fill: false,
                    tension: 0.2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 3. Kategori Berita (Donut Chart)
    const katCtx = document.getElementById('kategoriDonutChart').getContext('2d');
    new Chart(katCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_column($kategoriList, 'nama')) !!},
            datasets: [{
                data: {!! json_encode(array_column($kategoriList, 'jumlah')) !!},
                backgroundColor: {!! json_encode(array_column($kategoriList, 'color')) !!},
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: { label: ctx => ctx.label + ': ' + ctx.raw + ' Berita' }
                }
            },
            cutout: '68%'
        }
    });

    // 4. Status Liputan (Donut Chart)
    const stCtx = document.getElementById('statusLiputanChart').getContext('2d');
    new Chart(stCtx, {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Dalam Proses', 'Terkendala', 'Batal'],
            datasets: [{
                data: [
                    {{ $statusList['Selesai']['jumlah'] }},
                    {{ $statusList['Dalam Proses']['jumlah'] }},
                    {{ $statusList['Terkendala']['jumlah'] }},
                    {{ $statusList['Batal']['jumlah'] }}
                ],
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: { label: ctx => ctx.label + ': ' + ctx.raw + ' Liputan' }
                }
            },
            cutout: '70%'
        }
    });
});
</script>

<!-- Modal Video Player -->
<div id="videoModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="relative bg-slate-900 rounded-2xl overflow-hidden border border-slate-700 shadow-2xl max-w-3xl w-full">
        <div class="flex items-center justify-between px-4 py-3 bg-slate-800/80 border-b border-slate-700">
            <h4 id="videoModalTitle" class="text-sm font-bold text-white truncate pr-4">Pemutar Video Berita</h4>
            <button type="button" onclick="closeVideoPlayer()" class="text-slate-400 hover:text-white text-2xl font-bold leading-none p-1">&times;</button>
        </div>
        <div class="p-2 bg-black flex justify-center items-center">
            <video id="videoModalElement" controls class="max-h-[70vh] w-full rounded-lg" preload="metadata">
                <source id="videoModalSource" src="" type="video/mp4">
                Browser Anda tidak mendukung pemutaran video HTML5.
            </video>
        </div>
    </div>
</div>

<script>
function openVideoPlayer(videoUrl, title) {
    const modal = document.getElementById('videoModal');
    const player = document.getElementById('videoModalElement');
    const source = document.getElementById('videoModalSource');
    const titleEl = document.getElementById('videoModalTitle');
    
    titleEl.textContent = title || 'Pemutar Video Berita TVRI Maluku';
    source.src = videoUrl;
    player.load();
    modal.classList.remove('hidden');
    player.play().catch(e => console.log('Autoplay prevented:', e));
}

function closeVideoPlayer() {
    const modal = document.getElementById('videoModal');
    const player = document.getElementById('videoModalElement');
    if (player) {
        player.pause();
    }
    if (modal) {
        modal.classList.add('hidden');
    }
    const source = document.getElementById('videoModalSource');
    if (source) {
        source.src = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeVideoPlayer();
    }
});

function newsroomDashboard() {
    return {
        crudModal: false,
        activeModalTab: 'create',
        alertMessage: '',
        loading: false,
        beritaList: [],
        listPagination: { current_page: 1, last_page: 1, total: 0 },
        searchQuery: '',
        filterStatus: 'Semua',
        filterKategori: 'Semua',
        isEdit: false,
        editId: null,
        formData: {
            judul: '',
            kategori: 'Pemerintahan',
            jenis: 'Berita Reguler',
            lokasi: 'Ambon',
            status: 'Rencana',
            reporter: '',
            durasi: '',
            views: 0,
            tanggal_rencana: '{{ date("Y-m-d") }}',
            tanggal_tayang: '',
        },
        metrics: {
            rencana_liputan: {{ (int) $ringkasan->rencana_liputan }},
            rencana_trend: '{{ $dynamicMetrics["rencana_trend"] ?? "▲ +12%" }}',
            rencana_trend_class: '{{ $dynamicMetrics["rencana_trend_class"] ?? "text-emerald-600" }}',
            liputan_dilakukan: {{ (int) $ringkasan->liputan_dilakukan }},
            pct_dilakukan: {{ (int) ($dynamicMetrics["pct_dilakukan"] ?? 50) }},
            berita_diproduksi: {{ (int) $ringkasan->berita_diproduksi }},
            pct_diproduksi: {{ (int) ($dynamicMetrics["pct_diproduksi"] ?? 80) }},
            diproduksi_trend: '{{ $dynamicMetrics["diproduksi_trend"] ?? "▲ +8%" }}',
            berita_tayang: {{ (int) $ringkasan->berita_tayang }},
            pct_tayang: {{ (int) ($dynamicMetrics["pct_tayang"] ?? 78) }},
            tayang_trend: '{{ $dynamicMetrics["tayang_trend"] ?? "▲ +12%" }}',
            distribusi_digital_formatted: '{{ $dynamicMetrics["distribusi_digital_formatted"] ?? "226 Ribu" }}',
            views_trend: '{{ $dynamicMetrics["views_trend"] ?? "▲ +35%" }}',
            pct_views: {{ (int) ($dynamicMetrics["pct_views"] ?? 90) }},
            performance_index: {{ (int) $ringkasan->performance_index }},
            index_label: '{{ $dynamicMetrics["index_label"] ?? "Cukup" }}',
            index_sublabel: '{!! addslashes($dynamicMetrics["index_sublabel"] ?? "Perlu Peningkatan") !!}',
            index_color: '{{ $dynamicMetrics["index_color"] ?? "text-amber-600" }}',
        },
        init() {
            // Live background polling for realtime KPI updates every 5 seconds
            setInterval(() => {
                this.fetchKpiRealtime();
            }, 5000);
        },
        openNewsCrudModal() {
            this.crudModal = true;
            this.resetForm();
            this.activeModalTab = 'create';
        },
        resetForm() {
            this.isEdit = false;
            this.editId = null;
            this.formData = {
                judul: '',
                kategori: 'Pemerintahan',
                jenis: 'Berita Reguler',
                lokasi: 'Ambon',
                status: 'Rencana',
                reporter: '',
                durasi: '',
                views: 0,
                tanggal_rencana: '{{ date("Y-m-d") }}',
                tanggal_tayang: '',
            };
            const fileInput = document.getElementById('modalVideoFile');
            if (fileInput) fileInput.value = '';
        },
        editBerita(item) {
            this.isEdit = true;
            this.editId = item.id;
            this.formData = {
                judul: item.judul || '',
                kategori: item.kategori || 'Pemerintahan',
                jenis: item.jenis || 'Berita Reguler',
                lokasi: item.lokasi || 'Ambon',
                status: item.status || 'Rencana',
                reporter: item.reporter || '',
                durasi: item.durasi || '',
                views: item.views || 0,
                tanggal_rencana: item.tanggal_rencana ? item.tanggal_rencana.substring(0, 10) : '{{ date("Y-m-d") }}',
                tanggal_tayang: item.tanggal_tayang ? item.tanggal_tayang.substring(0, 10) : '',
            };
            this.activeModalTab = 'create';
        },
        async submitNewsForm() {
            this.loading = true;
            try {
                let url = this.isEdit 
                    ? '{{ url("/tvri/berita") }}/' + this.editId 
                    : '{{ route("tvri.berita.store") }}';
                
                let formEl = document.getElementById('modalNewsForm');
                let data = new FormData(formEl);
                if (this.isEdit) {
                    data.append('_method', 'PUT');
                }

                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: data
                });

                let result = await response.json();
                if (result.success || response.ok) {
                    this.alertMessage = this.isEdit ? 'Berita berhasil diperbarui dan 6 KPI utama disinkronkan!' : 'Berita baru berhasil ditambahkan! Metrik 6 KPI otomatis diperbarui secara real-time.';
                    this.resetForm();
                    await this.fetchKpiRealtime();
                    if (this.activeModalTab === 'list') {
                        this.loadBeritaList(this.listPagination.current_page);
                    }
                } else {
                    alert('Gagal menyimpan berita: ' + (result.message || 'Terjadi kesalahan.'));
                }
            } catch (err) {
                console.error(err);
                document.getElementById('modalNewsForm').submit();
            } finally {
                this.loading = false;
            }
        },
        async deleteBerita(id, judul) {
            if (!confirm('Apakah Anda yakin ingin menghapus berita "' + judul + '"? Tindakan ini akan langsung memperbarui 6 KPI utama di dashboard.')) return;
            try {
                let response = await fetch('{{ url("/tvri/berita") }}/' + id, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({
                        '_method': 'DELETE',
                        '_token': '{{ csrf_token() }}'
                    })
                });
                let result = await response.json();
                if (result.success || response.ok) {
                    this.alertMessage = 'Berita "' + judul + '" berhasil dihapus!';
                    await this.fetchKpiRealtime();
                    this.loadBeritaList(this.listPagination.current_page);
                }
            } catch (err) {
                console.error(err);
            }
        },
        async loadBeritaList(page = 1) {
            try {
                let params = new URLSearchParams({
                    page: page,
                    q: this.searchQuery,
                    status: this.filterStatus,
                    kategori: this.filterKategori
                });
                let res = await fetch('{{ route("tvri.berita.list-json") }}?' + params.toString());
                let data = await res.json();
                this.beritaList = data.data || [];
                this.listPagination = {
                    current_page: data.current_page || 1,
                    last_page: data.last_page || 1,
                    total: data.total || 0
                };
            } catch (e) {
                console.error('Error loading news list:', e);
            }
        },
        async fetchKpiRealtime() {
            try {
                let res = await fetch('{{ route("tvri.berita.kpi-realtime") }}?periode={{ $periode }}');
                let data = await res.json();
                if (data.status === 'success' && data.metrics) {
                    this.metrics = data.metrics;
                    if (window.gaugeChart && data.metrics.performance_index !== undefined) {
                        window.gaugeChart.data.datasets[0].data = [
                            data.metrics.performance_index, 
                            Math.max(0, 100 - data.metrics.performance_index)
                        ];
                        window.gaugeChart.update();
                    }
                }
            } catch (e) {
                console.error('Polling error:', e);
            }
        }
    };
}
</script>
@endsection
