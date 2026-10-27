@extends('layouts.app')

@section('title', 'Kelola & Input Data Berita (Newsroom) - TVRI Maluku')

@php
    $currentTab = request('tab', $tab ?? 'berita');
    use App\Http\Controllers\Tvri\BeritaController;
@endphp

@section('content')
<div class="space-y-6 pb-12" x-data="{ activeTab: '{{ $currentTab }}', editBerita: null }">

    <!-- ===== HEADER MANAJEMEN BERITA ===== -->
    <div class="relative bg-gradient-to-r from-[#00142A] via-[#002244] to-[#003B70] rounded-3xl p-6 sm:p-7 text-white shadow-xl overflow-hidden border border-cyan-400/20">
        <div class="absolute -right-10 -top-16 w-72 h-72 bg-cyan-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-2xl bg-white p-2 shadow-lg flex-shrink-0 flex items-center justify-center border border-cyan-300/40">
                    <img src="{{ asset('images/logo_tvri.png') }}" alt="Logo TVRI" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-cyan-400/20 text-cyan-300 border border-cyan-400/30">
                            CRUD DATA NEWSROOM
                        </span>
                        <span class="text-xs text-blue-200 font-bold">Periode: {{ $periode }}</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black tracking-tight text-white mt-1 leading-tight uppercase">
                        Kelola & Input Data Berita
                    </h1>
                    <p class="text-xs text-blue-300 font-medium">
                        Input liputan, produksi berita, real time feeds, agenda liputan, dan peringatan redaksi yang terhubung ke Dashboard Berita.
                    </p>
                </div>
            </div>

            <!-- Header Jam Real-Time & Action Buttons -->
            <div class="flex items-center space-x-2.5 flex-wrap gap-2">
                <!-- Jam, Hari, Tanggal, Tahun Real-Time Widget -->
                <div class="bg-black/35 backdrop-blur-md px-3.5 py-2 rounded-2xl border border-cyan-400/30 shadow-inner flex items-center space-x-2.5">
                    <div class="relative flex items-center justify-center">
                        <span class="animate-ping absolute inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-cyan-300 leading-tight flex items-center space-x-1">
                            <svg class="w-3 h-3 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span id="realtimeDayDate">Memuat Waktu...</span>
                        </div>
                        <div class="text-xs sm:text-sm font-black font-mono tracking-wider text-white mt-0.5 leading-none flex items-center space-x-1">
                            <svg class="w-3 h-3 text-amber-300 animate-spin" style="animation-duration: 8s;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span id="realtimeClock">--:--:-- WIT</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('tvri.berita.dashboard') }}" 
                   class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-2xl text-xs font-black bg-cyan-600 hover:bg-cyan-700 text-white shadow-md border border-cyan-400/30 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Dashboard Berita</span>
                </a>
                <a href="{{ route('dokumen.documents.index') }}" 
                   class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-2xl text-xs font-black bg-white/10 hover:bg-white/20 text-white border border-white/20 transition-all">
                    <svg class="w-4 h-4 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Pangkalan Dokumen</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ===== TAB NAVIGASI CRUD BERITA ===== -->
    <div class="bg-white rounded-2xl p-2 border border-slate-200 shadow-sm flex items-center space-x-1.5 overflow-x-auto">
        <button @click="activeTab = 'berita'" 
                :class="activeTab === 'berita' ? 'bg-[#005B9F] text-white shadow-sm font-black' : 'text-slate-600 hover:bg-slate-100 font-bold'"
                class="px-4 py-2 rounded-xl text-xs transition-all whitespace-nowrap flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            <span>Daftar Berita (CRUD)</span>
        </button>

        <button @click="activeTab = 'ringkasan'" 
                :class="activeTab === 'ringkasan' ? 'bg-[#005B9F] text-white shadow-sm font-black' : 'text-slate-600 hover:bg-slate-100 font-bold'"
                class="px-4 py-2 rounded-xl text-xs transition-all whitespace-nowrap flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span>Metrik & Ringkasan Newsroom</span>
        </button>

        <button @click="activeTab = 'realtime'" 
                :class="activeTab === 'realtime' ? 'bg-[#005B9F] text-white shadow-sm font-black' : 'text-slate-600 hover:bg-slate-100 font-bold'"
                class="px-4 py-2 rounded-xl text-xs transition-all whitespace-nowrap flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            <span>Real Time Feeds (• LIVE)</span>
        </button>

        <button @click="activeTab = 'agenda'" 
                :class="activeTab === 'agenda' ? 'bg-[#005B9F] text-white shadow-sm font-black' : 'text-slate-600 hover:bg-slate-100 font-bold'"
                class="px-4 py-2 rounded-xl text-xs transition-all whitespace-nowrap flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span>Agenda Liputan</span>
        </button>

        <button @click="activeTab = 'catatan'" 
                :class="activeTab === 'catatan' ? 'bg-[#005B9F] text-white shadow-sm font-black' : 'text-slate-600 hover:bg-slate-100 font-bold'"
                class="px-4 py-2 rounded-xl text-xs transition-all whitespace-nowrap flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span>Peringatan & Catatan</span>
        </button>

        <button @click="activeTab = 'sop'" 
                :class="activeTab === 'sop' ? 'bg-[#005B9F] text-white shadow-sm font-black' : 'text-slate-600 hover:bg-slate-100 font-bold'"
                class="px-4 py-2 rounded-xl text-xs transition-all whitespace-nowrap flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span>Dokumen & SOP Berita</span>
        </button>
    </div>

    <!-- ========================================== -->
    <!-- TAB 1: DAFTAR BERITA (CRUD LENGKAP)        -->
    <!-- ========================================== -->
    <div x-show="activeTab === 'berita'" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Form Tambah Berita Baru -->
            <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm h-fit">
                <div class="flex items-center space-x-2 pb-3 mb-4 border-b border-slate-100">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Tambah Berita Baru</h3>
                </div>

                <form action="{{ route('tvri.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Berita</label>
                        <input type="text" name="judul" required placeholder="Festival Budaya Pela Gandong di Ambon"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                            <select name="kategori" required class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                                @foreach(BeritaController::KATEGORI as $kat)
                                    <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Format Penyiaran</label>
                            <select name="jenis" required class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                                @foreach(BeritaController::JENIS as $j)
                                    <option value="{{ $j }}">{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Liputan</label>
                            <select name="lokasi" class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                                @foreach(BeritaController::LOKASI as $lok)
                                    <option value="{{ $lok }}">{{ $lok }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Status</label>
                            <select name="status" required class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                                @foreach(BeritaController::STATUS as $st)
                                    <option value="{{ $st }}">{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Reporter / Tim</label>
                            <input type="text" name="reporter" placeholder="Tim 1"
                                   class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Durasi Video</label>
                            <input type="text" name="durasi" placeholder="02:35"
                                   class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Views Digital</label>
                            <input type="number" name="views" value="0"
                                   class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tgl Rencana</label>
                            <input type="date" name="tanggal_rencana" required value="{{ date('Y-m-d') }}"
                                   class="w-full px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tgl Tayang</label>
                            <input type="date" name="tanggal_tayang"
                                   class="w-full px-2.5 py-1.5 rounded-xl border border-slate-200 text-xs">
                        </div>
                    </div>

                    <!-- Kotak Upload Video (Maks 500 MB) -->
                    <div class="p-3 bg-blue-50/80 rounded-xl border border-blue-200">
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-[#00264A] flex items-center space-x-1">
                                <span>🎬 Upload Video Berita (Maks 500 MB)</span>
                            </label>
                            <span class="px-1.5 py-0.5 rounded bg-blue-200 text-blue-900 text-[9px] font-black uppercase">Maks 500 MB</span>
                        </div>
                        <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg,video/quicktime,video/x-matroska,video/avi"
                               onchange="if(this.files[0] && this.files[0].size > 524288000){ alert('Ukuran video ' + (this.files[0].size/1048576).toFixed(2) + ' MB melebihi batas maksimal 500 MB. Silakan kompres atau pilih video lain.'); this.value=''; }"
                               class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        <p class="text-[10px] text-blue-600 font-medium mt-1">
                            Format didukung: MP4, WebM, MOV, MKV. Resolusi/ukuran file maksimal 500 MB.
                        </p>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-md transition-all">
                        + Tambah Berita & Upload Video
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Berita -->
            <div class="lg:col-span-8 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 flex-wrap gap-2">
                    <div>
                        <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">
                            Daftar Berita Terbaru & Liputan
                        </h3>
                        <p class="text-xs text-slate-500">Mempengaruhi tayangan Berita Terbaru Siap Siar, video cards, dan status grafik</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <form action="{{ route('tvri.berita.reseed') }}" method="POST" onsubmit="return confirm('Pulihkan 120 data berita standar TVRI Maluku & sinkronkan ulang seluruh dashboard?')">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-200 transition-all flex items-center space-x-1" title="Pulihkan 120 Data Berita Standar">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                <span>Pulihkan Data Standar (120 Berita)</span>
                            </button>
                        </form>
                        <button type="button" id="btnBulkDeleteBerita" onclick="submitBulkDeleteBerita()" class="hidden px-3 py-1.5 rounded-xl bg-rose-600 text-white font-black text-xs hover:bg-rose-700 shadow-md transition-all flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            <span id="btnBulkDeleteBeritaText">Hapus File/Berita Terpilih</span>
                        </button>
                    </div>
                </div>

                <!-- Bulk Delete Form for Berita (Kotak Central) -->
                <form id="formBulkDeleteBerita" action="{{ route('tvri.berita.bulk-destroy') }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="tab" value="berita">
                    <div id="bulkDeleteBeritaContainer"></div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 text-[10px] uppercase font-bold">
                                <th class="py-2.5 w-8 text-center">
                                    <input type="checkbox" id="checkAllBerita" class="rounded border-slate-300 text-blue-600 w-4 h-4 cursor-pointer" title="Kotak Central: Centang Semua untuk Hapus File/Berita">
                                </th>
                                <th class="py-2.5">Judul & File Video</th>
                                <th class="py-2.5">Kategori / Format</th>
                                <th class="py-2.5">Lokasi</th>
                                <th class="py-2.5 text-center">Status</th>
                                <th class="py-2.5 text-center">Aksi & File</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($beritas as $b)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <form id="formRowBerita{{ $b->id }}" action="{{ route('tvri.berita.update', $b->id) }}" method="POST" enctype="multipart/form-data" class="hidden">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="tanggal_rencana" value="{{ $b->tanggal_rencana ? (is_string($b->tanggal_rencana) ? substr($b->tanggal_rencana, 0, 10) : $b->tanggal_rencana->format('Y-m-d')) : date('Y-m-d') }}">
                                    </form>

                                    <td class="py-2 text-center">
                                        <input type="checkbox" value="{{ $b->id }}" class="berita-checkbox rounded border-slate-300 text-blue-600 cursor-pointer">
                                    </td>
                                    <td class="py-2 max-w-[200px]">
                                        <input type="text" form="formRowBerita{{ $b->id }}" name="judul" value="{{ $b->judul }}" class="w-full px-2 py-1 rounded border border-slate-200 text-xs font-bold text-slate-800">
                                        <div class="flex items-center space-x-1.5 mt-0.5 text-[10px] text-slate-400 flex-wrap">
                                            <span>{{ $b->reporter ?? 'Tim Redaksi' }}</span>
                                            <span>&bull;</span>
                                            <input type="text" form="formRowBerita{{ $b->id }}" name="durasi" value="{{ $b->durasi ?? '02:00' }}" class="w-12 px-1 py-0.5 rounded border border-slate-200 text-[10px] text-slate-600 font-mono text-center" title="Durasi Video">
                                            <span>&bull;</span>
                                            <span>{{ number_format($b->views) }} views</span>
                                        </div>
                                        @if($b->video_file)
                                            <div class="mt-1 flex items-center space-x-1.5">
                                                <a href="{{ $b->video_url }}" target="_blank" class="inline-flex items-center space-x-1 px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[9px] font-extrabold hover:bg-emerald-200" title="Putar / Unduh Video">
                                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 2h8v8H6V6z"/></svg>
                                                    <span>🎬 Video (Maks 10MB)</span>
                                                </a>
                                                <button type="button" onclick="if(confirm('Hapus file video pada berita ini?')) document.getElementById('formDeleteVideo{{ $b->id }}').submit()" class="text-rose-600 hover:text-rose-800 text-[9px] font-bold underline" title="Hapus hanya file video">
                                                    Hapus File
                                                </button>
                                            </div>
                                        @else
                                            <div class="mt-1 flex items-center space-x-1">
                                                <input type="file" form="formRowBerita{{ $b->id }}" name="video_file" accept="video/*" class="text-[9px] text-slate-400 file:py-0.5 file:px-1.5 file:rounded file:border-0 file:text-[9px] file:bg-slate-100 file:text-slate-600 cursor-pointer" title="Upload Video (Maks 500 MB)">
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-2">
                                        <select form="formRowBerita{{ $b->id }}" name="kategori" class="w-full px-1.5 py-1 rounded border border-slate-200 text-[10px] font-semibold">
                                            @foreach(BeritaController::KATEGORI as $kat)
                                                <option value="{{ $kat }}" {{ $b->kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                            @endforeach
                                        </select>
                                        <select form="formRowBerita{{ $b->id }}" name="jenis" class="w-full px-1.5 py-1 rounded border border-slate-200 text-[10px] text-slate-500 mt-1">
                                            @foreach(BeritaController::JENIS as $j)
                                                <option value="{{ $j }}" {{ $b->jenis == $j ? 'selected' : '' }}>{{ $j }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2">
                                        <select form="formRowBerita{{ $b->id }}" name="lokasi" class="w-24 px-1.5 py-1 rounded border border-slate-200 text-[10px]">
                                            @foreach(BeritaController::LOKASI as $lok)
                                                <option value="{{ $lok }}" {{ $b->lokasi == $lok ? 'selected' : '' }}>{{ $lok }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2 text-center">
                                        <select form="formRowBerita{{ $b->id }}" name="status" class="px-2 py-1 rounded border border-slate-200 text-[10px] font-bold">
                                            @foreach(BeritaController::STATUS as $st)
                                                <option value="{{ $st }}" {{ $b->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2 text-center">
                                        <div class="flex items-center justify-center space-x-1">
                                            <button type="submit" form="formRowBerita{{ $b->id }}" class="p-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors" title="Simpan Perubahan & File">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                            <form action="{{ route('tvri.berita.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus berita dan file video terkait?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors" title="Hapus Berita & File">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>

                                        @if($b->video_file)
                                            <form id="formDeleteVideo{{ $b->id }}" action="{{ route('tvri.berita.delete-video', $b->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-slate-400">Belum ada data berita.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100">
                    {{ $beritas->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 2: METRIK & RINGKASAN NEWSROOM         -->
    <!-- ========================================== -->
    <div x-show="activeTab === 'ringkasan'" class="space-y-6">
        <form action="{{ route('tvri.berita.ringkasan.update') }}" method="POST">
            @csrf
            <input type="hidden" name="periode" value="{{ $periode }}">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Card 1: 6 KPI Cards Utama -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                            <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">6 KPI Cards Utama</h3>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            ✓ Otomatis dari Input Berita
                        </span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Rencana Liputan</label>
                            <input type="number" name="rencana_liputan" value="{{ old('rencana_liputan', $ringkasan->rencana_liputan) }}"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-blue-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Liputan Dilakukan</label>
                            <input type="number" name="liputan_dilakukan" value="{{ old('liputan_dilakukan', $ringkasan->liputan_dilakukan) }}"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-emerald-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Berita Diproduksi</label>
                            <input type="number" name="berita_diproduksi" value="{{ old('berita_diproduksi', $ringkasan->berita_diproduksi) }}"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-amber-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Berita Tayang</label>
                            <input type="number" name="berita_tayang" value="{{ old('berita_tayang', $ringkasan->berita_tayang) }}"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-rose-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Views Digital</label>
                            <input type="number" name="views_digital" value="{{ old('views_digital', $ringkasan->views_digital) }}"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-purple-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Performance Index (%)</label>
                            <input type="number" min="0" max="100" name="performance_index" value="{{ old('performance_index', $ringkasan->performance_index) }}"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-cyan-700">
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100">
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Kecepatan Publikasi Rata-rata (Menit)</label>
                        <input type="number" name="kecepatan_publikasi_menit" value="{{ old('kecepatan_publikasi_menit', $ringkasan->kecepatan_publikasi_menit) }}"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                    </div>
                </div>

                <!-- Card 2: Distribusi Media & Checklist Kualitas -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center space-x-2 pb-3 border-b border-slate-100">
                        <span class="w-3 h-3 rounded-full bg-cyan-500"></span>
                        <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Distribusi Media & Kualitas</h3>
                    </div>

                    <p class="text-xs font-black text-slate-400 uppercase tracking-wider">Jumlah Tayang per Media</p>
                    <div class="grid grid-cols-5 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 mb-1">TV</label>
                            <input type="number" name="dist_tv" value="{{ $ringkasan->dist_tv }}" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs text-center font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 mb-1">Website</label>
                            <input type="number" name="dist_website" value="{{ $ringkasan->dist_website }}" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs text-center font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 mb-1">YouTube</label>
                            <input type="number" name="dist_youtube" value="{{ $ringkasan->dist_youtube }}" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs text-center font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 mb-1">Instagram</label>
                            <input type="number" name="dist_instagram" value="{{ $ringkasan->dist_instagram }}" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs text-center font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 mb-1">TikTok</label>
                            <input type="number" name="dist_tiktok" value="{{ $ringkasan->dist_tiktok }}" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs text-center font-bold">
                        </div>
                    </div>

                    <p class="text-xs font-black text-slate-400 uppercase tracking-wider pt-2 border-t border-slate-100">Kepatuhan Kualitas Berita (%)</p>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <label class="text-[10px] text-slate-600 font-bold block">Fakta Terverifikasi</label>
                            <input type="number" min="0" max="100" name="kualitas_fakta" value="{{ $ringkasan->kualitas_fakta }}" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 font-bold">
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-600 font-bold block">Kode Etik Jurnalistik</label>
                            <input type="number" min="0" max="100" name="kualitas_etik" value="{{ $ringkasan->kualitas_etik }}" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 font-bold">
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-600 font-bold block">Akurasi Data</label>
                            <input type="number" min="0" max="100" name="kualitas_akurasi" value="{{ $ringkasan->kualitas_akurasi }}" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 font-bold">
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-600 font-bold block">Penggunaan Visual</label>
                            <input type="number" min="0" max="100" name="kualitas_visual" value="{{ $ringkasan->kualitas_visual }}" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 font-bold">
                        </div>
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white font-black text-xs shadow-md transition-all">
                            Simpan Seluruh Metrik Newsroom
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- ========================================== -->
    <!-- TAB 3: REAL TIME NEWSROOM FEEDS            -->
    <!-- ========================================== -->
    <div x-show="activeTab === 'realtime'" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Form Tambah Feed -->
            <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm h-fit">
                <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide pb-3 mb-4 border-b border-slate-100">+ Tambah Feed Live Newsroom</h3>
                <form action="{{ route('tvri.berita.realtime.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Waktu (Contoh: 10:24)</label>
                        <input type="text" name="waktu" required placeholder="10:24" value="{{ now()->format('H:i') }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Aktivitas / Kegiatan Redaksi</label>
                        <textarea name="kegiatan" required rows="3" placeholder="Tim liputan di Ambon kirim footage - Festival Budaya" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md">
                        + Tambah Feed Real Time
                    </button>
                </form>
            </div>

            <!-- Tabel Feed -->
            <div class="lg:col-span-8 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 flex-wrap gap-2">
                    <div class="flex items-center space-x-2.5">
                        <input type="checkbox" id="checkAllRealtime" class="rounded border-slate-300 text-blue-600 w-4 h-4 cursor-pointer" title="Kotak Central: Centang Semua Feed untuk Dihapus">
                        <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Daftar Feed Live Newsroom</h3>
                    </div>
                    <button type="button" id="btnBulkDeleteRealtime" onclick="submitBulkDeleteRealtime()" class="hidden px-3 py-1.5 rounded-xl bg-rose-600 text-white font-black text-xs hover:bg-rose-700 shadow-md transition-all flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span id="btnBulkDeleteRealtimeText">Hapus Feed Terpilih</span>
                    </button>
                </div>

                <!-- Bulk Delete Form for Realtime (Kotak Central) -->
                <form id="formBulkDeleteRealtime" action="{{ route('tvri.berita.realtime.bulk-destroy') }}" method="POST" class="hidden">
                    @csrf
                    <div id="bulkDeleteRealtimeContainer"></div>
                </form>

                <div class="space-y-2">
                    @forelse($realtimeFeeds as $feed)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs gap-2">
                            <input type="checkbox" value="{{ $feed->id }}" class="realtime-checkbox rounded border-slate-300 text-blue-600 w-4 h-4 cursor-pointer flex-shrink-0" title="Pilih feed ini">
                            <form action="{{ route('tvri.berita.realtime.update', $feed->id) }}" method="POST" class="flex-1 flex items-center space-x-2 mr-2">
                                @csrf
                                @method('PUT')
                                <input type="text" name="waktu" value="{{ $feed->waktu }}" class="w-16 px-2 py-1 rounded border border-slate-200 font-bold text-blue-700 text-center">
                                <input type="text" name="kegiatan" value="{{ $feed->kegiatan }}" class="flex-1 px-2 py-1 rounded border border-slate-200 font-semibold">
                                <button type="submit" class="p-1 rounded bg-blue-100 text-blue-700 hover:bg-blue-200" title="Simpan">✓</button>
                            </form>
                            <form action="{{ route('tvri.berita.realtime.destroy', $feed->id) }}" method="POST" onsubmit="return confirm('Hapus feed ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 rounded bg-rose-100 text-rose-700 hover:bg-rose-200" title="Hapus">✕</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada feed live.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 4: AGENDA LIPUTAN HARI INI             -->
    <!-- ========================================== -->
    <div x-show="activeTab === 'agenda'" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Form Tambah Agenda -->
            <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm h-fit">
                <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide pb-3 mb-4 border-b border-slate-100">+ Tambah Agenda Liputan</h3>
                <form action="{{ route('tvri.berita.agenda.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Waktu</label>
                        <input type="text" name="waktu" required placeholder="09:00" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Agenda Liputan</label>
                        <input type="text" name="agenda" required placeholder="Festival Budaya" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi</label>
                        <input type="text" name="lokasi" required placeholder="Ambon" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">PIC Tim</label>
                        <input type="text" name="pic" required placeholder="Tim 1" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                            <option value="Selesai">Selesai</option>
                            <option value="On Air">On Air</option>
                            <option value="Proses">Proses</option>
                            <option value="Terjadwal">Terjadwal</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md">
                        + Tambah Agenda
                    </button>
                </form>
            </div>

            <!-- Tabel Agenda -->
            <div class="lg:col-span-8 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 flex-wrap gap-2">
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Daftar Agenda Liputan Hari Ini</h3>
                    <button type="button" id="btnBulkDeleteAgenda" onclick="submitBulkDeleteAgenda()" class="hidden px-3 py-1.5 rounded-xl bg-rose-600 text-white font-black text-xs hover:bg-rose-700 shadow-md transition-all flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span id="btnBulkDeleteAgendaText">Hapus Agenda Terpilih</span>
                    </button>
                </div>

                <!-- Bulk Delete Form for Agenda (Kotak Central) -->
                <form id="formBulkDeleteAgenda" action="{{ route('tvri.berita.agenda.bulk-destroy') }}" method="POST" class="hidden">
                    @csrf
                    <div id="bulkDeleteAgendaContainer"></div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 text-[10px] uppercase font-bold">
                                <th class="py-2 w-8 text-center">
                                    <input type="checkbox" id="checkAllAgenda" class="rounded border-slate-300 text-blue-600 w-4 h-4 cursor-pointer" title="Kotak Central: Centang Semua Agenda untuk Dihapus">
                                </th>
                                <th class="py-2">Waktu</th>
                                <th class="py-2">Agenda</th>
                                <th class="py-2">Lokasi</th>
                                <th class="py-2">PIC</th>
                                <th class="py-2 text-center">Status</th>
                                <th class="py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($agendaLiputan as $ag)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-2 text-center">
                                        <input type="checkbox" value="{{ $ag->id }}" class="agenda-checkbox rounded border-slate-300 text-blue-600 w-4 h-4 cursor-pointer" title="Pilih agenda ini">
                                    </td>
                                    <form action="{{ route('tvri.berita.agenda.update', $ag->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <td class="py-2 w-16">
                                            <input type="text" name="waktu" value="{{ $ag->waktu }}" class="w-full px-1 py-1 rounded border border-slate-200 text-xs font-bold text-center">
                                        </td>
                                        <td class="py-2">
                                            <input type="text" name="agenda" value="{{ $ag->agenda }}" class="w-full px-2 py-1 rounded border border-slate-200 text-xs font-semibold">
                                        </td>
                                        <td class="py-2">
                                            <input type="text" name="lokasi" value="{{ $ag->lokasi }}" class="w-24 px-1 py-1 rounded border border-slate-200 text-xs">
                                        </td>
                                        <td class="py-2">
                                            <input type="text" name="pic" value="{{ $ag->pic }}" class="w-20 px-1 py-1 rounded border border-slate-200 text-xs">
                                        </td>
                                        <td class="py-2 text-center">
                                            <select name="status" class="px-1 py-1 rounded border border-slate-200 text-[10px] font-bold">
                                                <option value="Selesai" {{ $ag->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="On Air" {{ $ag->status == 'On Air' ? 'selected' : '' }}>On Air</option>
                                                <option value="Proses" {{ $ag->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="Terjadwal" {{ $ag->status == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                            </select>
                                        </td>
                                        <td class="py-2 text-center">
                                            <div class="flex items-center justify-center space-x-1">
                                                <button type="submit" class="p-1 rounded bg-blue-100 text-blue-700" title="Simpan">✓</button>
                                    </form>
                                                <form action="{{ route('tvri.berita.agenda.destroy', $ag->id) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 rounded bg-rose-100 text-rose-700" title="Hapus">✕</button>
                                                </form>
                                            </div>
                                        </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center text-slate-400">Belum ada agenda liputan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 5: PERINGATAN & CATATAN REDAKSI        -->
    <!-- ========================================== -->
    <div x-show="activeTab === 'catatan'" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Form Tambah Catatan -->
            <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm h-fit">
                <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide pb-3 mb-4 border-b border-slate-100">+ Tambah Peringatan / Catatan</h3>
                <form action="{{ route('tvri.berita.catatan.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tipe Catatan</label>
                        <select name="tipe" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                            <option value="warning">⚠️ Peringatan (Warning)</option>
                            <option value="info">ℹ️ Informasi (Info)</option>
                            <option value="success">✅ Kepatuhan (Success)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Pesan / Catatan Redaksi</label>
                        <textarea name="pesan" required rows="3" placeholder="Footage dari SBT belum masuk" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md">
                        + Tambah Catatan
                    </button>
                </form>
            </div>

            <!-- Tabel Catatan -->
            <div class="lg:col-span-8 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 flex-wrap gap-2">
                    <div class="flex items-center space-x-2.5">
                        <input type="checkbox" id="checkAllCatatan" class="rounded border-slate-300 text-blue-600 w-4 h-4 cursor-pointer" title="Kotak Central: Centang Semua Catatan untuk Dihapus">
                        <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Daftar Peringatan & Catatan Redaksi</h3>
                    </div>
                    <button type="button" id="btnBulkDeleteCatatan" onclick="submitBulkDeleteCatatan()" class="hidden px-3 py-1.5 rounded-xl bg-rose-600 text-white font-black text-xs hover:bg-rose-700 shadow-md transition-all flex items-center space-x-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span id="btnBulkDeleteCatatanText">Hapus Catatan Terpilih</span>
                    </button>
                </div>

                <!-- Bulk Delete Form for Catatan (Kotak Central) -->
                <form id="formBulkDeleteCatatan" action="{{ route('tvri.berita.catatan.bulk-destroy') }}" method="POST" class="hidden">
                    @csrf
                    <div id="bulkDeleteCatatanContainer"></div>
                </form>

                <div class="space-y-2">
                    @forelse($catatans as $c)
                        <div class="flex items-center justify-between p-3 rounded-xl border text-xs gap-2 {{ $c->tipe === 'warning' ? 'bg-amber-50 border-amber-200 text-amber-900' : ($c->tipe === 'info' ? 'bg-blue-50 border-blue-200 text-blue-900' : 'bg-emerald-50 border-emerald-200 text-emerald-900') }}">
                            <input type="checkbox" value="{{ $c->id }}" class="catatan-checkbox rounded border-slate-300 text-blue-600 w-4 h-4 cursor-pointer flex-shrink-0" title="Pilih catatan ini">
                            <form action="{{ route('tvri.berita.catatan.update', $c->id) }}" method="POST" class="flex-1 flex items-center space-x-2 mr-2">
                                @csrf
                                @method('PUT')
                                <select name="tipe" class="px-2 py-1 rounded border border-slate-200 text-[10px] font-bold">
                                    <option value="warning" {{ $c->tipe == 'warning' ? 'selected' : '' }}>⚠️ Warning</option>
                                    <option value="info" {{ $c->tipe == 'info' ? 'selected' : '' }}>ℹ️ Info</option>
                                    <option value="success" {{ $c->tipe == 'success' ? 'selected' : '' }}>✅ Success</option>
                                </select>
                                <input type="text" name="pesan" value="{{ $c->pesan }}" class="flex-1 px-2 py-1 rounded border border-slate-200 font-semibold text-slate-800">
                                <button type="submit" class="p-1 rounded bg-white shadow-sm" title="Simpan">✓</button>
                            </form>
                            <form action="{{ route('tvri.berita.catatan.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 rounded bg-rose-100 text-rose-700" title="Hapus">✕</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada catatan redaksi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB 6: DOKUMEN & SOP BERITA (CRUD)         -->
    <!-- ========================================== -->
    <div x-show="activeTab === 'sop'" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Form Tambah SOP Berita (4 Kolom) -->
            <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm h-fit">
                <div class="flex items-center space-x-2 pb-3 mb-4 border-b border-slate-100">
                    <div class="w-7 h-7 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <h3 class="text-sm font-black text-[#00264A] uppercase tracking-wide">Tambah SOP Berita</h3>
                </div>

                <form action="{{ route('tvri.berita.sop.store') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <input type="hidden" name="periode" value="{{ $periode }}">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kode SOP</label>
                        <input type="text" name="kode" required placeholder="SOP-BRT-07"
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold text-teal-700 focus:ring-2 focus:ring-teal-500">
                        <p class="text-[10px] text-slate-400 mt-0.5">Contoh: SOP-BRT-01, SOP-BRT-02</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul SOP / Prosedur</label>
                        <input type="text" name="judul" required placeholder="SOP Liputan Investigasi & Cek Fakta..."
                               class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-teal-500">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                            <select name="kategori" required class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold">
                                <option value="Peliputan">Peliputan</option>
                                <option value="Produksi">Produksi</option>
                                <option value="Penyiaran">Penyiaran</option>
                                <option value="Penyiaran Khusus">Penyiaran Khusus</option>
                                <option value="Distribusi Digital">Distribusi Digital</option>
                                <option value="Kode Etik & Regulasi">Kode Etik & Regulasi</option>
                                <option value="Manajemen Redaksi">Manajemen Redaksi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Versi Dokumen</label>
                            <input type="text" name="versi" value="v1.0" placeholder="v1.0"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Status SOP</label>
                            <select name="status" required class="w-full px-2.5 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                                <option value="Aktif">Aktif</option>
                                <option value="Revisi">Revisi</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampil</label>
                            <input type="number" name="urutan" value="{{ count($sops) + 1 }}"
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Uraian / Ringkasan Prosedur</label>
                        <textarea name="keterangan" rows="3" placeholder="Uraian ringkas langkah kerja dan dasar hukum SOP..."
                                  class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-black text-xs shadow-md transition-all">
                        Simpan SOP Berita
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar SOP Berita (8 Kolom) -->
            <div class="lg:col-span-8 bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 flex-wrap gap-2">
                    <div>
                        <h3 class="text-sm font-bold text-[#00264A] uppercase tracking-wide">Daftar Dokumen & SOP Newsroom</h3>
                        <p class="text-xs text-slate-500">Standar operasional liputan, produksi, penyiaran, kode etik jurnalistik, dan distribusi digital TVRI Maluku</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-teal-50 text-teal-700 border border-teal-200">
                            {{ count($sops) }} Dokumen SOP
                        </span>
                        <button type="button" id="btnBulkDeleteSop" onclick="submitBulkDeleteSop()" class="hidden px-2.5 py-1 rounded-xl bg-rose-600 text-white font-bold text-[10px] hover:bg-rose-700 shadow-sm transition-all">
                            Hapus Terpilih
                        </button>
                    </div>
                </div>

                <form id="formBulkDeleteSop" action="{{ route('tvri.berita.sop.bulk-destroy') }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="periode" value="{{ $periode }}">
                    <div id="bulkDeleteSopContainer"></div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 text-[10px] uppercase font-bold">
                                <th class="py-2.5 w-8 text-center">
                                    <input type="checkbox" id="checkAllSop" class="rounded border-slate-300 text-teal-600 cursor-pointer" title="Centang Semua SOP">
                                </th>
                                <th class="py-2.5 w-12 text-center">No</th>
                                <th class="py-2.5 w-24">Kode</th>
                                <th class="py-2.5">Judul SOP & Keterangan</th>
                                <th class="py-2.5 w-28">Kategori</th>
                                <th class="py-2.5 w-16 text-center">Versi</th>
                                <th class="py-2.5 w-20 text-center">Status</th>
                                <th class="py-2.5 w-20 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($sops as $sop)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <form id="formRowSop{{ $sop->id }}" action="{{ route('tvri.berita.sop.update', $sop->id) }}" method="POST" class="hidden">
                                        @csrf
                                        <input type="hidden" name="periode" value="{{ $periode }}">
                                    </form>

                                    <td class="py-2.5 text-center">
                                        <input type="checkbox" value="{{ $sop->id }}" class="sop-checkbox rounded border-slate-300 text-teal-600 cursor-pointer">
                                    </td>
                                    <td class="py-2.5 text-center">
                                        <input type="number" form="formRowSop{{ $sop->id }}" name="urutan" value="{{ $sop->urutan }}" class="w-10 px-1 py-1 rounded border border-slate-200 text-xs font-bold text-center">
                                    </td>
                                    <td class="py-2.5">
                                        <input type="text" form="formRowSop{{ $sop->id }}" name="kode" value="{{ $sop->kode }}" class="w-24 px-2 py-1 rounded border border-slate-200 text-xs font-mono font-bold text-teal-700">
                                    </td>
                                    <td class="py-2.5">
                                        <input type="text" form="formRowSop{{ $sop->id }}" name="judul" value="{{ $sop->judul }}" class="w-full px-2 py-1 rounded border border-slate-200 text-xs font-semibold text-slate-800">
                                        <input type="text" form="formRowSop{{ $sop->id }}" name="keterangan" value="{{ $sop->keterangan }}" placeholder="Keterangan SOP..." class="w-full px-2 py-0.5 mt-1 rounded border border-slate-100 text-[10px] text-slate-500">
                                    </td>
                                    <td class="py-2.5">
                                        <select form="formRowSop{{ $sop->id }}" name="kategori" class="w-full px-1.5 py-1 rounded border border-slate-200 text-[10px] font-semibold">
                                            @foreach(['Peliputan', 'Produksi', 'Penyiaran', 'Penyiaran Khusus', 'Distribusi Digital', 'Kode Etik & Regulasi', 'Manajemen Redaksi'] as $kat)
                                                <option value="{{ $kat }}" {{ $sop->kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="py-2.5 text-center">
                                        <input type="text" form="formRowSop{{ $sop->id }}" name="versi" value="{{ $sop->versi }}" class="w-12 px-1 py-0.5 rounded border border-slate-200 text-[9px] inline">
                                    </td>
                                    <td class="py-2.5 text-center">
                                        <select form="formRowSop{{ $sop->id }}" name="status" class="px-1.5 py-0.5 rounded border border-slate-200 text-[9px] font-bold {{ $sop->status == 'Aktif' ? 'text-emerald-700' : ($sop->status == 'Revisi' ? 'text-amber-700' : 'text-slate-500') }}">
                                            <option value="Aktif" {{ $sop->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Revisi" {{ $sop->status == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                                            <option value="Nonaktif" {{ $sop->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    </td>
                                    <td class="py-2.5 text-center">
                                        <div class="flex items-center justify-center space-x-1">
                                            <button type="submit" form="formRowSop{{ $sop->id }}" class="p-1.5 rounded-lg bg-teal-50 text-teal-700 hover:bg-teal-100 transition-colors" title="Simpan Perubahan">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                            <form action="{{ route('tvri.berita.sop.destroy', $sop->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SOP {{ $sop->kode }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="periode" value="{{ $periode }}">
                                                <button type="submit" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors" title="Hapus SOP">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-8 text-center text-slate-400">Belum ada Dokumen SOP Berita.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== REAL TIME CLOCK & DATE (Jam, Hari, Tanggal, Tahun) =====
    function updateClock() {
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const dayName = days[now.getDay()];
        const dateNum = now.getDate();
        const monthName = months[now.getMonth()];
        const yearNum = now.getFullYear();

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const dayDateEl = document.getElementById('realtimeDayDate');
        const clockEl = document.getElementById('realtimeClock');

        if (dayDateEl) {
            dayDateEl.textContent = `${dayName}, ${dateNum} ${monthName} ${yearNum}`;
        }
        if (clockEl) {
            clockEl.textContent = `${hours}:${minutes}:${seconds} WIT`;
        }
    }
    updateClock();
    setInterval(updateClock, 1000);

    const checkAllSop = document.getElementById('checkAllSop');
    const sopCheckboxes = document.querySelectorAll('.sop-checkbox');
    const btnBulkDeleteSop = document.getElementById('btnBulkDeleteSop');

    function updateBulkBtn() {
        const checkedCount = document.querySelectorAll('.sop-checkbox:checked').length;
        if (btnBulkDeleteSop) {
            if (checkedCount > 0) {
                btnBulkDeleteSop.classList.remove('hidden');
                btnBulkDeleteSop.innerText = `Hapus (${checkedCount}) Terpilih`;
            } else {
                btnBulkDeleteSop.classList.add('hidden');
            }
        }
    }

    if (checkAllSop) {
        checkAllSop.addEventListener('change', function() {
            sopCheckboxes.forEach(cb => cb.checked = checkAllSop.checked);
            updateBulkBtn();
        });
    }

    sopCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkBtn);
    });

    // Kotak Central: Select All & Bulk Delete Berita / File Video
    const checkAllBerita = document.getElementById('checkAllBerita');
    const beritaCheckboxes = document.querySelectorAll('.berita-checkbox');
    const btnBulkDeleteBerita = document.getElementById('btnBulkDeleteBerita');
    const btnBulkDeleteBeritaText = document.getElementById('btnBulkDeleteBeritaText');

    function updateBulkBeritaBtn() {
        const checkedCount = document.querySelectorAll('.berita-checkbox:checked').length;
        if (btnBulkDeleteBerita) {
            if (checkedCount > 0) {
                btnBulkDeleteBerita.classList.remove('hidden');
                if (btnBulkDeleteBeritaText) {
                    btnBulkDeleteBeritaText.innerText = `Hapus (${checkedCount}) File/Berita`;
                }
            } else {
                btnBulkDeleteBerita.classList.add('hidden');
            }
        }
    }

    if (checkAllBerita) {
        checkAllBerita.addEventListener('change', function() {
            beritaCheckboxes.forEach(cb => cb.checked = checkAllBerita.checked);
            updateBulkBeritaBtn();
        });
    }

    beritaCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkBeritaBtn);
    });

    // Helper Generic Setup Bulk
    function setupGenericBulk(checkAllId, itemClass, btnId, btnTextId) {
        const checkAll = document.getElementById(checkAllId);
        const btn = document.getElementById(btnId);
        const btnText = btnTextId ? document.getElementById(btnTextId) : null;

        function updateState() {
            const checkedCount = document.querySelectorAll('.' + itemClass + ':checked').length;
            if (btn) {
                if (checkedCount > 0) {
                    btn.classList.remove('hidden');
                    if (btnText) {
                        btnText.innerText = `Hapus (${checkedCount}) Terpilih`;
                    }
                } else {
                    btn.classList.add('hidden');
                }
            }
        }

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                document.querySelectorAll('.' + itemClass).forEach(cb => cb.checked = checkAll.checked);
                updateState();
            });
        }

        document.querySelectorAll('.' + itemClass).forEach(cb => {
            cb.addEventListener('change', updateState);
        });
    }

    // Kotak Central: Realtime Feeds, Agenda Liputan, Catatan
    setupGenericBulk('checkAllRealtime', 'realtime-checkbox', 'btnBulkDeleteRealtime', 'btnBulkDeleteRealtimeText');
    setupGenericBulk('checkAllAgenda', 'agenda-checkbox', 'btnBulkDeleteAgenda', 'btnBulkDeleteAgendaText');
    setupGenericBulk('checkAllCatatan', 'catatan-checkbox', 'btnBulkDeleteCatatan', 'btnBulkDeleteCatatanText');
});

window.submitBulkDeleteBerita = function() {
    const checked = document.querySelectorAll('.berita-checkbox:checked');
    if (checked.length === 0) return;
    if (confirm(`Apakah Anda yakin ingin menghapus ${checked.length} data berita beserta file video terkait? Tindakan ini tidak dapat dibatalkan.`)) {
        const form = document.getElementById('formBulkDeleteBerita');
        const container = document.getElementById('bulkDeleteBeritaContainer');
        if (container) {
            container.innerHTML = '';
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });
        }
        form.submit();
    }
};

window.submitBulkDeleteRealtime = function() {
    const checked = document.querySelectorAll('.realtime-checkbox:checked');
    if (checked.length === 0) return;
    if (confirm(`Apakah Anda yakin ingin menghapus ${checked.length} feed live newsroom terpilih?`)) {
        const form = document.getElementById('formBulkDeleteRealtime');
        const container = document.getElementById('bulkDeleteRealtimeContainer');
        if (container) {
            container.innerHTML = '';
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });
        }
        form.submit();
    }
};

window.submitBulkDeleteAgenda = function() {
    const checked = document.querySelectorAll('.agenda-checkbox:checked');
    if (checked.length === 0) return;
    if (confirm(`Apakah Anda yakin ingin menghapus ${checked.length} agenda liputan terpilih?`)) {
        const form = document.getElementById('formBulkDeleteAgenda');
        const container = document.getElementById('bulkDeleteAgendaContainer');
        if (container) {
            container.innerHTML = '';
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });
        }
        form.submit();
    }
};

window.submitBulkDeleteCatatan = function() {
    const checked = document.querySelectorAll('.catatan-checkbox:checked');
    if (checked.length === 0) return;
    if (confirm(`Apakah Anda yakin ingin menghapus ${checked.length} catatan / peringatan redaksi terpilih?`)) {
        const form = document.getElementById('formBulkDeleteCatatan');
        const container = document.getElementById('bulkDeleteCatatanContainer');
        if (container) {
            container.innerHTML = '';
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });
        }
        form.submit();
    }
};

function submitBulkDeleteSop() {
    const checked = document.querySelectorAll('.sop-checkbox:checked');
    if (checked.length === 0) return;
    if (confirm(`Apakah Anda yakin ingin menghapus ${checked.length} SOP Berita terpilih?`)) {
        const form = document.getElementById('formBulkDeleteSop');
        const container = document.getElementById('bulkDeleteSopContainer');
        if (container) {
            container.innerHTML = '';
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                container.appendChild(input);
            });
        }
        form.submit();
    }
}
</script>
@endsection
