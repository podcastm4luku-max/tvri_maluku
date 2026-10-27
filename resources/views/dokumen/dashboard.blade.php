@extends('layouts.app')

@section('title', 'Dashboard Dokumen & Arsip Digital - TVRI Maluku')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-between text-emerald-800 text-xs font-bold shadow-sm">
            <div class="flex items-center space-x-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
            <span class="text-[11px] text-emerald-600 font-mono">Tersinkronisasi Real-Time</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center justify-between text-rose-800 text-xs font-bold shadow-sm">
            <div class="flex items-center space-x-2.5">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
            <span class="text-[11px] text-rose-600 font-mono">Perhatian</span>
        </div>
    @endif

    <!-- Header & Welcome Banner -->
    <div class="bg-gradient-to-r from-[#00264A] via-[#003B70] to-[#005B9F] rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-3 py-1 bg-rose-500/20 text-rose-300 border border-rose-500/40 rounded-full text-xs font-bold tracking-wider uppercase">
                        Tahap 5 • Document Management System (DMS)
                    </span>
                    <span class="text-xs text-blue-200">Satu Data Terintegrasi</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black tracking-tight text-white">
                    Pusat Dokumen & Arsip Digital Terpadu
                </h1>
                <p class="text-sm text-blue-100 max-w-2xl mt-1">
                    Repositori naskah dinas, SK, regulasi hukum, kajian cagar budaya, dan data pokok terverifikasi dengan QR Code & Versioning System.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('dokumen.documents.create') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-lg hover:shadow-emerald-600/30 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Unggah Dokumen</span>
                </a>
                <a href="{{ route('dokumen.folders.index') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-xl border border-white/20 backdrop-blur-md transition-all duration-200">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    <span>Folder Explorer</span>
                </a>
                <a href="{{ route('dokumen.documents.index') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white text-xs font-bold rounded-xl border border-white/20 backdrop-blur-md transition-all duration-200">
                    <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    <span>Daftar Dokumen</span>
                </a>
                <a href="#sop" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-teal-500/20 hover:bg-teal-500/30 text-teal-200 text-xs font-bold rounded-xl border border-teal-400/30 backdrop-blur-md transition-all duration-200">
                    <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Dokumen SOP ({{ count($sops) }})</span>
                </a>
            </div>
        </div>

        <!-- Global Filter Bar -->
        <form method="GET" action="{{ route('dokumen.dashboard') }}" class="mt-6 pt-5 border-t border-white/15 grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-blue-200 mb-1">Filter Tahun</label>
                <select name="year" onchange="this.form.submit()" class="w-full bg-[#001D38]/80 text-white text-xs rounded-xl border border-blue-400/30 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Semua Tahun (Histori Lengkap)</option>
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ $yearFilter == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-blue-200 mb-1">Filter Bidang / Unit Kerja</label>
                <select name="division" onchange="this.form.submit()" class="w-full bg-[#001D38]/80 text-white text-xs rounded-xl border border-blue-400/30 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Semua Bidang & Sekretariat</option>
                    @foreach($availableDivisions as $div)
                        <option value="{{ $div }}" {{ $divisionFilter == $div ? 'selected' : '' }}>{{ $div }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <a href="{{ route('dokumen.dashboard') }}" class="w-full text-center px-3 py-2 bg-blue-900/40 hover:bg-blue-900/70 border border-blue-400/30 text-xs font-semibold rounded-xl text-blue-200 transition-colors">
                    Reset Filter
                </a>
            </div>
        </form>
    </div>

    @if(auth()->user() && (auth()->user()->hasRole('ADMIN') || auth()->user()->hasRole('Super Admin') || in_array(auth()->user()->username, ['admin', 'superadmin'])))
    <!-- Panel Khusus Super Admin: Pengaturan & Sinkronisasi Database Statistik Pengunjung TVRI Maluku Digital Hub -->
    <div x-data="{ openForm: true }" class="bg-gradient-to-br from-slate-900 via-[#001D38] to-[#00264A] rounded-2xl p-6 text-white shadow-xl border border-blue-500/30 relative overflow-hidden">
        <div class="absolute -right-12 -top-12 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-5 border-b border-white/10">
                <div class="flex items-start sm:items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-amber-400/20 border border-amber-400/40 text-amber-300 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/40">
                                Super Admin Control
                            </span>
                            <span class="text-[11px] text-emerald-400 flex items-center gap-1 font-semibold">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                Live Real-Time Sync
                            </span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-black text-white mt-0.5">
                            Kelola Database Statistik Pengunjung TVRI Maluku Digital Hub
                        </h2>
                        <p class="text-xs text-blue-200/90 mt-0.5">
                            Pembaruan data pada panel ini tersimpan langsung di database dan otomatis memperbarui tampilan kartu statistik footer di portal publik secara real-time.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-600/30 hover:bg-blue-600/50 border border-blue-400/30 rounded-xl text-xs font-bold text-blue-200 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Lihat Portal Publik</span>
                    </a>
                    <button type="button" @click="openForm = !openForm" class="px-3 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-xs font-bold text-white transition-colors">
                        <span x-text="openForm ? 'Sembunyikan Form' : 'Buka Form Edit'"></span>
                    </button>
                </div>
            </div>

            <!-- Current Real-Time Metrics Display -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 my-5">
                <!-- Hari Ini -->
                <div class="bg-black/40 backdrop-blur-md rounded-xl p-4 border border-white/10">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-blue-300">Hari Ini</span>
                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-blue-500/20 text-blue-200 border border-blue-400/30">Harian</span>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            <div class="text-2xl sm:text-3xl font-black text-white font-mono leading-none">
                                {{ number_format($visitorStat->hari_ini_kunjungan, 0, '.', ',') }}
                            </div>
                            <div class="text-[10px] text-blue-200/70 mt-1">Total Kunjungan</div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg sm:text-xl font-bold text-amber-300 font-mono leading-none">
                                {{ number_format($visitorStat->hari_ini_unik, 0, '.', ',') }}
                            </div>
                            <div class="text-[10px] text-amber-200/70 mt-1">Pengunjung Unik</div>
                        </div>
                    </div>
                </div>

                <!-- Bulan Ini -->
                <div class="bg-black/40 backdrop-blur-md rounded-xl p-4 border border-white/10">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-300">Bulan Ini</span>
                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-500/20 text-emerald-200 border border-emerald-400/30">Bulanan</span>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            <div class="text-2xl sm:text-3xl font-black text-white font-mono leading-none">
                                {{ number_format($visitorStat->bulan_ini_kunjungan, 0, '.', ',') }}
                            </div>
                            <div class="text-[10px] text-blue-200/70 mt-1">Total Kunjungan</div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg sm:text-xl font-bold text-amber-300 font-mono leading-none">
                                {{ number_format($visitorStat->bulan_ini_unik, 0, '.', ',') }}
                            </div>
                            <div class="text-[10px] text-amber-200/70 mt-1">Pengunjung Unik</div>
                        </div>
                    </div>
                </div>

                <!-- Total Kunjungan -->
                <div class="bg-black/40 backdrop-blur-md rounded-xl p-4 border border-white/10">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-purple-300">Total Akumulasi</span>
                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-purple-500/20 text-purple-200 border border-purple-400/30">Sepanjang Waktu</span>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <div>
                            <div class="text-2xl sm:text-3xl font-black text-white font-mono leading-none">
                                {{ number_format($visitorStat->total_kunjungan, 0, '.', ',') }}
                            </div>
                            <div class="text-[10px] text-blue-200/70 mt-1">Total Kunjungan</div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg sm:text-xl font-bold text-amber-300 font-mono leading-none">
                                {{ number_format($visitorStat->total_unik, 0, '.', ',') }}
                            </div>
                            <div class="text-[10px] text-amber-200/70 mt-1">Pengunjung Unik</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Edit & Update Database -->
            <form x-show="openForm" action="{{ route('dokumen.visitor-stats.update') }}" method="POST" class="pt-4 border-t border-white/10">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Hari Ini Kunjungan & Unik -->
                    <div class="bg-white/5 rounded-xl p-3.5 border border-white/10 space-y-2.5">
                        <div class="text-xs font-bold text-blue-200 flex items-center justify-between">
                            <span>Statistik Hari Ini</span>
                            <span class="text-[10px] text-slate-400 font-mono">Patokan: 248 / 236</span>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <label class="block text-[11px] text-slate-300 mb-1">Total Kunjungan Hari Ini</label>
                                <input type="number" name="hari_ini_kunjungan" value="{{ $visitorStat->hari_ini_kunjungan }}" required min="0"
                                       class="w-full bg-[#001428] text-white font-mono text-sm px-3 py-2 rounded-lg border border-blue-400/30 focus:border-amber-400 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] text-slate-300 mb-1">Pengunjung Unik Hari Ini</label>
                                <input type="number" name="hari_ini_unik" value="{{ $visitorStat->hari_ini_unik }}" required min="0"
                                       class="w-full bg-[#001428] text-white font-mono text-sm px-3 py-2 rounded-lg border border-blue-400/30 focus:border-amber-400 focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Bulan Ini Kunjungan & Unik -->
                    <div class="bg-white/5 rounded-xl p-3.5 border border-white/10 space-y-2.5">
                        <div class="text-xs font-bold text-emerald-200 flex items-center justify-between">
                            <span>Statistik Bulan Ini</span>
                            <span class="text-[10px] text-slate-400 font-mono">Patokan: 5,420 / 4,890</span>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <label class="block text-[11px] text-slate-300 mb-1">Total Kunjungan Bulan Ini</label>
                                <input type="number" name="bulan_ini_kunjungan" value="{{ $visitorStat->bulan_ini_kunjungan }}" required min="0"
                                       class="w-full bg-[#001428] text-white font-mono text-sm px-3 py-2 rounded-lg border border-blue-400/30 focus:border-amber-400 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] text-slate-300 mb-1">Pengunjung Unik Bulan Ini</label>
                                <input type="number" name="bulan_ini_unik" value="{{ $visitorStat->bulan_ini_unik }}" required min="0"
                                       class="w-full bg-[#001428] text-white font-mono text-sm px-3 py-2 rounded-lg border border-blue-400/30 focus:border-amber-400 focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Total Kunjungan & Unik -->
                    <div class="bg-white/5 rounded-xl p-3.5 border border-white/10 space-y-2.5">
                        <div class="text-xs font-bold text-purple-200 flex items-center justify-between">
                            <span>Total Akumulasi</span>
                            <span class="text-[10px] text-slate-400 font-mono">Patokan: 168,940 / 142,300</span>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <label class="block text-[11px] text-slate-300 mb-1">Total Seluruh Kunjungan</label>
                                <input type="number" name="total_kunjungan" value="{{ $visitorStat->total_kunjungan }}" required min="0"
                                       class="w-full bg-[#001428] text-white font-mono text-sm px-3 py-2 rounded-lg border border-blue-400/30 focus:border-amber-400 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] text-slate-300 mb-1">Total Seluruh Pengunjung Unik</label>
                                <input type="number" name="total_unik" value="{{ $visitorStat->total_unik }}" required min="0"
                                       class="w-full bg-[#001428] text-white font-mono text-sm px-3 py-2 rounded-lg border border-blue-400/30 focus:border-amber-400 focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 mt-4 border-t border-white/10">
                    <div class="text-[11px] text-slate-300">
                        <span>Pembaruan terakhir: <strong class="text-amber-300">{{ $visitorStat->updated_at ? $visitorStat->updated_at->format('d/m/Y H:i:s') : 'Baru saja' }}</strong></span>
                        @if($visitorStat->updated_by)
                            <span class="ml-2">• Oleh: <strong class="text-blue-300">{{ $visitorStat->updated_by }}</strong></span>
                        @endif
                    </div>
                    <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-black rounded-xl shadow-lg hover:shadow-emerald-600/30 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Quick Action: Hapus Data / Reset ke 0 & Kembalikan Patokan -->
            <div class="pt-4 mt-4 border-t border-white/10 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2 text-slate-300 text-[11px]">
                    <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Aksi Cepat Super Admin: Kosongkan untuk memulai hitungan dari 0 atau kembalikan ke patokan awal.</span>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <form action="{{ route('dokumen.visitor-stats.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan / mereset semua data pengunjung ke 0? Real-time tracker akan mulai menghitung kunjungan baru yang masuk.');">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-600/30 hover:bg-rose-600/60 border border-rose-500/40 text-rose-200 hover:text-white rounded-lg text-xs font-bold transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>Hapus / Kosongkan Data (Mulai dari 0)</span>
                        </button>
                    </form>

                    <form action="{{ route('dokumen.visitor-stats.patokan') }}" method="POST" onsubmit="return confirm('Kembalikan ke data patokan TVRI Maluku (248 kunjungan hari ini / 5,420 bulan ini / 168,940 total)?');">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-500/20 hover:bg-amber-500/40 border border-amber-400/30 text-amber-200 hover:text-white rounded-lg text-xs font-bold transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span>Terapkan Patokan TVRI</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Master Database: Katalog Data Operasional TVRI Maluku -->
    <div x-data="katalogManager()" class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5 pb-4 border-b border-slate-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h2 class="text-base font-black text-[#00264A]">Katalog Data Operasional TVRI Maluku</h2>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 font-mono">
                            {{ count($katalogDatasets) }} Dataset Terverifikasi
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Database master dataset operasional LPP TVRI Stasiun Maluku yang disajikan pada portal publik terintegrasi.
                    </p>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button type="button" 
                        @click="openCreateModal()"
                        class="inline-flex items-center space-x-1.5 px-3.5 py-2 bg-[#00264A] hover:bg-[#003B70] text-white text-xs font-bold rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Dataset</span>
                </button>
                <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center space-x-1.5 px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-[#003B70] text-xs font-bold rounded-xl transition border border-blue-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Buka Katalog di Portal Publik</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-[11px] font-extrabold uppercase text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3.5 rounded-l-xl">Dataset & Topik Operasional</th>
                        <th class="py-3 px-3.5">Bidang / Urusan</th>
                        <th class="py-3 px-3.5 text-center">Baris Data</th>
                        <th class="py-3 px-3.5 text-center">Dilihat</th>
                        <th class="py-3 px-3.5 text-center">Diunduh</th>
                        <th class="py-3 px-3.5">Tanggal Update</th>
                        <th class="py-3 px-3.5 text-center">Status Database</th>
                        <th class="py-3 px-3.5 rounded-r-xl text-center">Aksi / Input Data</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($katalogDatasets as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-3.5">
                                <div class="font-bold text-[#00264A] text-xs">{{ $item->title }}</div>
                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">slug: {{ $item->slug }}</div>
                                @if(!empty($item->tags))
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach($item->tags as $t)
                                            <span class="px-1.5 py-0.5 text-[9px] font-mono bg-slate-100 text-slate-600 rounded">#{{ $t }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-3.5">
                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $item->urusan?->name ?? 'Lembaga Penyiaran Publik' }}
                                </span>
                            </td>
                            <td class="py-3 px-3.5 text-center font-mono font-bold text-slate-700">
                                {{ is_array($item->rows) ? count($item->rows) : 0 }} baris
                            </td>
                            <td class="py-3 px-3.5 text-center font-mono text-emerald-600 font-bold">
                                {{ number_format($item->views, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3.5 text-center font-mono text-blue-600 font-bold">
                                {{ number_format($item->downloads, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3.5 text-slate-500 whitespace-nowrap text-[11px]">
                                {{ $item->date }}
                            </td>
                            <td class="py-3 px-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span>
                                    Aktif di Portal
                                </span>
                            </td>
                            <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button type="button" 
                                            @click="openEditModal({{ json_encode($item) }})"
                                            class="inline-flex items-center space-x-1 px-2.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-[11px] font-bold shadow-sm transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        <span>Edit & Ganti File</span>
                                    </button>
                                    <a href="{{ route('dokumen.katalog.export-csv', $item->id) }}" 
                                       title="Unduh File CSV Data"
                                       class="inline-flex items-center p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition border border-slate-200">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                    <form action="{{ route('dokumen.katalog.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dataset \'{{ addslashes($item->title) }}\' dari katalog operasional?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                title="Hapus Dataset"
                                                class="inline-flex items-center p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-lg text-xs font-semibold transition border border-rose-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-6 text-center text-slate-400">
                                Data katalog operasional belum tersedia. Jalankan Seeder Dataset untuk mengisinya.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ==================== MODAL KOTAK INPUT DATA & GANTI FILE DATASET ==================== -->
        <div x-show="inputModal" 
             x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             @keydown.escape.window="inputModal = false">
            <div class="relative w-full max-w-2xl bg-white rounded-3xl p-6 sm:p-7 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto"
                 @click.away="inputModal = false">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#00264A] flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-[#00264A]" x-text="isEdit ? 'Kotak Edit Dataset & Ganti File Operasional' : 'Kotak Input Dataset Operasional Baru'"></h3>
                            <p class="text-xs text-slate-500">Perbarui informasi dataset dan unggah file baru untuk ditampilkan pada portal publik.</p>
                        </div>
                    </div>
                    <button @click="inputModal = false" class="text-slate-400 hover:text-slate-600 text-2xl font-bold leading-none">&times;</button>
                </div>

                <!-- Form Input & Upload File -->
                <form :action="formAction" method="POST" enctype="multipart/form-data" class="space-y-4 pt-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Judul Dataset -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Judul Dataset & Topik Operasional <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" x-model="formData.title" required 
                                   placeholder="Contoh: Jumlah Satuan Pendidikan (SMA, SMK, SLB) menurut Kabupaten/Kota di Provinsi Maluku"
                                   class="w-full text-xs font-semibold px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Bidang / Urusan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Bidang / Urusan <span class="text-rose-500">*</span></label>
                            <select name="urusan_id" x-model="formData.urusan_id" required 
                                    class="w-full text-xs font-semibold px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                @foreach($urusans as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Update -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Update <span class="text-rose-500">*</span></label>
                            <input type="text" name="date" x-model="formData.date" required
                                   placeholder="Contoh: 28 Maret 2026"
                                   class="w-full text-xs font-semibold px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Tags / Kata Kunci -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tags / Kata Kunci Topik (Pisahkan dengan koma)</label>
                            <input type="text" name="tags" x-model="formData.tags" 
                                   placeholder="Contoh: dapodik, sekolah, sma-smk, slb"
                                   class="w-full text-xs font-semibold px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                            <span class="text-[10px] text-slate-400 mt-1 block">Tag ini digunakan sebagai filter topik pencarian di Halaman Utama Portal Publik.</span>
                        </div>

                        <!-- Statistik Dilihat & Diunduh -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Dilihat (Views)</label>
                            <input type="number" name="views" x-model="formData.views" min="0"
                                   class="w-full text-xs font-semibold px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Diunduh (Downloads)</label>
                            <input type="number" name="downloads" x-model="formData.downloads" min="0"
                                   class="w-full text-xs font-semibold px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                        </div>

                        <!-- Deskripsi Lengkap -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Lengkap Dataset <span class="text-rose-500">*</span></label>
                            <textarea name="description" x-model="formData.description" rows="3" required
                                      placeholder="Penjelasan ringkas mengenai cakupan data operasional..."
                                      class="w-full text-xs font-semibold px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                    </div>

                    <!-- Kotak Unggah / Ganti File Data -->
                    <div class="p-4 bg-blue-50/70 border border-blue-200/90 rounded-2xl space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-black text-[#00264A] flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <span>Ganti File Data Yang Tampil di Portal Publik</span>
                            </label>
                            <template x-if="isEdit && formData.id">
                                <a :href="'{{ url('/dokumen/katalog') }}/' + formData.id + '/export-csv'" 
                                   class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-700 hover:text-blue-900 bg-white px-2.5 py-1 rounded-lg border border-blue-200 shadow-xs">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <span>Unduh CSV Saat Ini</span>
                                </a>
                            </template>
                        </div>
                        
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            Unggah file baru berformat <strong>.CSV</strong>, <strong>.XLSX / .XLS (Excel)</strong>, atau <strong>.JSON</strong> untuk langsung mengganti baris dan kolom data yang disajikan pada halaman utama portal publik.
                        </p>

                        <div class="bg-white p-3 rounded-xl border border-slate-200">
                            <input type="file" name="dataset_file" accept=".csv,.xlsx,.xls,.json,.txt"
                                   class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#00264A] file:text-white hover:file:bg-[#003B70] cursor-pointer">
                        </div>

                        <template x-if="isEdit">
                            <div class="space-y-2">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 text-[11px] text-slate-500 bg-white/70 px-3 py-2 rounded-xl border border-slate-200/60 font-mono">
                                    <span>Status data saat ini:</span>
                                    <span class="font-bold text-[#00264A]" x-text="formData.deleteFileData ? 'File data ditandai untuk dihapus' : (formData.rowCount + ' baris data • ' + formData.columnCount + ' kolom (' + formData.columnsList + ')')"></span>
                                </div>
                                <div class="p-2.5 bg-rose-50/70 border border-rose-200 rounded-xl flex items-center justify-between">
                                    <label class="flex items-center space-x-2 cursor-pointer select-none">
                                        <input type="checkbox" name="delete_file_data" value="1" x-model="formData.deleteFileData" class="rounded text-rose-600 focus:ring-rose-500 w-4 h-4 cursor-pointer">
                                        <span class="text-xs font-bold text-rose-800">Hapus file data saat ini (kosongkan data untuk input / upload ulang)</span>
                                    </label>
                                    <template x-if="formData.deleteFileData">
                                        <span class="text-[10px] font-bold text-rose-600 bg-rose-100 px-2 py-0.5 rounded-full">File akan dihapus</span>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Pilihan Input / Paste Data Raw JSON -->
                        <div x-data="{ showRaw: false }" class="pt-1">
                            <button type="button" @click="showRaw = !showRaw" class="text-[11px] font-bold text-blue-700 hover:underline flex items-center gap-1">
                                <span x-text="showRaw ? '▼ Sembunyikan Editor Baris Data JSON' : '▶ Atau Edit / Paste Langsung Format JSON'"></span>
                            </button>
                            <div x-show="showRaw" x-cloak class="mt-2 space-y-1">
                                <textarea name="raw_data_json" x-model="formData.rawJson" rows="4" 
                                          placeholder='Format array data objek: [{"Kolom 1": "Isi", "Kolom 2": "Nilai"}]'
                                          class="w-full text-[11px] font-mono px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-slate-700"></textarea>
                                <span class="text-[10px] text-slate-400 block">Isi ini akan digunakan jika tidak mengunggah file baru di atas.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                        <div>
                            <template x-if="isEdit && formData.id">
                                <button type="button" 
                                        @click="deleteCurrentDataset()"
                                        class="px-3.5 py-2.5 rounded-xl text-xs font-bold bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 transition flex items-center space-x-1.5"
                                        title="Hapus Dataset ini">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    <span>Hapus Dataset</span>
                                </button>
                            </template>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" @click="inputModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-black bg-[#00264A] hover:bg-[#003B70] text-white shadow-md transition flex items-center space-x-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span x-text="isEdit ? 'Simpan & Terapkan Perubahan ke Portal' : 'Simpan & Terbitkan Dataset'"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function katalogManager() {
        return {
            inputModal: false,
            isEdit: false,
            formAction: '',
            formData: {
                id: null,
                title: '',
                slug: '',
                urusan_id: 1,
                date: '',
                tags: '',
                views: 0,
                downloads: 0,
                description: '',
                rowCount: 0,
                columnCount: 0,
                columnsList: '',
                rawJson: '',
                deleteFileData: false,
            },
            openEditModal(item) {
                this.isEdit = true;
                this.formAction = '{{ url("/dokumen/katalog") }}/' + item.id + '/update';
                this.formData.id = item.id;
                this.formData.title = item.title || '';
                this.formData.slug = item.slug || '';
                this.formData.urusan_id = item.urusan_id || 1;
                this.formData.date = item.date || '';
                this.formData.tags = Array.isArray(item.tags) ? item.tags.join(', ') : '';
                this.formData.views = item.views || 0;
                this.formData.downloads = item.downloads || 0;
                this.formData.description = item.description || '';
                this.formData.rowCount = Array.isArray(item.rows) ? item.rows.length : 0;
                this.formData.columnCount = Array.isArray(item.columns) ? item.columns.length : 0;
                this.formData.columnsList = Array.isArray(item.columns) ? item.columns.slice(0, 3).join(', ') + (item.columns.length > 3 ? '...' : '') : '-';
                this.formData.rawJson = Array.isArray(item.rows) ? JSON.stringify(item.rows, null, 2) : '';
                this.formData.deleteFileData = false;
                this.inputModal = true;
            },
            openCreateModal() {
                this.isEdit = false;
                this.formAction = '{{ route("dokumen.katalog.store") }}';
                this.formData.id = null;
                this.formData.title = '';
                this.formData.slug = '';
                this.formData.urusan_id = 1;
                this.formData.date = '{{ date("d F Y") }}';
                this.formData.tags = '';
                this.formData.views = 0;
                this.formData.downloads = 0;
                this.formData.description = '';
                this.formData.rowCount = 0;
                this.formData.columnCount = 0;
                this.formData.columnsList = '';
                this.formData.rawJson = '';
                this.formData.deleteFileData = false;
                this.inputModal = true;
            },
            deleteCurrentDataset() {
                if (confirm('Apakah Anda yakin ingin menghapus dataset "' + this.formData.title + '" ini dari sistem dan portal publik?')) {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ url("/dokumen/katalog") }}/' + this.formData.id;
                    
                    let csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    let method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            }
        };
    }
    </script>


    @endif

    <!-- 6 Executive Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- Card 1: Total Dokumen -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Dokumen</span>
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <div>
                <p class="text-2xl font-black text-[#00264A]">{{ number_format($totalDocuments, 0, ',', '.') }}</p>
                <p class="text-[10px] text-emerald-600 font-semibold mt-0.5">Tersimpan di Database</p>
            </div>
        </div>

        <!-- Card 2: Total Folder -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Folder Kategori</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                </div>
            </div>
            <div>
                <p class="text-2xl font-black text-amber-700">{{ number_format($totalFolders, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-500 font-semibold mt-0.5">Struktur Hierarki</p>
            </div>
        </div>

        <!-- Card 3: Dokumen Publik -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Akses Publik</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div>
                <p class="text-2xl font-black text-emerald-600">{{ number_format($publicDocuments, 0, ',', '.') }}</p>
                <p class="text-[10px] text-emerald-600 font-semibold mt-0.5">Dapat Diakses Umum</p>
            </div>
        </div>

        <!-- Card 4: Dokumen Rahasia / Terbatas -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Rahasia/Terbatas</span>
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
            <div>
                <p class="text-2xl font-black text-rose-600">{{ number_format($confidentialDocuments, 0, ',', '.') }}</p>
                <p class="text-[10px] text-rose-500 font-semibold mt-0.5">Proteksi Khusus</p>
            </div>
        </div>

        <!-- Card 5: Versi Tersimpan -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Histori Versi</span>
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div>
                <p class="text-2xl font-black text-purple-700">{{ number_format($totalVersions, 0, ',', '.') }}</p>
                <p class="text-[10px] text-purple-600 font-semibold mt-0.5">Arsip Revisi Lengkap</p>
            </div>
        </div>

        <!-- Card 6: Total Unduhan -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Unduhan</span>
                <div class="w-8 h-8 rounded-xl bg-cyan-50 text-cyan-700 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                </div>
            </div>
            <div>
                <p class="text-2xl font-black text-cyan-700">{{ number_format($totalDownloads, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-500 font-semibold mt-0.5">{{ number_format($totalViews, 0, ',', '.') }} Dilihat</p>
            </div>
        </div>
    </div>



    <!-- Visualisasi Grafik Chart.js (3 Kolom) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Chart 1: Distribusi Dokumen per Bidang / Bagian -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-[#00264A]">Distribusi Dokumen per Bidang</h3>
                    <p class="text-xs text-slate-500">Jumlah arsip menurut unit kerja</p>
                </div>
                <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-100 text-blue-700 rounded-lg">Bidang</span>
            </div>
            <div class="relative flex-1 min-h-[260px] flex items-center justify-center">
                <canvas id="divisionChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Proporsi Format Berkas (PDF, DOCX, XLSX, dll) -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-[#00264A]">Komposisi Format Berkas</h3>
                    <p class="text-xs text-slate-500">PDF, Word, Excel, PPTX & Multimedia</p>
                </div>
                <span class="px-2 py-0.5 text-[10px] font-bold bg-purple-100 text-purple-700 rounded-lg">Format</span>
            </div>
            <div class="relative flex-1 min-h-[260px] flex items-center justify-center">
                <canvas id="formatChart"></canvas>
            </div>
        </div>

        <!-- Chart 3: Tingkat Kerahasiaan & Akses Dokumen -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-[#00264A]">Tingkat Kerahasiaan</h3>
                    <p class="text-xs text-slate-500">Publik, Internal, Terbatas, Rahasia</p>
                </div>
                <span class="px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-700 rounded-lg">Security</span>
            </div>
            <div class="relative flex-1 min-h-[260px] flex items-center justify-center">
                <canvas id="confChart"></canvas>
            </div>
        </div>
    </div>



    <!-- 2 Kolom: Dokumen Terbaru & Log Aktivitas Kearsipan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Dokumen Terbaru -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-[#00264A]">Dokumen & SK Terbaru</h3>
                        <p class="text-xs text-slate-500">Naskah yang baru saja diunggah ke repositori</p>
                    </div>
                </div>
                <a href="{{ route('dokumen.documents.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">Lihat Semua →</a>
            </div>

            <div class="space-y-3">
                @forelse($recentDocuments as $doc)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-blue-50/50 border border-slate-100 transition-colors">
                        <div class="flex items-center space-x-3 min-w-0">
                            <span class="px-2 py-1 text-[10px] font-black rounded-lg border {{ $doc->format_badge_color }}">
                                {{ $doc->file_type }}
                            </span>
                            <div class="min-w-0">
                                <a href="{{ route('dokumen.documents.show', $doc->id) }}" class="text-xs font-bold text-slate-800 hover:text-blue-700 truncate block">
                                    {{ $doc->title }}
                                </a>
                                <p class="text-[11px] text-slate-500 flex items-center space-x-2 mt-0.5">
                                    <span>{{ $doc->document_number ?: 'Tanpa No. SK' }}</span>
                                    <span>•</span>
                                    <span>{{ $doc->division }}</span>
                                    <span>•</span>
                                    <span class="font-semibold text-blue-600">{{ $doc->current_version }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 flex-shrink-0 ml-3">
                            <a href="{{ route('dokumen.documents.show', $doc->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Lihat Detail & QR">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('dokumen.documents.download', $doc->id) }}" class="p-1.5 text-emerald-600 hover:bg-emerald-100 rounded-lg transition-colors" title="Unduh">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </a>
                            <form action="{{ route('dokumen.documents.destroy', $doc->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini dari sistem?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-100 rounded-lg transition-colors" title="Hapus Dokumen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">Belum ada dokumen yang diunggah.</p>
                @endforelse
            </div>
        </div>

        <!-- Log Aktivitas Audit Kearsipan -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-[#00264A]">Audit Trail Aktivitas Kearsipan</h3>
                        <p class="text-xs text-slate-500">Pencatatan real-time aksi upload, revisi & download</p>
                    </div>
                </div>
                @if(auth()->user()->hasRole('ADMIN'))
                    <a href="{{ route('admin.activity-logs.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-800">Semua Log →</a>
                @endif
            </div>

            <div class="space-y-3">
                @forelse($recentLogs as $log)
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ str_contains($log->action, 'UPLOAD') ? 'bg-emerald-100 text-emerald-800' : (str_contains($log->action, 'DOWNLOAD') ? 'bg-cyan-100 text-cyan-800' : 'bg-purple-100 text-purple-800') }}">
                                {{ $log->action }}
                            </span>
                            <span class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs font-medium text-slate-800">{{ $log->description }}</p>
                        <p class="text-[10px] text-slate-500 mt-1">Oleh: <span class="font-semibold text-slate-700">{{ $log->user ? $log->user->name : 'Sistem' }}</span></p>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-6">Belum ada aktivitas audit kearsipan.</p>
                @endforelse
            </div>
        </div>
    </div>



    <!-- STANDAR OPERASIONAL PROSEDUR (SOP) TVRI MALUKU - FITUR KEARSIPAN INTERAKTIF -->
    <div id="sop" 
         x-data="{
             sopSearch: '',
             selectedCategory: 'Semua',
             sopDetailModal: false,
             selectedSop: {},
             createSopModal: false,
             sops: {{ json_encode($sops) }},
             get filteredSops() {
                 return this.sops.filter(s => {
                     const matchCat = this.selectedCategory === 'Semua' || s.kategori === this.selectedCategory;
                     const query = (this.sopSearch || '').toLowerCase().trim();
                     if (!query) return matchCat;
                     const kode = (s.kode || '').toLowerCase();
                     const judul = (s.judul || '').toLowerCase();
                     const kat = (s.kategori || '').toLowerCase();
                     const suara = (s.suara_siaran || '').toLowerCase();
                     const ket = (s.keterangan || '').toLowerCase();
                     return matchCat && (kode.includes(query) || judul.includes(query) || kat.includes(query) || suara.includes(query) || ket.includes(query));
                 });
             },
             openDetail(sop) {
                 this.selectedSop = sop;
                 this.sopDetailModal = true;
             }
         }" 
         class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm space-y-5">
        
        <!-- Header Fitur SOP -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-base font-black text-[#00264A]">STANDAR OPERASIONAL PROSEDUR (SOP) TVRI MALUKU</h2>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-teal-50 text-teal-700 border border-teal-200 uppercase">Resmi LPP TVRI</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Pusat repositori mutu penyiaran, kepatuhan on-air, tata kelola studio, standar audio siaran & quality control</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" 
                        @click="createSopModal = true"
                        class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white shadow-sm transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Dokumen SOP</span>
                </button>
                <a href="{{ route('tvri.program.manage', ['tab' => 'sop']) }}" 
                   class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Kelola di Menu Program</span>
                </a>
            </div>
        </div>

        <!-- Mini KPI Bar Fitur SOP -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="p-3 bg-teal-50/70 border border-teal-100 rounded-xl">
                <span class="text-[10px] font-bold text-teal-700 uppercase tracking-wider block">Total SOP Aktif</span>
                <p class="text-xl font-black text-teal-800 mt-0.5">{{ $sops->where('status', 'Aktif')->count() }} Dokumen</p>
            </div>
            <div class="p-3 bg-blue-50/70 border border-blue-100 rounded-xl">
                <span class="text-[10px] font-bold text-blue-700 uppercase tracking-wider block">Pra & Produksi Studio</span>
                <p class="text-xl font-black text-blue-800 mt-0.5">{{ $sops->whereIn('kategori', ['Pra Produksi', 'Produksi'])->count() }} Prosedur</p>
            </div>
            <div class="p-3 bg-purple-50/70 border border-purple-100 rounded-xl">
                <span class="text-[10px] font-bold text-purple-700 uppercase tracking-wider block">Pasca & Quality Control</span>
                <p class="text-xl font-black text-purple-800 mt-0.5">{{ $sops->whereIn('kategori', ['Pasca Produksi', 'Quality Control'])->count() }} Prosedur</p>
            </div>
            <div class="p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl">
                <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">Penayangan & Evaluasi</span>
                <p class="text-xl font-black text-emerald-800 mt-0.5">{{ $sops->whereIn('kategori', ['Penayangan', 'Monitoring', 'Evaluasi'])->count() }} Prosedur</p>
            </div>
        </div>

        <!-- Filter Interaktif & Pencarian Real-Time SOP -->
        <div class="space-y-3 pt-1">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="relative flex-1">
                    <input type="text" 
                           x-model="sopSearch" 
                           placeholder="Cari kode SOP (misal: SOP-PRG-001), judul, standar suara siaran, atau kata kunci..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-600">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-slate-500 flex-shrink-0">
                    <span>Ditemukan:</span>
                    <span class="font-bold text-[#00264A] font-mono px-2 py-0.5 bg-slate-100 rounded-md" x-text="filteredSops.length + ' SOP'"></span>
                </div>
            </div>

            <!-- Category Pills Filter -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-xs">
                @php
                    $kategoriFilterList = ['Semua', 'Pra Produksi', 'Produksi', 'Pasca Produksi', 'Quality Control', 'Penayangan', 'Monitoring', 'Evaluasi'];
                @endphp
                @foreach($kategoriFilterList as $kf)
                    <button type="button" 
                            @click="selectedCategory = '{{ $kf }}'"
                            :class="selectedCategory === '{{ $kf }}' ? 'bg-[#00264A] text-white font-bold shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="px-3 py-1.5 rounded-lg whitespace-nowrap transition-colors text-[11px]">
                        {{ $kf }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Grid Kartu SOP Interaktif -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-1">
            <template x-for="sop in filteredSops" :key="sop.id">
                <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/70 hover:bg-teal-50/40 hover:border-teal-200 transition-all flex flex-col justify-between group cursor-pointer"
                     @click="openDetail(sop)">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-mono text-[10px] font-black text-teal-700 bg-teal-100/70 px-2 py-0.5 rounded-md" x-text="sop.kode"></span>
                            <span class="text-[10px] font-bold text-slate-400" x-text="sop.revisi || 'Rev. 01 / 2025'"></span>
                        </div>
                        <h4 class="text-xs font-black text-[#00264A] leading-snug line-clamp-2 group-hover:text-teal-800 transition-colors" x-text="sop.judul"></h4>
                        
                        <!-- Standar Suara Siaran Badge -->
                        <template x-if="sop.suara_siaran">
                            <div class="mt-2 flex items-center space-x-1 text-[10px] text-cyan-800 bg-cyan-50 px-2 py-0.5 rounded-md border border-cyan-100">
                                <svg class="w-3 h-3 text-cyan-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                                <span class="truncate font-semibold" x-text="sop.suara_siaran"></span>
                            </div>
                        </template>

                        <template x-if="sop.keterangan">
                            <p class="text-[11px] text-slate-500 font-medium mt-1.5 line-clamp-2 leading-relaxed" x-text="sop.keterangan"></p>
                        </template>
                    </div>

                    <div class="flex items-center justify-between pt-3 mt-3 border-t border-slate-200/60">
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-blue-50 text-blue-700 border border-blue-200" x-text="sop.kategori"></span>
                        <span class="text-[10px] font-bold text-teal-600 group-hover:text-teal-800 flex items-center gap-0.5">
                            <span>Detail</span>
                            <span>&rarr;</span>
                        </span>
                    </div>
                </div>
            </template>
        </div>

        <!-- State Kosong jika tidak ada pencarian yang cocok -->
        <div x-show="filteredSops.length === 0" x-cloak class="py-10 text-center text-slate-400 text-xs">
            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="font-semibold text-slate-600">Tidak ada dokumen SOP yang sesuai pencarian atau filter.</p>
            <p class="text-[11px] text-slate-400 mt-0.5">Coba gunakan kata kunci lain atau pilih kategori "Semua".</p>
        </div>

        <!-- ==================== MODAL DETAIL SOP ==================== -->
        <div x-show="sopDetailModal" 
             x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             @keydown.escape.window="sopDetailModal = false">
            <div class="relative w-full max-w-lg bg-white rounded-3xl p-6 shadow-2xl border border-slate-200 space-y-4"
                 @click.away="sopDetailModal = false">
                
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center space-x-2">
                        <span class="font-mono text-xs font-black text-teal-700 bg-teal-100 px-2.5 py-0.5 rounded-md" x-text="selectedSop.kode"></span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200" x-text="selectedSop.status || 'Aktif'"></span>
                    </div>
                    <button @click="sopDetailModal = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                </div>

                <div class="space-y-3">
                    <div>
                        <h3 class="text-base font-black text-[#00264A] leading-snug" x-text="selectedSop.judul"></h3>
                        <p class="text-[11px] text-slate-400 font-semibold mt-1 flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-bold" x-text="selectedSop.kategori"></span>
                            <span>&bull;</span>
                            <span x-text="selectedSop.revisi || 'Rev. 01 / 2025'"></span>
                        </p>
                    </div>

                    <!-- Standar Suara Siaran Detail -->
                    <template x-if="selectedSop.suara_siaran">
                        <div class="p-3 rounded-xl bg-cyan-50/80 border border-cyan-200/80">
                            <span class="text-[10px] font-bold text-cyan-800 uppercase tracking-wider block mb-0.5">Standar Suara / Audio Siaran:</span>
                            <p class="text-xs font-black text-cyan-900 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                                <span x-text="selectedSop.suara_siaran"></span>
                            </p>
                        </div>
                    </template>

                    <!-- Deskripsi & Ruang Lingkup -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Ruang Lingkup & Deskripsi:</span>
                        <p class="text-xs text-slate-700 leading-relaxed font-medium" x-text="selectedSop.keterangan || 'Standar Operasional Prosedur resmi Lembaga Penyiaran Publik TVRI Stasiun Maluku.'"></p>
                    </div>

                    <!-- Berkas Dokumen -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Dokumen Berkas Digital</span>
                            <p class="text-xs font-bold text-slate-700 mt-0.5" x-text="selectedSop.file_url || 'Arsip Resmi Terverifikasi LPP TVRI'"></p>
                        </div>
                        <template x-if="selectedSop.file_url">
                            <a :href="selectedSop.file_url" target="_blank" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-[#005B9F] hover:bg-[#003B70] text-white">
                                Unduh SOP
                            </a>
                        </template>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                    <a href="{{ route('tvri.program.manage', ['tab' => 'sop']) }}" class="text-xs font-bold text-teal-600 hover:text-teal-800">
                        Buka di Halaman Manajemen &rarr;
                    </a>
                    <button type="button" @click="sopDetailModal = false" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- ==================== MODAL TAMBAH SOP BARU ==================== -->
        <div x-show="createSopModal" 
             x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             @keydown.escape.window="createSopModal = false">
            <div class="relative w-full max-w-lg bg-white rounded-3xl p-6 shadow-2xl border border-slate-200"
                 @click.away="createSopModal = false">
                
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-sm font-black uppercase text-[#00264A]">Tambah Dokumen SOP Baru</h3>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Terbitkan pedoman mutu siaran baru ke repositori kearsipan</p>
                    </div>
                    <button @click="createSopModal = false" class="text-slate-400 hover:text-slate-600 text-lg font-bold">&times;</button>
                </div>

                <form action="{{ route('tvri.program.sop.store') }}" method="POST" class="mt-4 space-y-3.5">
                    @csrf
                    <input type="hidden" name="redirect_to" value="dokumen.dashboard">

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kode SOP <span class="text-rose-500">*</span></label>
                            <input type="text" name="kode" required placeholder="Contoh: SOP-PRG-009" value="SOP-PRG-00{{ count($sops) + 1 }}"
                                   class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-teal-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Tahap <span class="text-rose-500">*</span></label>
                            <select name="kategori" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-teal-600">
                                <option value="Pra Produksi">Pra Produksi</option>
                                <option value="Produksi">Produksi</option>
                                <option value="Pasca Produksi">Pasca Produksi</option>
                                <option value="Quality Control">Quality Control</option>
                                <option value="Penayangan">Penayangan</option>
                                <option value="Monitoring">Monitoring</option>
                                <option value="Evaluasi">Evaluasi</option>
                                <option value="Umum Siaran">Umum Siaran</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Dokumen SOP <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" required placeholder="Contoh: SOP Penyiaran Siaran Langsung Debat Publik Pilkada" 
                               class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-teal-600">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Standar Suara / Format Audio Siaran</label>
                        <input type="text" name="suara_siaran" placeholder="Contoh: Stereo EBU R128 (-23 LUFS) / 48kHz 24-bit" 
                               class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-teal-600">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Revisi</label>
                            <input type="text" name="revisi" placeholder="Rev. 01 / 2025" value="Rev. 01 / 2025"
                                   class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-teal-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Status Prosedur <span class="text-rose-500">*</span></label>
                            <select name="status" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-teal-600">
                                <option value="Aktif">Aktif</option>
                                <option value="Review">Review</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat / Ruang Lingkup</label>
                        <textarea name="keterangan" rows="2" placeholder="Penjelasan ringkas alur kerja, protokol kepatuhan mutu, dan penanggung jawab..."
                                  class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-teal-600"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tautan File Dokumen</label>
                            <input type="text" name="file_url" placeholder="Contoh: /dokumen/sop/sop-009.pdf"
                                   class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-teal-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Urutan</label>
                            <input type="number" name="urutan" value="{{ count($sops) + 1 }}"
                                   class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-teal-600">
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                        <button type="button" @click="createSopModal = false" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-black bg-teal-600 hover:bg-teal-700 text-white shadow-md">+ Simpan & Terbitkan SOP</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

<!-- Chart.js CDN & Init Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Division Chart
    const divCtx = document.getElementById('divisionChart').getContext('2d');
    new Chart(divCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($divisionLabels) !!},
            datasets: [{
                label: 'Jumlah Dokumen',
                data: {!! json_encode($divisionCounts) !!},
                backgroundColor: '#005B9F',
                borderRadius: 6,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // 2. Format Chart (Doughnut)
    const fmtCtx = document.getElementById('formatChart').getContext('2d');
    new Chart(fmtCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($formatLabels) !!},
            datasets: [{
                data: {!! json_encode($formatCounts) !!},
                backgroundColor: [
                    '#E11D48', // PDF - Rose
                    '#2563EB', // DOCX - Blue
                    '#059669', // XLSX - Emerald
                    '#D97706', // PPTX - Amber
                    '#7C3AED', // Media - Purple
                    '#475569', // Zip/Other - Slate
                ],
                borderWidth: 2,
                borderColor: '#FFFFFF'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            },
            cutout: '60%'
        }
    });

    // 3. Confidentiality Chart (Pie)
    const confCtx = document.getElementById('confChart').getContext('2d');
    new Chart(confCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($confLabels) !!},
            datasets: [{
                data: {!! json_encode($confCounts) !!},
                backgroundColor: [
                    '#10B981', // Publik - Emerald
                    '#3B82F6', // Internal - Blue
                    '#F59E0B', // Terbatas - Amber
                    '#EF4444', // Rahasia - Rose
                ],
                borderWidth: 2,
                borderColor: '#FFFFFF'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
        }
    });
});
</script>
@endsection
