<?php

namespace App\Http\Controllers\Tvri;

use App\Http\Controllers\Controller;
use App\Models\TvriTransmisiRingkasan;
use App\Models\TvriTransmisiPemeliharaan;
use App\Models\TvriTransmisiLog;
use App\Models\TvriTransmisiSop;
use App\Models\TvriStasiunPemancar;
use App\Models\TvriGangguan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransmisiController extends Controller
{
    private function getRingkasan(): TvriTransmisiRingkasan
    {
        $ringkasan = TvriTransmisiRingkasan::first();
        if (!$ringkasan || TvriStasiunPemancar::count() === 0 || TvriTransmisiSop::count() === 0) {
            $seeder = new \Database\Seeders\TvriTransmisiDataSeeder();
            $seeder->run();
            $ringkasan = TvriTransmisiRingkasan::first();
        }
        return $ringkasan;
    }

    public function index()
    {
        $ringkasan = $this->getRingkasan();

        $sites = TvriStasiunPemancar::orderBy('status', 'asc')->get();
        $siteTotal = $sites->count() ?: $ringkasan->total_site;
        $siteOnAir = $sites->where('status', 'On-Air')->count();
        $siteGangguan = $sites->where('status', 'Gangguan')->count();
        $siteMaintenance = $sites->where('status', 'Maintenance')->count();
        $kualitasRata = $sites->avg('kualitas') ?? $ringkasan->kualitas_rata;
        $totalDaya = (float) $sites->sum('daya_kw');
        $pctOnAir = $siteTotal > 0 ? round($siteOnAir / $siteTotal * 100) : $ringkasan->on_air_pct;

        $gangguans = TvriGangguan::orderBy('id', 'desc')->get();
        $gangguanTotal = $gangguans->count();
        $gangguanAktif = $gangguans->where('status', 'Proses')->count();
        $gangguanSelesai = $gangguans->where('status', 'Selesai')->count();

        $pemeliharaans = TvriTransmisiPemeliharaan::orderByDesc('id')->get();
        $logs = TvriTransmisiLog::orderByDesc('id')->limit(10)->get();
        $sops = TvriTransmisiSop::orderBy('urutan')->get();

        return view('tvri.transmisi.dashboard', compact(
            'ringkasan',
            'siteTotal', 'siteOnAir', 'siteGangguan', 'siteMaintenance',
            'kualitasRata', 'totalDaya', 'pctOnAir',
            'gangguanTotal', 'gangguanAktif', 'gangguanSelesai',
            'sites', 'gangguans', 'pemeliharaans', 'logs', 'sops'
        ));
    }

    public function manage(Request $request)
    {
        $ringkasan = $this->getRingkasan();
        $sites = TvriStasiunPemancar::orderBy('id')->get();
        $gangguans = TvriGangguan::orderByDesc('id')->get();
        $pemeliharaans = TvriTransmisiPemeliharaan::orderByDesc('id')->get();
        $logs = TvriTransmisiLog::orderByDesc('id')->get();
        $sops = TvriTransmisiSop::orderBy('urutan')->get();

        $tab = $request->query('tab', 'pemancar');

        return view('tvri.transmisi.manage', compact(
            'ringkasan', 'sites', 'gangguans', 'pemeliharaans', 'logs', 'sops', 'tab'
        ));
    }

    public function updateRingkasan(Request $request)
    {
        $ringkasan = $this->getRingkasan();

        $validated = $request->validate([
            'judul' => 'required|string',
            'slogan' => 'required|string',
            'slogan_tambahan' => 'nullable|string',
            'waktu_status' => 'required|string',
            'periode' => 'required|string',
            'total_site' => 'required|integer',
            'total_site_diff' => 'nullable|string',
            'on_air_pct' => 'required|integer',
            'on_air_target' => 'required|integer',
            'cakupan_wilayah_pct' => 'required|integer',
            'cakupan_diff' => 'nullable|string',
            'kualitas_rata' => 'required|numeric',
            'kualitas_diff' => 'nullable|string',
            'gangguan_aktif' => 'required|integer',
            'gangguan_diff' => 'nullable|string',
            'pemeliharaan_berjalan' => 'required|integer',
            'pemeliharaan_diff' => 'nullable|string',
            'efisiensi_daya_pct' => 'required|integer',
            'efisiensi_diff' => 'nullable|string',
            'footer_slogan' => 'nullable|string',
            'footer_quote' => 'nullable|string',
        ]);

        $ringkasan->update($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'ringkasan'])
            ->with('success', 'Parameter & KPI Utama Teknik Transmisi berhasil diperbarui.');
    }

    public function reseedDefaults()
    {
        $seeder = new \Database\Seeders\TvriTransmisiDataSeeder();
        $seeder->run();

        return redirect()->route('tvri.transmisi.manage')
            ->with('success', 'Seluruh data Teknik Transmisi berhasil disinkronkan sesuai data spesifikasi resmi!');
    }

    // ===== CRUD PEMANCAR =====
    public function storePemancar(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'lokasi' => 'required|string|max:150',
            'kanal' => 'required|string|max:50',
            'frekuensi' => 'required|string|max:50',
            'daya_kw' => 'required|numeric',
            'coverage' => 'nullable|string|max:100',
            'status' => 'required|in:On-Air,Maintenance,Gangguan',
            'kualitas' => 'required|numeric|min:1|max:5',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        TvriStasiunPemancar::create($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'pemancar'])
            ->with('success', 'Stasiun Pemancar baru berhasil ditambahkan.');
    }

    public function updatePemancar(Request $request, $id)
    {
        $pemancar = TvriStasiunPemancar::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'lokasi' => 'required|string|max:150',
            'kanal' => 'required|string|max:50',
            'frekuensi' => 'required|string|max:50',
            'daya_kw' => 'required|numeric',
            'coverage' => 'nullable|string|max:100',
            'status' => 'required|in:On-Air,Maintenance,Gangguan',
            'kualitas' => 'required|numeric|min:1|max:5',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $pemancar->update($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'pemancar'])
            ->with('success', "Data Stasiun Pemancar {$pemancar->nama} berhasil diperbarui.");
    }

    public function destroyPemancar($id)
    {
        $pemancar = TvriStasiunPemancar::findOrFail($id);
        $pemancar->delete();

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'pemancar'])
            ->with('success', 'Stasiun Pemancar berhasil dihapus.');
    }

    public function bulkDestroyPemancar(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            TvriStasiunPemancar::whereIn('id', $ids)->delete();
            return redirect()->route('tvri.transmisi.manage', ['tab' => 'pemancar'])
                ->with('success', count($ids) . ' Stasiun Pemancar berhasil dihapus.');
        }
        return redirect()->route('tvri.transmisi.manage', ['tab' => 'pemancar'])
            ->with('error', 'Tidak ada data pemancar yang dipilih.');
    }

    // ===== CRUD GANGGUAN =====
    public function storeGangguan(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|string',
            'site' => 'required|string',
            'jenis' => 'required|string',
            'status' => 'required|in:Proses,Selesai',
            'keterangan' => 'nullable|string',
        ]);

        TvriGangguan::create($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'gangguan'])
            ->with('success', 'Catatan alarm / gangguan transmisi berhasil ditambahkan.');
    }

    public function updateGangguan(Request $request, $id)
    {
        $gangguan = TvriGangguan::findOrFail($id);

        $validated = $request->validate([
            'tanggal' => 'required|string',
            'site' => 'required|string',
            'jenis' => 'required|string',
            'status' => 'required|in:Proses,Selesai',
            'keterangan' => 'nullable|string',
        ]);

        $gangguan->update($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'gangguan'])
            ->with('success', 'Data alarm / gangguan transmisi berhasil diperbarui.');
    }

    public function destroyGangguan($id)
    {
        $gangguan = TvriGangguan::findOrFail($id);
        $gangguan->delete();

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'gangguan'])
            ->with('success', 'Catatan gangguan berhasil dihapus.');
    }

    public function bulkDestroyGangguan(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            TvriGangguan::whereIn('id', $ids)->delete();
            return redirect()->route('tvri.transmisi.manage', ['tab' => 'gangguan'])
                ->with('success', count($ids) . ' Catatan gangguan berhasil dihapus.');
        }
        return redirect()->route('tvri.transmisi.manage', ['tab' => 'gangguan'])
            ->with('error', 'Tidak ada data gangguan yang dipilih.');
    }

    // ===== CRUD PEMELIHARAAN =====
    public function storePemeliharaan(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|string',
            'site' => 'required|string',
            'kegiatan' => 'required|string',
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        TvriTransmisiPemeliharaan::create($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'pemeliharaan'])
            ->with('success', 'Jadwal pemeliharaan pemancar berhasil ditambahkan.');
    }

    public function updatePemeliharaan(Request $request, $id)
    {
        $item = TvriTransmisiPemeliharaan::findOrFail($id);

        $validated = $request->validate([
            'tanggal' => 'required|string',
            'site' => 'required|string',
            'kegiatan' => 'required|string',
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $item->update($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'pemeliharaan'])
            ->with('success', 'Jadwal pemeliharaan berhasil diperbarui.');
    }

    public function destroyPemeliharaan($id)
    {
        $item = TvriTransmisiPemeliharaan::findOrFail($id);
        $item->delete();

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'pemeliharaan'])
            ->with('success', 'Jadwal pemeliharaan berhasil dihapus.');
    }

    public function bulkDestroyPemeliharaan(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            TvriTransmisiPemeliharaan::whereIn('id', $ids)->delete();
            return redirect()->route('tvri.transmisi.manage', ['tab' => 'pemeliharaan'])
                ->with('success', count($ids) . ' Jadwal pemeliharaan berhasil dihapus.');
        }
        return redirect()->route('tvri.transmisi.manage', ['tab' => 'pemeliharaan'])
            ->with('error', 'Tidak ada data yang dipilih.');
    }

    // ===== CRUD LOG AKTIVITAS =====
    public function storeLog(Request $request)
    {
        $validated = $request->validate([
            'waktu' => 'required|string',
            'site' => 'nullable|string',
            'aktivitas' => 'required|string',
            'user' => 'required|string',
            'status' => 'nullable|string',
        ]);

        TvriTransmisiLog::create($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'log'])
            ->with('success', 'Log aktivitas transmisi berhasil dicatat.');
    }

    public function updateLog(Request $request, $id)
    {
        $log = TvriTransmisiLog::findOrFail($id);

        $validated = $request->validate([
            'waktu' => 'required|string',
            'site' => 'nullable|string',
            'aktivitas' => 'required|string',
            'user' => 'required|string',
            'status' => 'nullable|string',
        ]);

        $log->update($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'log'])
            ->with('success', 'Log aktivitas berhasil diperbarui.');
    }

    public function destroyLog($id)
    {
        $log = TvriTransmisiLog::findOrFail($id);
        $log->delete();

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'log'])
            ->with('success', 'Log aktivitas berhasil dihapus.');
    }

    public function bulkDestroyLog(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            TvriTransmisiLog::whereIn('id', $ids)->delete();
            return redirect()->route('tvri.transmisi.manage', ['tab' => 'log'])
                ->with('success', count($ids) . ' Log aktivitas berhasil dihapus.');
        }
        return redirect()->route('tvri.transmisi.manage', ['tab' => 'log'])
            ->with('error', 'Tidak ada log yang dipilih.');
    }

    // ===== CRUD DOKUMEN & SOP =====
    public function storeSop(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'nullable|string|max:50',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'versi' => 'required|string|max:20',
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        TvriTransmisiSop::create($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'sop'])
            ->with('success', 'Dokumen / SOP Transmisi berhasil ditambahkan.');
    }

    public function updateSop(Request $request, $id)
    {
        $sop = TvriTransmisiSop::findOrFail($id);

        $validated = $request->validate([
            'kode' => 'nullable|string|max:50',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'versi' => 'required|string|max:20',
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $sop->update($validated);

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'sop'])
            ->with('success', "Dokumen / SOP {$sop->judul} berhasil diperbarui.");
    }

    public function destroySop($id)
    {
        $sop = TvriTransmisiSop::findOrFail($id);
        $sop->delete();

        return redirect()->route('tvri.transmisi.manage', ['tab' => 'sop'])
            ->with('success', 'Dokumen / SOP berhasil dihapus.');
    }

    public function bulkDestroySop(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            TvriTransmisiSop::whereIn('id', $ids)->delete();
            return redirect()->route('tvri.transmisi.manage', ['tab' => 'sop'])
                ->with('success', count($ids) . ' Dokumen / SOP berhasil dihapus.');
        }
        return redirect()->route('tvri.transmisi.manage', ['tab' => 'sop'])
            ->with('error', 'Tidak ada SOP yang dipilih.');
    }
}
