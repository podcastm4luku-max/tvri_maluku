<!-- Sidebar Container -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed lg:static inset-y-0 left-0 z-50 w-72 bg-[#00264A] text-white flex flex-col transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none flex-shrink-0 select-none">

    <!-- Logo & Brand Header -->
    <div class="h-20 bg-[#001D38] border-b border-blue-900/50 flex items-center justify-between px-5">
        <div class="flex items-center space-x-3.5">
            <div class="w-11 h-11 rounded-xl bg-white p-1.5 border border-blue-400/30 flex items-center justify-center shadow-inner">
                <img src="{{ asset('images/logo_tvri.png') }}" alt="Logo TVRI" class="w-full h-full object-contain rounded-lg">
            </div>
            <div>
                <h1 class="text-sm font-black tracking-wider uppercase text-white leading-tight">TVRI MALUKU</h1>
                <p class="text-[10px] text-blue-300 font-medium leading-tight">Media Pemersatu Bangsa<br>di Bumi Raja-Raja</p>
            </div>
        </div>

        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="lg:hidden text-blue-300 hover:text-white p-1.5 rounded-lg hover:bg-blue-900/50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Tagline Banner -->
    <div class="px-5 py-2.5 bg-[#003B70]/70 border-b border-blue-900/40">
        <p class="text-[10px] font-semibold text-blue-200 uppercase tracking-widest text-center">
            Satu Data, Satu Arah, Penyiaran Lebih Kuat
        </p>
    </div>

    <!-- Navigation Menu Items -->
    <div class="flex-1 overflow-y-auto px-4 py-4 space-y-6">

        @php
            $currentUser = auth()->user();
            $isBerita = $currentUser && ($currentUser->username === 'berita');
            $isKeuangan = $currentUser && in_array($currentUser->username, ['keuangan', 'kasubag.keuangan']);
            $isAdmin = $currentUser && in_array($currentUser->username, ['admin', 'superadmin']);
            $isKepalaStasiun = $currentUser && ($currentUser->hasRole('KEPALA_DINAS') || $currentUser->hasRole('Kepala Stasiun') || $currentUser->username === 'kepala.stasiun' || str_contains(strtolower($currentUser->name), 'kepala stasiun'));

            $isTU = $currentUser && in_array($currentUser->username, ['admin.tu']);
            $isProgram = $currentUser && ($currentUser->username === 'program');
            $isKMB = $currentUser && ($currentUser->username === 'konten.media.baru' || str_contains(strtolower($currentUser->name ?? ''), 'konten media baru'));
            $isPromo = $currentUser && ($currentUser->username === 'promo' || $currentUser->hasRole('Promo') || str_contains(strtolower($currentUser->name ?? ''), 'promo'));
            $isUsaha = $currentUser && ($currentUser->username === 'pengembangan.usaha' || str_contains(strtolower($currentUser->name ?? ''), 'pengembangan usaha'));
            $isTeknik = $currentUser && ($currentUser->username === 'teknik');
            $isTransmisi = $currentUser && ($currentUser->username === 'teknik.transmisi');
            $isUmum = $currentUser && ($currentUser->username === 'umum');

            if ($isBerita) {
                $dashboardRoute = route('tvri.berita.dashboard');
                $dashboardLabel = 'Berita (Newsroom)';
                $isDashboardActive = request()->routeIs('tvri.berita.dashboard');
            } elseif ($isKeuangan) {
                $dashboardRoute = route('tvri.keuangan.dashboard');
                $dashboardLabel = 'Keuangan & PNBP';
                $isDashboardActive = request()->routeIs('tvri.keuangan.dashboard');
            } elseif ($isTU) {
                $dashboardRoute = route('tvri.tu.dashboard');
                $dashboardLabel = 'Tata Usaha (KTU)';
                $isDashboardActive = request()->routeIs('tvri.tu.*') || request()->routeIs('tvri.ktu.*');
            } elseif ($isProgram) {
                $dashboardRoute = route('tvri.program.dashboard');
                $dashboardLabel = 'Program & Siaran';
                $isDashboardActive = request()->routeIs('tvri.program.*');
            } elseif ($isKMB) {
                $dashboardRoute = route('tvri.mbn.dashboard');
                $dashboardLabel = 'Konten Media Baru';
                $isDashboardActive = request()->routeIs('tvri.mbn.*') || request()->routeIs('tvri.kmb.*');
            } elseif ($isPromo) {
                $dashboardRoute = route('tvri.promo.dashboard');
                $dashboardLabel = 'Dasboar Unit Kerja Promo';
                $isDashboardActive = request()->routeIs('tvri.promo.*');
            } elseif ($isUsaha) {
                $dashboardRoute = route('tvri.usaha.dashboard');
                $dashboardLabel = 'Pengembangan Usaha';
                $isDashboardActive = request()->routeIs('tvri.usaha.*');
            } elseif ($isTeknik) {
                $dashboardRoute = route('tvri.teknik.dashboard');
                $dashboardLabel = 'Teknik Studio';
                $isDashboardActive = request()->routeIs('tvri.teknik.*');
            } elseif ($isTransmisi) {
                $dashboardRoute = route('tvri.transmisi.dashboard');
                $dashboardLabel = 'Teknik Transmisi';
                $isDashboardActive = request()->routeIs('tvri.transmisi.*');
            } elseif ($isUmum) {
                $dashboardRoute = route('tvri.umum.dashboard');
                $dashboardLabel = 'Umum & Logistik';
                $isDashboardActive = request()->routeIs('tvri.umum.*');
            } else {
                $dashboardRoute = route('tvri.ecc.dashboard');
                $dashboardLabel = 'Executive Command Center';
                $isDashboardActive = request()->routeIs('tvri.ecc.dashboard') || request()->routeIs('kepala-dinas.dashboard');
            }
        @endphp

        <!-- 1. UTAMA -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-blue-400">Utama</div>
            <div class="space-y-1">
                <a href="{{ $dashboardRoute }}"
                   class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isDashboardActive ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>{{ $dashboardLabel }}</span>
                </a>
                @if(!$isKepalaStasiun)
                <a href="{{ route('tvri.ecc.dashboard') }}"
                   class="flex items-center space-x-3 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('tvri.ecc.dashboard') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-200 hover:bg-blue-900/50 hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>Monitoring ECC</span>
                </a>
                @endif
            </div>
        </div>

        <!-- 2. UNIT KERJA -->
        @php
            $bidangNav = [
                ['route' => 'tvri.berita.dashboard', 'label' => 'Berita (Newsroom)', 'badge' => 'NEWS', 'pattern' => 'tvri.berita.*', 'icon' => 'news'],
                ['route' => 'tvri.keuangan.dashboard', 'label' => 'Keuangan & PNBP', 'badge' => 'KEU', 'pattern' => 'tvri.keuangan.*', 'icon' => 'keu'],
                ['route' => 'tvri.tu.dashboard', 'label' => 'Tata Usaha (KTU)', 'badge' => 'KTU', 'pattern' => 'tvri.tu.*'],
                ['route' => 'tvri.program.dashboard', 'label' => 'Program & Siaran', 'badge' => 'PRG', 'pattern' => 'tvri.program.*'],
                ['route' => 'tvri.mbn.dashboard', 'label' => 'Konten Media Baru', 'badge' => 'KMB', 'pattern' => 'tvri.mbn.*'],
                ['route' => 'tvri.promo.dashboard', 'label' => 'Dasboar Unit Kerja Promo', 'badge' => 'PRM', 'pattern' => 'tvri.promo.*'],
                ['route' => 'tvri.usaha.dashboard', 'label' => 'Pengembangan Usaha', 'badge' => 'PNBP', 'pattern' => 'tvri.usaha.*'],
                ['route' => 'tvri.teknik.dashboard', 'label' => 'Teknik Studio', 'badge' => 'TEK', 'pattern' => 'tvri.teknik.*'],
                ['route' => 'tvri.transmisi.dashboard', 'label' => 'Teknik Transmisi', 'badge' => 'TX', 'pattern' => 'tvri.transmisi.*'],
                ['route' => 'tvri.umum.dashboard', 'label' => 'Umum & Logistik', 'badge' => 'UMM', 'pattern' => 'tvri.umum.*'],
            ];

            // Jika user adalah akun Bidang Pemberitaan (berita), hapuskan menu unit kerja lain
            if ($isBerita) {
                $bidangNav = array_filter($bidangNav, function ($item) {
                    return $item['route'] === 'tvri.berita.dashboard';
                });
            }

            // Jika user adalah akun Bidang Promo (promo), hapuskan menu unit kerja lain
            if ($isPromo) {
                $bidangNav = array_filter($bidangNav, function ($item) {
                    return $item['route'] === 'tvri.promo.dashboard';
                });
            }

            // Jika user adalah akun Bidang Program (program), hapuskan menu unit kerja lain (KTU, KMB, berita, usaha, teknik, transmisi, umum, dll)
            if ($isProgram) {
                $bidangNav = array_filter($bidangNav, function ($item) {
                    return $item['route'] === 'tvri.program.dashboard';
                });
            }

            // Jika user adalah akun Umum & Logistik (umum), hapuskan menu unit kerja lain (KTU, KMB, berita, usaha, teknik, transmisi, program, keuangan)
            if ($isUmum) {
                $bidangNav = array_filter($bidangNav, function ($item) {
                    return $item['route'] === 'tvri.umum.dashboard';
                });
            }

            // Jika user adalah akun Tata Usaha (admin.tu), hapuskan menu unit kerja lain (KMB, berita, usaha, teknik, transmisi, program, keuangan, umum)
            if ($isTU) {
                $bidangNav = array_filter($bidangNav, function ($item) {
                    return $item['route'] === 'tvri.tu.dashboard';
                });
            }

            // Jika user adalah akun Bidang Pengembangan Usaha (pengembangan.usaha), hapuskan menu unit kerja lain (KTU, berita, teknik studio, teknik transmisi, program, keuangan, umum, kmb, promo)
            if ($isUsaha) {
                $bidangNav = array_filter($bidangNav, function ($item) {
                    return $item['route'] === 'tvri.usaha.dashboard';
                });
            }

            // Jika user adalah akun Bidang Konten Media Baru (konten.media.baru), hapuskan menu unit kerja lain (KTU, berita, teknik studio, teknik transmisi, program, keuangan, umum, usaha, promo)
            if ($isKMB) {
                $bidangNav = array_filter($bidangNav, function ($item) {
                    return in_array($item['route'], ['tvri.mbn.dashboard', 'tvri.kmb.dashboard']);
                });
            }

            // Jika user adalah akun Bidang Teknik Studio (teknik), hapuskan menu unit kerja lain (KTU, berita, kmb, teknik transmisi, program, keuangan, umum, usaha, promo)
            if ($isTeknik) {
                $bidangNav = array_filter($bidangNav, function ($item) {
                    return $item['route'] === 'tvri.teknik.dashboard';
                });
            }

            // Jika user adalah akun Bidang Teknik Transmisi (teknik.transmisi), hapuskan menu unit kerja lain (KTU, berita, kmb, program, keuangan, umum, usaha, teknik studio)
            if ($isTransmisi) {
                $bidangNav = array_filter($bidangNav, function ($item) {
                    return $item['route'] === 'tvri.transmisi.dashboard';
                });
            }

            // Jika user adalah akun Bidang Keuangan (keuangan / kasubag.keuangan), hapuskan menu unit kerja lain (KTU, berita, kmb, program, siaran, umum, logistik, usaha, teknik studio, transmisi)
            if ($isKeuangan) {
                $bidangNav = array_filter($bidangNav, function ($item) {
                    return $item['route'] === 'tvri.keuangan.dashboard';
                });
            }
        @endphp
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-amber-300">Unit Kerja</div>
            <div class="space-y-1">
                @foreach ($bidangNav as $bn)
                    @php $bnActive = request()->routeIs($bn['pattern']); @endphp
                    <a href="{{ route($bn['route']) }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $bnActive ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-1.5 h-1.5 rounded-full {{ $bnActive ? 'bg-amber-300' : 'bg-blue-300/60' }}"></span>
                            <span>{{ $bn['label'] }}</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $bnActive ? 'bg-white/20 text-white' : 'bg-white/10 text-blue-200 border-white/10' }}">{{ $bn['badge'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        @if($isProgram)
        <!-- MENU UTAMA / NAVIGASI KIRI BIDANG PROGRAM -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-purple-300">Navigasi Program</div>
            <div class="space-y-1">
                <a href="{{ route('tvri.program.dashboard') }}"
                   class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('tvri.program.dashboard') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('tvri.program.dashboard') ? 'bg-amber-300' : 'bg-purple-400' }}"></span>
                        <span>Dashboard</span>
                    </div>
                </a>
                <a href="{{ route('tvri.program.dashboard') }}#perencanaan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Perencanaan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.program.dashboard') }}#tahap-produksi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pra Produksi & Produksi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.program.dashboard') }}#tahap-produksi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pasca Produksi & QC</span>
                    </div>
                </a>
                <a href="{{ route('tvri.program.dashboard') }}#daftar-program"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Penayangan & Jadwal</span>
                    </div>
                </a>
                <a href="{{ route('tvri.program.dashboard') }}#evaluasi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Evaluasi Program</span>
                    </div>
                </a>
                <a href="{{ route('tvri.program.dashboard') }}#kalender"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kalender Program</span>
                    </div>
                </a>
                <a href="{{ route('tvri.program.dashboard') }}#laporan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Arsip & Laporan</span>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pengaturan</span>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if($isUmum)
        <!-- MENU UTAMA / NAVIGASI KIRI BIDANG UMUM & LOGISTIK -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-emerald-400">Navigasi Umum & Logistik</div>
            <div class="space-y-1">
                <a href="{{ route('tvri.umum.dashboard') }}"
                   class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('tvri.umum.dashboard') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('tvri.umum.dashboard') ? 'bg-amber-300' : 'bg-emerald-400' }}"></span>
                        <span>Dashboard</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#manajemen-aset"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Manajemen Aset</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#sarana-prasarana"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Sarana Prasarana</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#kendaraan-dinas"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kendaraan Dinas</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#pemeliharaan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pemeliharaan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#layanan-umum"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Layanan Umum</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#keamanan-k3"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Keamanan & K3</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#kebersihan-lingkungan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kebersihan & Lingkungan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#pengadaan-logistik"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pengadaan & Logistik</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#monitoring-layanan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Monitoring Layanan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#laporan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Laporan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#kalender-kegiatan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kalender Kegiatan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.umum.dashboard') }}#kontak-vendor"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kontak & Vendor</span>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pengaturan</span>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if($isTU)
        <!-- MENU UTAMA / NAVIGASI KIRI BIDANG TATA USAHA -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-blue-300">Navigasi Tata Usaha</div>
            <div class="space-y-1">
                <a href="{{ route('tvri.tu.dashboard') }}"
                   class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('tvri.tu.dashboard') && !request()->routeIs('tvri.tu.manage') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('tvri.tu.dashboard') ? 'bg-amber-300' : 'bg-blue-400' }}"></span>
                        <span>Dashboard</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#surat-masuk"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Surat Masuk</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#surat-keluar"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Surat Keluar</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#status-disposisi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Disposisi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#agenda"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Agenda & Kegiatan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#layanan-adm"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Layanan Administrasi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#arsip-dokumen"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Arsip & Dokumentasi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#sop-regulasi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>SOP & Regulasi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#monitoring-kinerja"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Monitoring Kinerja</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#laporan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Laporan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#kalender"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kalender</span>
                    </div>
                </a>
                <a href="{{ route('tvri.tu.dashboard') }}#kontak-link"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kontak & Direktorat</span>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pengaturan</span>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if($isUsaha)
        <!-- MENU UTAMA / NAVIGASI KIRI BIDANG PENGEMBANGAN USAHA -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-amber-300">Navigasi Pengembangan Usaha</div>
            <div class="space-y-1">
                <a href="{{ route('tvri.usaha.dashboard') }}"
                   class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('tvri.usaha.dashboard') && !request()->routeIs('tvri.usaha.manage') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('tvri.usaha.dashboard') ? 'bg-amber-300' : 'bg-orange-400' }}"></span>
                        <span>Beranda</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#pendapatan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pendapatan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#kemitraan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kemitraan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#program-usaha"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Program Usaha</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#iklan-sponsorship"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Iklan & Sponsorship</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#event-aktivasi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Event & Aktivasi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#aset-fasilitas"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Aset & Fasilitas</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#analitik-audiens"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Analitik Audiens</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#keuangan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Keuangan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#manajemen-risiko"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Manajemen Risiko</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#rencana-kerja"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Rencana Kerja</span>
                    </div>
                </a>
                <a href="{{ route('tvri.usaha.dashboard') }}#laporan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Laporan</span>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pengaturan</span>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if($isKMB)
        <!-- MENU UTAMA / NAVIGASI KIRI BIDANG KONTEN MEDIA BARU -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-pink-300">Navigasi Media Baru</div>
            <div class="space-y-1">
                <a href="{{ route('tvri.mbn.dashboard') }}"
                   class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ (request()->routeIs('tvri.mbn.dashboard') || request()->routeIs('tvri.kmb.dashboard')) && !request()->routeIs('tvri.mbn.manage') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('tvri.mbn.dashboard') || request()->routeIs('tvri.kmb.dashboard') ? 'bg-amber-300' : 'bg-pink-400' }}"></span>
                        <span>Dashboard</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#konten"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Konten</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#publishing"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Publishing</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#analitik"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Analitik</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#audiens"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Audiens</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#media-sosial"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Media Sosial</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#live-streaming"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Live Streaming</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#website"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Website</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#kolaborasi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kolaborasi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#monetisasi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Monetisasi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#laporan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Laporan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#kalender-konten"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kalender Konten</span>
                    </div>
                </a>
                <a href="{{ route('tvri.mbn.dashboard') }}#manajemen-tim"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Manajemen Tim</span>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pengaturan</span>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if($isTeknik)
        <!-- MENU UTAMA / NAVIGASI KIRI BIDANG TEKNIK STUDIO -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-cyan-300">Navigasi Teknik Studio</div>
            <div class="space-y-1">
                <a href="{{ route('tvri.teknik.dashboard') }}"
                   class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('tvri.teknik.dashboard') && !request()->routeIs('tvri.teknik.manage') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('tvri.teknik.dashboard') ? 'bg-amber-300' : 'bg-cyan-400' }}"></span>
                        <span>Dashboard</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#status-siaran"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Status Siaran (Live)</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#readiness"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Technical Readiness</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#peta-transmisi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Peta Jangkauan & Tx</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#status-studio"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Status Studio</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#status-transmitter"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Status Transmitter</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#monitoring-sistem"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Monitoring Sistem</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#jadwal-produksi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Jadwal Produksi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#maintenance-servis"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Maintenance & Servis</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#insiden-gangguan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Insiden & Gangguan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#inventaris"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Inventaris Utama</span>
                    </div>
                </a>
                <a href="{{ route('tvri.teknik.dashboard') }}#sop-dokumen"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Dokumen & SOP</span>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pengaturan</span>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if($isTransmisi)
        <!-- MENU UTAMA / NAVIGASI KIRI BIDANG TEKNIK TRANSMISI -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-cyan-300">Navigasi Transmisi</div>
            <div class="space-y-1">
                <a href="{{ route('tvri.transmisi.dashboard') }}"
                   class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('tvri.transmisi.dashboard') && !request()->routeIs('tvri.transmisi.manage') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('tvri.transmisi.dashboard') ? 'bg-amber-300' : 'bg-cyan-400' }}"></span>
                        <span>Dashboard</span>
                    </div>
                </a>
                <a href="{{ route('tvri.transmisi.dashboard') }}#peta-transmisi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Peta Transmisi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.transmisi.dashboard') }}#stasiun-pemancar"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Stasiun Pemancar</span>
                    </div>
                </a>
                <a href="{{ route('tvri.transmisi.dashboard') }}#monitoring-siaran"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Monitoring Siaran</span>
                    </div>
                </a>
                <a href="{{ route('tvri.transmisi.dashboard') }}#kualitas-sinyal"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Kualitas Sinyal</span>
                    </div>
                </a>
                <a href="{{ route('tvri.transmisi.dashboard') }}#infrastruktur"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Infrastruktur</span>
                    </div>
                </a>
                <a href="{{ route('tvri.transmisi.dashboard') }}#daya-energi"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Daya & Energi</span>
                    </div>
                </a>
                <a href="{{ route('tvri.transmisi.dashboard') }}#alarm-gangguan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Alarm & Gangguan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.transmisi.dashboard') }}#pemeliharaan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pemeliharaan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.transmisi.dashboard') }}#log-aktivitas"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Log Aktivitas</span>
                    </div>
                </a>
                <a href="{{ route('tvri.transmisi.dashboard') }}#dokumen-laporan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Dokumen & Laporan</span>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pengaturan</span>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if($isKeuangan)
        <!-- MENU UTAMA / NAVIGASI KIRI BIDANG KEUANGAN -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-teal-300">Navigasi Keuangan</div>
            <div class="space-y-1">
                <a href="{{ route('tvri.keuangan.dashboard') }}"
                   class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('tvri.keuangan.dashboard') && !request()->routeIs('tvri.keuangan.manage') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('tvri.keuangan.dashboard') ? 'bg-amber-300' : 'bg-teal-400' }}"></span>
                        <span>Beranda</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#realisasi-anggaran"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Realisasi Anggaran</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#realisasi-pnbp"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Realisasi PNBP</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#perencanaan-anggaran"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Perencanaan Anggaran</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#pembayaran"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pembayaran</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#piutang-tagihan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Piutang & Tagihan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#posisi-aset"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Aset & BMN</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#laporan-keuangan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Laporan Keuangan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#kinerja-ikpa"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Monitoring IKPA</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#analisis-keuangan"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Analisis Keuangan</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#manajemen-risiko"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Manajemen Risiko</span>
                    </div>
                </a>
                <a href="{{ route('tvri.keuangan.dashboard') }}#dokumen-sop"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Dokumen</span>
                    </div>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center justify-between px-3.5 py-1.5 rounded-xl text-xs font-semibold text-blue-100 hover:bg-blue-900/50 hover:text-white transition-all">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-300/60"></span>
                        <span>Pengaturan</span>
                    </div>
                </a>
            </div>

            <!-- Slogan Bawah Kiri -->
            <div class="mt-4 px-3 py-2 rounded-xl bg-teal-950/60 border border-teal-500/30 text-center shadow-inner">
                <span class="text-[11px] text-teal-300 font-extrabold tracking-wide">✨ Maluku Lebih Baik Bersama</span>
            </div>
        </div>
        @endif

        @if(!$isKepalaStasiun && ($isAdmin || $isBerita || $isKeuangan || $isPromo || $isProgram || $isUmum || $isTU || $isUsaha || $isKMB || $isTeknik || $isTransmisi))
        <!-- KELOLA & INPUT DATA OPERASIONAL -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-cyan-400">Input & Kelola Data</div>
            <div class="space-y-1">
                @if($isAdmin || $isKMB)
                    @php $isKmbManage = request()->routeIs('tvri.mbn.manage') || request()->routeIs('tvri.kmb.manage'); @endphp
                    <a href="{{ route('tvri.mbn.manage') }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $isKmbManage ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 {{ $isKmbManage ? 'text-white' : 'text-pink-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <span>Input Data Konten Media Baru</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $isKmbManage ? 'bg-white/20 text-white' : 'bg-pink-500/20 text-pink-200 border-pink-400/30' }}">KMB</span>
                    </a>
                @endif
                @if($isAdmin || $isUsaha)
                    @php $isUsahaManage = request()->routeIs('tvri.usaha.manage'); @endphp
                    <a href="{{ route('tvri.usaha.manage') }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $isUsahaManage ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 {{ $isUsahaManage ? 'text-white' : 'text-amber-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Input Data Pengembangan Usaha</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $isUsahaManage ? 'bg-white/20 text-white' : 'bg-amber-500/20 text-amber-200 border-amber-400/30' }}">PNBP</span>
                    </a>
                @endif
                @if($isAdmin || $isTU)
                    @php $isTuManage = request()->routeIs('tvri.tu.manage'); @endphp
                    <a href="{{ route('tvri.tu.manage') }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $isTuManage ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 {{ $isTuManage ? 'text-white' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h6m-9 12h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Input Data Tata Usaha</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $isTuManage ? 'bg-white/20 text-white' : 'bg-blue-500/20 text-blue-200 border-blue-400/30' }}">KTU</span>
                    </a>
                @endif
                @if($isAdmin || $isUmum)
                    @php $isUmumManage = request()->routeIs('tvri.umum.manage'); @endphp
                    <a href="{{ route('tvri.umum.manage') }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $isUmumManage ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 {{ $isUmumManage ? 'text-white' : 'text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            <span>Input Data Umum</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $isUmumManage ? 'bg-white/20 text-white' : 'bg-emerald-500/20 text-emerald-200 border-emerald-400/30' }}">UMM</span>
                    </a>
                @endif
                @if($isAdmin || $isProgram)
                    @php $isProgramManage = request()->routeIs('tvri.program.manage'); @endphp
                    <a href="{{ route('tvri.program.manage') }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $isProgramManage ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 {{ $isProgramManage ? 'text-white' : 'text-purple-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span>Input Data Program</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $isProgramManage ? 'bg-white/20 text-white' : 'bg-purple-500/20 text-purple-200 border-purple-400/30' }}">PRG</span>
                    </a>
                @endif
                @if($isAdmin || $isPromo)
                    @php $isPromoManage = request()->routeIs('tvri.promo.manage') || request()->routeIs('tvri.promo.create'); @endphp
                    <a href="{{ route('tvri.promo.manage') }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $isPromoManage ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 {{ $isPromoManage ? 'text-white' : 'text-indigo-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <span>Input Data Promo</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $isPromoManage ? 'bg-white/20 text-white' : 'bg-indigo-500/20 text-indigo-200 border-indigo-400/30' }}">PRM</span>
                    </a>
                @endif
                @if($isAdmin || $isBerita)
                    @php $isBeritaManage = request()->routeIs('tvri.berita.manage'); @endphp
                    <a href="{{ route('tvri.berita.manage') }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $isBeritaManage ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 {{ $isBeritaManage ? 'text-white' : 'text-amber-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <span>Input Data Berita</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $isBeritaManage ? 'bg-white/20 text-white' : 'bg-amber-500/20 text-amber-200 border-amber-400/30' }}">NEWS</span>
                    </a>
                @endif
                @if($isAdmin || $isKeuangan)
                    @php $isKeuManage = request()->routeIs('tvri.keuangan.manage'); @endphp
                    <a href="{{ route('tvri.keuangan.manage') }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $isKeuManage ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 {{ $isKeuManage ? 'text-white' : 'text-teal-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Input Data Keuangan</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $isKeuManage ? 'bg-white/20 text-white' : 'bg-teal-500/20 text-teal-200 border-teal-400/30' }}">KEU</span>
                    </a>
                @endif
                @if($isAdmin || $isTeknik)
                    @php $isTeknikManage = request()->routeIs('tvri.teknik.manage'); @endphp
                    <a href="{{ route('tvri.teknik.manage') }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $isTeknikManage ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 {{ $isTeknikManage ? 'text-white' : 'text-cyan-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Input Data Teknik Studio</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $isTeknikManage ? 'bg-white/20 text-white' : 'bg-cyan-500/20 text-cyan-200 border-cyan-400/30' }}">TEK</span>
                    </a>
                @endif
                @if($isAdmin || $isTransmisi)
                    @php $isTransmisiManage = request()->routeIs('tvri.transmisi.manage'); @endphp
                    <a href="{{ route('tvri.transmisi.manage') }}"
                       class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 {{ $isTransmisiManage ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 {{ $isTransmisiManage ? 'text-white' : 'text-cyan-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                            <span>Input Data Teknik Transmisi</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded border {{ $isTransmisiManage ? 'bg-white/20 text-white' : 'bg-cyan-500/20 text-cyan-200 border-cyan-400/30' }}">TX</span>
                    </a>
                @endif
            </div>
        </div>
        @endif

        <!-- 3. ARSIP & DOKUMENTASI -->
        <div>
            <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-rose-400">Arsip & Dokumentasi</div>
            <div class="space-y-1">
                <a href="{{ route('dokumen.dashboard') }}"
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('dokumen.dashboard') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        <span>Dashboard Kearsipan</span>
                    </div>
                </a>
                <a href="{{ route('dokumen.documents.index') }}"
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('dokumen.documents.index') || request()->routeIs('dokumen.documents.show') || request()->routeIs('dokumen.documents.edit') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span>Pangkalan Dokumen</span>
                    </div>
                </a>
                <a href="{{ route('dokumen.folders.index') }}"
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('dokumen.folders.*') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        <span>Folder Explorer</span>
                    </div>
                    <span class="px-1.5 py-0.5 text-[9px] font-bold bg-amber-500/20 text-amber-300 rounded border border-amber-500/30">DMS</span>
                </a>
                <a href="{{ route('dokumen.documents.create') }}"
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('dokumen.documents.create') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                    <div class="flex items-center space-x-2.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <span>Unggah Dokumen Baru</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- 4. ADMINISTRASI SISTEM (ADMIN ONLY) -->
        @if($isAdmin)
            <div>
                <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-wider text-emerald-400">Administrasi & Keamanan</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>Pengguna Sistem</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold bg-emerald-500/20 text-emerald-300 rounded border border-emerald-500/30">Aktif</span>
                    </a>

                    <a href="{{ route('admin.activity-logs.index') }}"
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-[#005B9F] text-white shadow-md' : 'text-blue-100 hover:bg-blue-900/50 hover:text-white' }}">
                        <div class="flex items-center space-x-2.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Aktivitas Sistem</span>
                        </div>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold bg-emerald-500/20 text-emerald-300 rounded border border-emerald-500/30">Aktif</span>
                    </a>
                </div>
            </div>
        @endif

    </div>

    <!-- User Mini Profile Footer in Sidebar -->
    <div class="p-3.5 bg-[#001D38] border-t border-blue-900/50 flex items-center justify-between">
        <div class="flex items-center space-x-2.5 min-w-0">
            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-8 h-8 rounded-lg object-cover ring-2 ring-blue-400/40">
            <div class="min-w-0 truncate">
                <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-blue-300 uppercase tracking-wider font-bold">{{ auth()->user()->role_name }}</p>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" title="Keluar dari Sistem" class="p-2 text-rose-300 hover:text-rose-100 hover:bg-rose-900/40 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </button>
        </form>
    </div>
</aside>
