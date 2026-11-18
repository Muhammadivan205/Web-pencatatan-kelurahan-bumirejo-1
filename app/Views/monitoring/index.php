<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="space-y-6">
    <!-- Executive Header Banner -->
    <div class="bg-gradient-to-r from-emerald-950 via-teal-900 to-slate-900 rounded-2xl p-6 border border-emerald-700/50 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white rounded-xl p-2 flex items-center justify-center shadow-md shrink-0">
                <img src="<?= base_url('images/logo-magelang.svg') ?>" alt="Logo Kabupaten Magelang" class="w-full h-full object-contain">
            </div>
            <div>
                <div class="text-xs font-bold tracking-wider uppercase text-emerald-300 flex items-center gap-1.5">
                    <i class="fa-solid fa-stamp"></i> Dashboard Eksekutif Pejabat • Kelurahan Bumirejo
                </div>
                <h1 class="text-xl md:text-2xl font-extrabold text-white mt-0.5">Monitoring & Laporan Pelayanan Surat</h1>
                <p class="text-xs text-slate-300 mt-0.5">
                    Monitoring rekapitulasi surat warga dan lembar pengesahan tanda tangan Bapak Lurah
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-3.5 py-2 text-xs font-semibold text-white flex items-center gap-2">
                <i class="fa-solid fa-user-tie text-emerald-400"></i>
                <span><?= session()->get('nama') ?></span>
            </div>
            <a href="<?= base_url('monitoring/cetak?' . http_build_query($filters ?? [])) ?>" target="_blank" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs px-4 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-print"></i> Cetak Laporan Resmi
            </a>
            <a href="<?= base_url('agenda') ?>" class="bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5">
                <i class="fa-solid fa-book-open text-emerald-400"></i> Buku Agenda
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-emerald-500/10 border border-emerald-500 text-emerald-300 p-4 rounded-xl text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-rose-500/10 border border-rose-500 text-rose-300 p-4 rounded-xl text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-400 text-base"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-white">&times;</button>
        </div>
    <?php endif; ?>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total Surat -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <div class="text-2xl font-extrabold text-white"><?= number_format($stats['total'] ?? 0) ?></div>
                    <div class="text-[11px] font-medium text-slate-400">Total Permohonan</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
            </div>
            <div class="text-[10px] text-slate-400">Pada periode terpilih</div>
        </div>

        <!-- Selesai Diserahkan -->
        <div class="bg-slate-900 border border-emerald-500/30 rounded-2xl p-4 shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <div class="text-2xl font-extrabold text-emerald-400"><?= number_format($stats['selesai'] ?? 0) ?></div>
                    <div class="text-[11px] font-medium text-slate-400">Selesai & Diserahkan</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="text-[10px] text-emerald-400">Surat telah diterima warga</div>
        </div>

        <!-- Sedang Diproses -->
        <div class="bg-slate-900 border border-amber-500/30 rounded-2xl p-4 shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <div class="text-2xl font-extrabold text-amber-400"><?= number_format($stats['proses'] ?? 0) ?></div>
                    <div class="text-[11px] font-medium text-slate-400">Sedang Diproses</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
            </div>
            <div class="text-[10px] text-amber-300/80">Verifikasi berkas oleh admin</div>
        </div>

        <!-- Disahkan Lurah -->
        <div class="bg-slate-900 border border-teal-500/30 rounded-2xl p-4 shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <div class="text-2xl font-extrabold text-teal-400"><?= number_format($stats['sudahDisetujui'] ?? 0) ?></div>
                    <div class="text-[11px] font-medium text-slate-400">Telah Disahkan Lurah</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-stamp"></i>
                </div>
            </div>
            <div class="text-[10px] text-teal-400"><?= $stats['persenDisetujui'] ?>% dari total surat</div>
        </div>

        <!-- Menunggu Pengesahan -->
        <div class="bg-slate-900 border border-rose-500/30 rounded-2xl p-4 shadow-lg relative overflow-hidden">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <div class="text-2xl font-extrabold text-rose-400"><?= number_format($stats['belumDisetujui'] ?? 0) ?></div>
                    <div class="text-[11px] font-medium text-slate-400">Perlu Pengesahan</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-signature"></i>
                </div>
            </div>
            <div class="text-[10px] text-rose-300">Menunggu tanda tangan Lurah</div>
        </div>
    </div>

    <!-- Filter & Rentang Periode Monitoring -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
        <form method="GET" action="<?= base_url('monitoring') ?>" class="space-y-4">
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
                <!-- Preset Shortcut Periode -->
                <div class="flex flex-wrap items-center gap-1.5">
                    <span class="text-xs font-semibold text-slate-400 mr-1"><i class="fa-solid fa-calendar-days text-emerald-400 mr-1"></i> Periode Cepat:</span>
                    <a href="<?= base_url('monitoring?periode=bulan_ini') ?>" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition <?= ($filters['periode'] ?? '') === 'bulan_ini' ? 'bg-emerald-500 text-slate-950 shadow-md' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' ?>">
                        Bulan Ini
                    </a>
                    <a href="<?= base_url('monitoring?periode=triwulan') ?>" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition <?= ($filters['periode'] ?? '') === 'triwulan' ? 'bg-emerald-500 text-slate-950 shadow-md' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' ?>">
                        3 Bulan Terakhir
                    </a>
                    <a href="<?= base_url('monitoring?periode=tahun_ini') ?>" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition <?= ($filters['periode'] ?? '') === 'tahun_ini' ? 'bg-emerald-500 text-slate-950 shadow-md' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' ?>">
                        Tahun 2026
                    </a>
                    <a href="<?= base_url('monitoring?periode=semua') ?>" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition <?= ($filters['periode'] ?? '') === 'semua' ? 'bg-emerald-500 text-slate-950 shadow-md' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' ?>">
                        Semua Waktu
                    </a>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-filter"></i> Terapkan Filter
                    </button>
                    <a href="<?= base_url('monitoring') ?>" class="bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs px-3 py-2 rounded-xl transition" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-3 border-t border-slate-800">
                <!-- Tanggal Mulai -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Dari Tanggal</label>
                    <input type="date" name="tgl_awal" value="<?= esc($filters['tgl_awal'] ?? '') ?>" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                </div>

                <!-- Tanggal Sampai -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Sampai Tanggal</label>
                    <input type="date" name="tgl_akhir" value="<?= esc($filters['tgl_akhir'] ?? '') ?>" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                </div>

                <!-- Filter Kategori -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Jenis Surat</label>
                    <select name="kategori" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                        <option value="">-- Semua Kategori Surat --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= esc($cat) ?>" <?= ($filters['kategori'] ?? '') === $cat ? 'selected' : '' ?>><?= esc($cat) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Filter Persetujuan -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-400 mb-1">Status Pengesahan Lurah</label>
                    <select name="persetujuan" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                        <option value="">-- Semua Status Pengesahan --</option>
                        <option value="belum" <?= ($filters['persetujuan'] ?? '') === 'belum' ? 'selected' : '' ?>>⏳ Belum Disahkan (Perlu Tanda Tangan)</option>
                        <option value="sudah" <?= ($filters['persetujuan'] ?? '') === 'sudah' ? 'selected' : '' ?>>✅ Sudah Disahkan Lurah</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <!-- Visual Breakdown Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Breakdown per Jenis Surat -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-chart-column text-emerald-400"></i>
                    <h3 class="text-sm font-bold text-white">Distribusi Surat Terpopuler</h3>
                </div>
                <span class="text-xs text-slate-400"><?= count($kategoriCount) ?> Kategori</span>
            </div>

            <?php if (empty($kategoriCount)): ?>
                <div class="text-center py-8 text-slate-500 text-xs">Belum ada data surat pada periode ini.</div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php 
                    $maxVal = max($kategoriCount) ?: 1;
                    $topIdx = 0;
                    foreach ($kategoriCount as $katNama => $jml): 
                        if ($topIdx++ >= 6) break;
                        $pct = $stats['total'] > 0 ? round(($jml / $stats['total']) * 100) : 0;
                    ?>
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-semibold text-slate-300 truncate max-w-xs"><?= esc($katNama) ?></span>
                                <span class="font-bold text-emerald-400"><?= $jml ?> berkas <span class="text-[10px] text-slate-500 font-normal">(<?= $pct ?>%)</span></span>
                            </div>
                            <div class="w-full bg-slate-950 rounded-full h-2 overflow-hidden border border-slate-800">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-2 rounded-full" style="width: <?= $pct ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Efektivitas Pelayanan & Pengesahan -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-gauge-high text-teal-400"></i>
                        <h3 class="text-sm font-bold text-white">Efektivitas Pelayanan & Disposisi</h3>
                    </div>
                    <span class="text-xs text-emerald-400 font-bold"><?= $stats['persenEfektivitas'] ?>% Selesai</span>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="bg-slate-950 p-3.5 rounded-xl border border-slate-800 text-center">
                        <div class="text-2xl font-black text-emerald-400"><?= $stats['persenEfektivitas'] ?>%</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Tingkat Penyelesaian</div>
                    </div>
                    <div class="bg-slate-950 p-3.5 rounded-xl border border-slate-800 text-center">
                        <div class="text-2xl font-black text-teal-400"><?= $stats['persenDisetujui'] ?>%</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Tingkat Pengesahan</div>
                    </div>
                </div>

                <div class="text-xs text-slate-400 leading-relaxed bg-slate-950/60 p-3.5 rounded-xl border border-slate-800/80">
                    <p class="font-semibold text-slate-300 mb-1"><i class="fa-solid fa-circle-info text-emerald-400 mr-1"></i> Catatan Pelayanan Kantor Kelurahan Bumirejo:</p>
                    Lurah dan perangkat kelurahan memantau kelancaran penerbitan surat warga. Pengesahan surat secara digital memastikan bahwa surat telah melewati verifikasi kependudukan dan berhak diterbitkan.
                </div>
            </div>

            <div class="pt-4 mt-2 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
                <span>Pejabat Penandatangan: <strong>Muhammad Nur (Lurah Bumirejo)</strong></span>
                <span class="text-emerald-400"><i class="fa-solid fa-check-double mr-1"></i> Siap Cetak Laporan</span>
            </div>
        </div>
    </div>

    <!-- Tabel Rekapitulasi Pelayanan Surat & Lembar Pengesahan -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 border-b border-slate-800 flex items-center justify-between flex-wrap gap-2">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-list-check text-emerald-400"></i>
                <h2 class="text-sm font-bold text-white">Lembar Rekapitulasi & Pengesahan Surat</h2>
                <span class="bg-slate-800 text-slate-400 text-[11px] font-semibold px-2.5 py-0.5 rounded-full ml-1">
                    <?= count($daftarSurat) ?> Berkas
                </span>
            </div>
            <div class="text-xs text-slate-400">
                Klik tombol <strong class="text-emerald-400">Sahkan Surat</strong> untuk memberikan pengesahan resmi Lurah.
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/70 border-b border-slate-800 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nomor Register</th>
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4">Nama Pemohon & NIK</th>
                        <th class="py-3.5 px-4">Jenis Surat</th>
                        <th class="py-3.5 px-4 text-center">Status Surat</th>
                        <th class="py-3.5 px-4 text-center">Pengesahan Lurah</th>
                        <th class="py-3.5 px-4 text-center w-36">Aksi Pejabat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-xs">
                    <?php if (empty($daftarSurat)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-12 text-slate-500">
                                <i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-600 block"></i>
                                Tidak ada data permohonan surat pada filter yang dipilih.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarSurat as $i => $item): ?>
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4 text-center text-slate-400 font-medium">
                                    <?= $i + 1 ?>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-mono text-emerald-400 font-semibold bg-emerald-950/40 border border-emerald-900/50 px-2 py-0.5 rounded w-fit text-[11px]">
                                        <?= esc($item['nomor_agenda']) ?>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-slate-300 whitespace-nowrap">
                                    <i class="fa-regular fa-calendar text-slate-500 mr-1"></i>
                                    <?= date('d/m/Y', strtotime($item['tanggal'])) ?>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-white">
                                        <?= esc($item['nama']) ?>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-mono mt-0.5">
                                        NIK: <?= esc($item['instansi']) ?>
                                    </div>
                                    <div class="text-[10px] text-slate-500 truncate max-w-xs">
                                        <?= esc($item['alamat']) ?>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-block bg-slate-800 text-slate-200 font-semibold px-2 py-1 rounded text-[11px] border border-slate-700">
                                        <?= esc($item['kategori']) ?>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <?php if ($item['status'] === 'Selesai'): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                            <i class="fa-solid fa-circle-check"></i> Selesai
                                        </span>
                                    <?php elseif ($item['status'] === 'Siap Diambil'): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/30">
                                            <i class="fa-solid fa-paper-plane"></i> Siap Diambil
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                            <i class="fa-solid fa-clock"></i> Diproses
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <?php if (!empty($item['disetujui_oleh'])): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[10px] font-semibold bg-teal-500/15 text-teal-300 border border-teal-500/30">
                                            <i class="fa-solid fa-stamp text-teal-400"></i> Disahkan: <?= esc($item['disetujui_oleh']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[10px] font-semibold bg-rose-500/10 text-rose-300 border border-rose-500/30">
                                            <i class="fa-solid fa-clock"></i> Belum Disahkan
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <?php if (empty($item['disetujui_oleh'])): ?>
                                            <button onclick="sahkanSurat(<?= $item['id'] ?>, '<?= esc($item['nomor_agenda']) ?>', '<?= esc($item['nama']) ?>')" class="px-2.5 py-1 rounded-lg bg-teal-600 hover:bg-teal-500 text-white text-[11px] font-bold transition flex items-center gap-1 shadow-md cursor-pointer" title="Sahkan Surat">
                                                <i class="fa-solid fa-stamp"></i> Sahkan
                                            </button>
                                        <?php else: ?>
                                            <button onclick="batalSahkanSurat(<?= $item['id'] ?>, '<?= esc($item['nomor_agenda']) ?>')" class="px-2 py-1 rounded-lg bg-slate-800 hover:bg-rose-900/60 text-slate-400 hover:text-rose-300 text-[10px] transition cursor-pointer" title="Batalkan Pengesahan">
                                                <i class="fa-solid fa-rotate-left"></i> Batal
                                            </button>
                                        <?php endif; ?>

                                        <a href="<?= base_url('agenda/detail-view/' . $item['id']) ?>" class="w-7 h-7 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 flex items-center justify-center transition text-xs" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SweetAlert2 Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function sahkanSurat(id, noAgenda, nama) {
        Swal.fire({
            title: 'Sahkan Permohonan Surat?',
            html: `Dengan mengklik setuju, Anda memberikan pengesahan resmi selaku <b>Bapak Lurah</b> untuk permohonan surat <b>${noAgenda}</b> a.n. <b>${nama}</b>.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0f766e',
            cancelButtonColor: '#475569',
            confirmButtonText: '<i class="fa-solid fa-stamp mr-1"></i> Ya, Sahkan Surat!',
            cancelButtonText: 'Batal',
            background: '#0f172a',
            color: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= base_url('monitoring/sahkan/') ?>' + id, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Resmi Disahkan!',
                            text: data.message,
                            icon: 'success',
                            background: '#0f172a',
                            color: '#ffffff',
                            confirmButtonColor: '#10b981'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: data.message,
                            icon: 'error',
                            background: '#0f172a',
                            color: '#ffffff'
                        });
                    }
                })
                .catch(() => {
                    window.location.reload();
                });
            }
        });
    }

    function batalSahkanSurat(id, noAgenda) {
        Swal.fire({
            title: 'Batalkan Pengesahan?',
            html: `Apakah Anda ingin membatalkan pengesahan untuk surat <b>${noAgenda}</b>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Tutup',
            background: '#0f172a',
            color: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('monitoring/batal-sahkan/') ?>' + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>
