<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 rounded-2xl p-6 border border-emerald-700/50 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white rounded-xl p-2 flex items-center justify-center shadow-md shrink-0">
                <img src="<?= base_url('images/logo-magelang.svg') ?>" alt="Logo Kabupaten Magelang" class="w-full h-full object-contain">
            </div>
            <div>
                <div class="text-xs font-bold tracking-wider uppercase text-emerald-300">
                    <i class="fa-solid fa-shield-halved mr-1"></i> Modul Administrasi • Kelurahan Bumirejo
                </div>
                <h1 class="text-xl md:text-2xl font-extrabold text-white mt-0.5">Verifikasi & Keabsahan Warga Bumirejo</h1>
                <p class="text-xs text-emerald-200/80 mt-0.5">Sistem otomatis mencocokkan NIK pemohon dengan Buku Induk Kependudukan Kelurahan Bumirejo (Kode Wilayah 330809)</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-3.5 py-2 text-xs font-semibold text-white flex items-center gap-2">
                <i class="fa-regular fa-clock text-emerald-300"></i>
                <span id="liveClockWarga">Loading...</span>
            </div>
            <button onclick="openModalBukuInduk()" class="bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-emerald-500/40 font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-book-atlas"></i> Data Induk Penduduk (<?= count($masterPenduduk) ?>)
            </button>
            <button onclick="openModalTambah()" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs px-4 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-user-plus"></i> Tambah Warga Baru
            </button>
        </div>
    </div>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Warga -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-2xl font-extrabold text-white"><?= number_format($stats['total'] ?? 0) ?></div>
                    <div class="text-xs font-medium text-slate-400 mt-0.5">Akun Warga Terdaftar</div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="text-[11px] text-slate-400 flex items-center gap-1">
                <i class="fa-solid fa-database text-blue-400"></i> Terkoneksi ke sistem surat
            </div>
        </div>

        <!-- Terverifikasi Sah Bumirejo -->
        <div class="bg-slate-900 border border-emerald-500/30 rounded-2xl p-5 shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-2xl font-extrabold text-emerald-400"><?= number_format($stats['terverifikasi'] ?? 0) ?></div>
                    <div class="text-xs font-medium text-slate-400 mt-0.5">Warga Sah Terverifikasi</div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="text-[11px] text-emerald-400 flex items-center gap-1">
                <i class="fa-solid fa-shield-check text-emerald-400"></i> Lolos verifikasi kependudukan
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-slate-900 border border-amber-500/30 rounded-2xl p-5 shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-2xl font-extrabold text-amber-400"><?= number_format($stats['menunggu'] ?? 0) ?></div>
                    <div class="text-xs font-medium text-slate-400 mt-0.5">Menunggu Verifikasi</div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-user-clock"></i>
                </div>
            </div>
            <div class="text-[11px] text-amber-300/80 flex items-center gap-1">
                <i class="fa-solid fa-circle-exclamation text-amber-400"></i> Perlu verifikasi manual admin
            </div>
        </div>

        <!-- Ditolak / Bukan Warga -->
        <div class="bg-slate-900 border border-rose-500/30 rounded-2xl p-5 shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-2xl font-extrabold text-rose-400"><?= number_format($stats['ditolak'] ?? 0) ?></div>
                    <div class="text-xs font-medium text-slate-400 mt-0.5">Ditolak / Nonaktif</div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-ban"></i>
                </div>
            </div>
            <div class="text-[11px] text-rose-400 flex items-center gap-1">
                <i class="fa-solid fa-shield-xmark text-rose-400"></i> Otomatis tolak pengajuan surat
            </div>
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

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-rose-500/10 border border-rose-500 text-rose-300 p-4 rounded-xl text-sm">
            <div class="font-bold flex items-center gap-2 mb-1">
                <i class="fa-solid fa-triangle-exclamation text-rose-400 text-base"></i> Terdapat kesalahan:
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 ml-4">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Filter & Pencarian Warga -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
        <form method="GET" action="<?= base_url('warga') ?>" class="flex flex-col md:flex-row gap-3 items-stretch md:items-center justify-between">
            <div class="flex-1 flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                    <input type="text" name="search" value="<?= esc($filters['search'] ?? '') ?>" placeholder="Cari NIK, Nama Warga, No. HP, Alamat..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-9 pr-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500">
                </div>

                <div class="w-full sm:w-56">
                    <select name="status" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-emerald-500" onchange="this.form.submit()">
                        <option value="">-- Semua Status Verifikasi --</option>
                        <option value="Menunggu Verifikasi" <?= ($filters['status'] ?? '') === 'Menunggu Verifikasi' ? 'selected' : '' ?>>⏳ Menunggu Verifikasi</option>
                        <option value="Terverifikasi" <?= ($filters['status'] ?? '') === 'Terverifikasi' ? 'selected' : '' ?>>✅ Terverifikasi</option>
                        <option value="Ditolak" <?= ($filters['status'] ?? '') === 'Ditolak' ? 'selected' : '' ?>>❌ Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
                <?php if (!empty($filters['search']) || !empty($filters['status'])): ?>
                    <a href="<?= base_url('warga') ?>" class="bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs px-3 py-2.5 rounded-xl transition" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Tabel Data Warga & Status Keabsahan -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 border-b border-slate-800 flex items-center justify-between flex-wrap gap-2">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-id-card-clip text-emerald-400"></i>
                <h2 class="text-sm font-bold text-white">Daftar Akun Warga & Validasi Kependudukan Bumirejo</h2>
                <span class="bg-slate-800 text-slate-400 text-[11px] font-semibold px-2.5 py-0.5 rounded-full ml-1">
                    <?= count($warga) ?> Data
                </span>
            </div>
            <div class="text-xs text-slate-400">
                <i class="fa-solid fa-shield-check text-emerald-400 mr-1"></i> Sistem otomatis mencocokkan NIK dengan Buku Induk Kependudukan Bumirejo.
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/70 border-b border-slate-800 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">NIK (KTP)</th>
                        <th class="py-3.5 px-4">Nama Lengkap & Status Kependudukan</th>
                        <th class="py-3.5 px-4">Kontak & Alamat</th>
                        <th class="py-3.5 px-4 text-center">Status Akun</th>
                        <th class="py-3.5 px-4 text-center">Permohonan Surat</th>
                        <th class="py-3.5 px-4 text-center">Terdaftar</th>
                        <th class="py-3.5 px-4 text-center w-48">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-xs">
                    <?php if (empty($warga)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-12 text-slate-500">
                                <i class="fa-solid fa-users-slash text-4xl mb-3 text-slate-600 block"></i>
                                Tidak ada data warga yang sesuai dengan kriteria pencarian.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($warga as $index => $item): ?>
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4 text-center text-slate-400 font-medium">
                                    <?= $index + 1 ?>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-1.5 font-mono text-emerald-400 font-semibold bg-emerald-950/40 border border-emerald-900/50 px-2 py-1 rounded-md w-fit">
                                        <i class="fa-solid fa-id-card text-[10px] text-emerald-500"></i>
                                        <span><?= esc($item['nik']) ?></span>
                                    </div>
                                    <div class="text-[10px] text-slate-500 mt-1">
                                        <?php if (str_starts_with($item['nik'], '330809')): ?>
                                            <span class="text-emerald-500 font-semibold"><i class="fa-solid fa-location-dot"></i> Wilayah Kec. Mungkid</span>
                                        <?php else: ?>
                                            <span class="text-rose-400 font-semibold"><i class="fa-solid fa-triangle-exclamation"></i> Luar Wilayah</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-start gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-slate-800 text-slate-300 font-bold flex items-center justify-center shrink-0 border border-slate-700 text-xs mt-0.5">
                                            <?= strtoupper(substr($item['nama'], 0, 2)) ?>
                                        </div>
                                        <div>
                                            <div class="font-bold text-white">
                                                <?= esc($item['nama']) ?>
                                            </div>

                                            <!-- Indikator Keaslian Warga Bumirejo -->
                                            <?php if (!empty($item['validasi_kependudukan']) && $item['validasi_kependudukan']['valid']): ?>
                                                <div class="inline-flex items-center gap-1.5 text-[10px] text-emerald-300 bg-emerald-950/80 border border-emerald-800/80 px-2 py-0.5 rounded-md mt-1">
                                                    <i class="fa-solid fa-house-chimney text-emerald-400"></i>
                                                    <span><strong>Warga Sah:</strong> RT <?= $item['validasi_kependudukan']['data']['rt'] ?> / RW <?= $item['validasi_kependudukan']['data']['rw'] ?> (Dusun <?= esc($item['validasi_kependudukan']['data']['dusun']) ?>)</span>
                                                </div>
                                            <?php else: ?>
                                                <div class="inline-flex items-center gap-1.5 text-[10px] text-rose-300 bg-rose-950/80 border border-rose-800/80 px-2 py-0.5 rounded-md mt-1" title="<?= esc($item['validasi_kependudukan']['alasan'] ?? 'Tidak terdaftar') ?>">
                                                    <i class="fa-solid fa-triangle-exclamation text-rose-400"></i>
                                                    <span><strong>Bukan Warga Bumirejo:</strong> Data tidak ditemukan di buku induk</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <?php if (!empty($item['no_hp'])): ?>
                                        <div class="flex items-center gap-1 text-slate-300">
                                            <i class="fa-brands fa-whatsapp text-emerald-400 text-xs"></i>
                                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $item['no_hp']) ?>" target="_blank" class="hover:underline">
                                                <?= esc($item['no_hp']) ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-slate-500 italic text-[11px]">- Kontak belum diisi -</span>
                                    <?php endif; ?>

                                    <?php if (!empty($item['alamat'])): ?>
                                        <div class="text-slate-400 text-[11px] mt-0.5 truncate max-w-xs" title="<?= esc($item['alamat']) ?>">
                                            <i class="fa-solid fa-location-dot text-[10px] text-slate-500 mr-1"></i><?= esc($item['alamat']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <?php if ($item['status_verifikasi'] === 'Terverifikasi'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                            <i class="fa-solid fa-circle-check text-[10px]"></i> Terverifikasi
                                        </span>
                                    <?php elseif ($item['status_verifikasi'] === 'Menunggu Verifikasi'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30 animate-pulse">
                                            <i class="fa-solid fa-clock text-[10px]"></i> Menunggu
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/30">
                                            <i class="fa-solid fa-ban text-[10px]"></i> Ditolak
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-block bg-slate-800 text-slate-300 font-bold px-2 py-0.5 rounded text-xs border border-slate-700">
                                        <?= $item['total_surat'] ?? 0 ?> Surat
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center text-slate-400 text-[11px]">
                                    <?= !empty($item['created_at']) ? date('d/m/Y', strtotime($item['created_at'])) : '-' ?>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                        <?php if ($item['status_verifikasi'] !== 'Terverifikasi'): ?>
                                            <button onclick="ubahStatus(<?= $item['id'] ?>, 'Terverifikasi', '<?= esc($item['nama']) ?>', <?= ($item['validasi_kependudukan']['valid'] ?? false) ? 'true' : 'false' ?>)" class="px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500 hover:text-slate-950 border border-emerald-500/40 text-[11px] font-bold transition flex items-center gap-1 cursor-pointer" title="Setujui Verifikasi">
                                                <i class="fa-solid fa-check"></i> Setujui
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($item['status_verifikasi'] !== 'Ditolak'): ?>
                                            <button onclick="ubahStatus(<?= $item['id'] ?>, 'Ditolak', '<?= esc($item['nama']) ?>', true)" class="px-2.5 py-1 rounded-lg bg-rose-500/15 text-rose-400 hover:bg-rose-500 hover:text-white border border-rose-500/30 text-[11px] font-medium transition flex items-center gap-1 cursor-pointer" title="Tolak Akun">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </button>
                                        <?php endif; ?>

                                        <!-- Edit Modal Button -->
                                        <button onclick='openModalEdit(<?= json_encode($item) ?>)' class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-400 hover:bg-amber-500 hover:text-slate-950 flex items-center justify-center transition text-xs cursor-pointer" title="Edit Data Warga">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <!-- Reset Password Button -->
                                        <button onclick="konfirmasiReset(<?= $item['id'] ?>, '<?= esc($item['nama']) ?>', '<?= esc($item['nik']) ?>')" class="w-7 h-7 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white flex items-center justify-center transition text-xs cursor-pointer" title="Reset Password">
                                            <i class="fa-solid fa-key"></i>
                                        </button>

                                        <!-- Hapus Button -->
                                        <button onclick="konfirmasiHapus(<?= $item['id'] ?>, '<?= esc($item['nama']) ?>')" class="w-7 h-7 rounded-lg bg-slate-800 text-slate-400 hover:bg-rose-600 hover:text-white flex items-center justify-center transition text-xs cursor-pointer" title="Hapus Akun">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
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

<!-- MODAL BUKU INDUK PENDUDUK BUMIREJO -->
<div id="modalBukuInduk" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-4xl shadow-2xl overflow-hidden flex flex-col max-h-[85vh]">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                    <i class="fa-solid fa-book-atlas text-base"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">Buku Induk Kependudukan Kelurahan Bumirejo</h3>
                    <p class="text-[11px] text-slate-400">Master database warga resmi yang berhak mengajukan surat (Kode Wilayah: 330809)</p>
                </div>
            </div>
            <button onclick="closeModalBukuInduk()" class="text-slate-400 hover:text-white text-lg cursor-pointer">&times;</button>
        </div>

        <div class="overflow-y-auto p-5 flex-1">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-950 border-b border-slate-800 text-[11px] font-semibold text-slate-400 uppercase">
                        <th class="py-2.5 px-3">No</th>
                        <th class="py-2.5 px-3">NIK (16 Digit)</th>
                        <th class="py-2.5 px-3">Nama Lengkap</th>
                        <th class="py-2.5 px-3">RT / RW</th>
                        <th class="py-2.5 px-3">Dusun</th>
                        <th class="py-2.5 px-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php foreach ($masterPenduduk as $i => $p): ?>
                        <tr class="hover:bg-slate-800/40">
                            <td class="py-2.5 px-3 text-slate-400"><?= $i + 1 ?></td>
                            <td class="py-2.5 px-3 font-mono text-emerald-400 font-semibold"><?= esc($p['nik']) ?></td>
                            <td class="py-2.5 px-3 font-bold text-white"><?= esc($p['nama']) ?></td>
                            <td class="py-2.5 px-3 text-slate-300">RT <?= esc($p['rt']) ?> / RW <?= esc($p['rw']) ?></td>
                            <td class="py-2.5 px-3 text-slate-300"><?= esc($p['dusun']) ?></td>
                            <td class="py-2.5 px-3">
                                <span class="bg-emerald-500/10 text-emerald-400 text-[10px] font-semibold px-2 py-0.5 rounded-full border border-emerald-500/30">
                                    Warga Sah Bumirejo
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800 bg-slate-950/60 flex items-center justify-between shrink-0">
            <span class="text-xs text-slate-400">Total: <strong><?= count($masterPenduduk) ?></strong> penduduk sah terdata.</span>
            <button onclick="closeModalBukuInduk()" class="bg-slate-800 hover:bg-slate-700 text-white text-xs px-4 py-2 rounded-xl transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH WARGA BARU (DENGAN AUTO-VALIDASI) -->
<div id="modalTambah" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">Tambah Data & Akun Warga</h3>
                    <p class="text-[10px] text-slate-400">Sistem memverifikasi NIK secara otomatis ke data kependudukan</p>
                </div>
            </div>
            <button onclick="closeModalTambah()" class="text-slate-400 hover:text-white text-lg cursor-pointer">&times;</button>
        </div>

        <form action="<?= base_url('warga/store') ?>" method="POST" class="p-5 space-y-4">
            <?= csrf_field() ?>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">
                    NIK Warga (16 Digit) <span class="text-rose-400">*</span>
                </label>
                <div class="relative">
                    <input type="text" name="nik" id="inputNikTambah" maxlength="16" required placeholder="Contoh: 3308092408990001" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 font-mono">
                    <span id="loadingCekNik" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                        <i class="fa-solid fa-spinner fa-spin"></i>
                    </span>
                </div>
                <!-- Box Status Validasi Otomatis -->
                <div id="boxStatusNik" class="hidden mt-2 text-xs rounded-xl p-3"></div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Lengkap Warga <span class="text-rose-400">*</span></label>
                <input type="text" name="nama" id="inputNamaTambah" required placeholder="Nama lengkap sesuai KTP" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">No. WhatsApp / HP</label>
                    <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Status Verifikasi</label>
                    <input type="text" readonly value="Terverifikasi (Otomatis)" class="w-full bg-slate-950 border border-emerald-500/30 rounded-xl px-3.5 py-2.5 text-xs text-emerald-400 font-semibold cursor-not-allowed">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Alamat Domisili Warga</label>
                <textarea name="alamat" id="inputAlamatTambah" rows="2" placeholder="Kosongkan jika ingin otomatis sesuai buku induk RT/RW Dusun..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Password Akun <span class="text-rose-400">*</span></label>
                <input type="text" name="password" id="tambahPassword" value="warga123" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 font-mono">
                <span class="text-[11px] text-slate-500 mt-0.5 block">Password bawaan: <code class="text-emerald-400">warga123</code></span>
            </div>

            <div class="pt-2 flex items-center justify-end gap-2 border-t border-slate-800">
                <button type="button" onclick="closeModalTambah()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs px-4 py-2.5 rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" id="btnSubmitTambah" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-save"></i> Verifikasi & Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT DATA WARGA -->
<div id="modalEdit" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center">
                    <i class="fa-solid fa-user-pen"></i>
                </div>
                <h3 class="text-base font-bold text-white">Edit Data Warga</h3>
            </div>
            <button onclick="closeModalEdit()" class="text-slate-400 hover:text-white text-lg cursor-pointer">&times;</button>
        </div>

        <form id="formEditWarga" action="" method="POST" class="p-5 space-y-4">
            <?= csrf_field() ?>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" name="nik" id="editNik" maxlength="16" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-emerald-500 font-mono">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" id="editNama" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">No. WhatsApp / HP</label>
                    <input type="text" name="no_hp" id="editNoHp" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Status Verifikasi</label>
                    <select name="status_verifikasi" id="editStatusVerifikasi" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-emerald-500">
                        <option value="Terverifikasi">✅ Terverifikasi</option>
                        <option value="Menunggu Verifikasi">⏳ Menunggu Verifikasi</option>
                        <option value="Ditolak">❌ Ditolak</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Alamat Domisili Warga</label>
                <textarea name="alamat" id="editAlamat" rows="2" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-emerald-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Ganti Password (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500">
            </div>

            <div class="pt-2 flex items-center justify-end gap-2 border-t border-slate-800">
                <button type="button" onclick="closeModalEdit()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs px-4 py-2.5 rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="bg-amber-600 hover:bg-amber-500 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-save"></i> Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const el = document.getElementById('liveClockWarga');
        if (el) el.innerText = now.toLocaleDateString('id-ID', options) + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Modal Buku Induk
    function openModalBukuInduk() {
        document.getElementById('modalBukuInduk').classList.remove('hidden');
    }
    function closeModalBukuInduk() {
        document.getElementById('modalBukuInduk').classList.add('hidden');
    }

    // Modal Tambah
    function openModalTambah() {
        document.getElementById('modalTambah').classList.remove('hidden');
    }
    function closeModalTambah() {
        document.getElementById('modalTambah').classList.add('hidden');
    }

    // Modal Edit
    function openModalEdit(data) {
        document.getElementById('editNik').value = data.nik || '';
        document.getElementById('editNama').value = data.nama || '';
        document.getElementById('editNoHp').value = data.no_hp || '';
        document.getElementById('editAlamat').value = data.alamat || '';
        document.getElementById('editStatusVerifikasi').value = data.status_verifikasi || 'Terverifikasi';
        document.getElementById('formEditWarga').action = '<?= base_url('warga/update/') ?>' + data.id;
        document.getElementById('modalEdit').classList.remove('hidden');
    }
    function closeModalEdit() {
        document.getElementById('modalEdit').classList.add('hidden');
    }

    // Live NIK Verification di Modal Tambah Warga
    const inputNik = document.getElementById('inputNikTambah');
    const boxStatus = document.getElementById('boxStatusNik');
    const inputNama = document.getElementById('inputNamaTambah');
    const inputAlamat = document.getElementById('inputAlamatTambah');
    const btnSubmit = document.getElementById('btnSubmitTambah');
    const loadingEl = document.getElementById('loadingCekNik');

    if (inputNik) {
        inputNik.addEventListener('input', function() {
            const nik = this.value.trim().replace(/\D/g, '');
            this.value = nik;

            if (nik.length === 16) {
                loadingEl.classList.remove('hidden');
                boxStatus.classList.remove('hidden');
                boxStatus.className = 'mt-2 text-xs rounded-xl p-3 bg-slate-950 text-slate-400 border border-slate-800';
                boxStatus.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Mencocokkan dengan Buku Induk Penduduk Kelurahan Bumirejo...';

                fetch('<?= base_url('api/cek-nik/') ?>' + nik)
                    .then(res => res.json())
                    .then(data => {
                        loadingEl.classList.add('hidden');
                        if (data.valid) {
                            boxStatus.className = 'mt-2 text-xs rounded-xl p-3 bg-emerald-500/10 border border-emerald-500 text-emerald-300';
                            boxStatus.innerHTML = `
                                <div class="font-bold flex items-center gap-1.5 text-emerald-400">
                                    <i class="fa-solid fa-circle-check"></i> Warga Sah Kelurahan Bumirejo Terverifikasi!
                                </div>
                                <div class="mt-1 text-[11px] text-slate-300">
                                    Nama: <strong>${data.data.nama}</strong> | RT ${data.data.rt} / RW ${data.data.rw}, Dusun ${data.data.dusun}
                                </div>
                            `;
                            if (!inputNama.value) inputNama.value = data.data.nama;
                            if (!inputAlamat.value) inputAlamat.value = `RT ${data.data.rt} / RW ${data.data.rw}, Dusun ${data.data.dusun}, Kelurahan Bumirejo`;
                            btnSubmit.disabled = false;
                            btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                        } else {
                            boxStatus.className = 'mt-2 text-xs rounded-xl p-3 bg-rose-500/10 border border-rose-500 text-rose-300';
                            boxStatus.innerHTML = `
                                <div class="font-bold flex items-center gap-1.5 text-rose-400">
                                    <i class="fa-solid fa-triangle-exclamation"></i> DITOLAK OTOMATIS: BUKAN WARGA BUMIREJO
                                </div>
                                <div class="mt-1 text-[11px] text-rose-200">
                                    ${data.alasan}
                                </div>
                            `;
                            btnSubmit.disabled = true;
                            btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    })
                    .catch(() => {
                        loadingEl.classList.add('hidden');
                    });
            } else if (nik.length > 0 && nik.length < 16) {
                boxStatus.classList.remove('hidden');
                boxStatus.className = 'mt-2 text-xs rounded-xl p-2 bg-slate-950 text-slate-400 border border-slate-800';
                boxStatus.innerText = `Masukkan 16 digit NIK (${nik.length}/16 digit)`;
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                boxStatus.classList.add('hidden');
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });
    }

    // Ubah Status Verifikasi AJAX
    function ubahStatus(id, statusBaru, nama, isSah) {
        if (statusBaru === 'Terverifikasi' && !isSah) {
            Swal.fire({
                title: 'Tidak Dapat Disetujui!',
                html: `Akun <b>${nama}</b> bukan warga sah Kelurahan Bumirejo (tidak terdaftar di Buku Induk Penduduk). Sistem melarang persetujuan untuk mencegah penyalahgunaan surat.`,
                icon: 'error',
                background: '#0f172a',
                color: '#ffffff',
                confirmButtonColor: '#ef4444'
            });
            return;
        }

        const aksi = statusBaru === 'Terverifikasi' ? 'menyetujui' : 'menolak';
        const color = statusBaru === 'Terverifikasi' ? '#10b981' : '#f43f5e';

        Swal.fire({
            title: statusBaru === 'Terverifikasi' ? 'Setujui Verifikasi?' : 'Tolak Akun Warga?',
            html: `Apakah Anda yakin ingin <b>${aksi}</b> akun warga <b>${nama}</b>?`,
            icon: statusBaru === 'Terverifikasi' ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonColor: color,
            cancelButtonColor: '#475569',
            confirmButtonText: statusBaru === 'Terverifikasi' ? 'Ya, Setujui!' : 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            background: '#0f172a',
            color: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('status_verifikasi', statusBaru);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                fetch('<?= base_url('warga/update-status/') ?>' + id, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil!',
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
                            title: 'Ditolak Sistem!',
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

    // Reset Password
    function konfirmasiReset(id, nama, nik) {
        const defaultPwd = 'warga' + (nik.length >= 4 ? nik.slice(-4) : '123');
        Swal.fire({
            title: 'Reset Password Warga?',
            html: `Password untuk <b>${nama}</b> akan direset ke default: <code class="text-emerald-400 bg-slate-800 px-2 py-0.5 rounded">${defaultPwd}</code>`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Ya, Reset Password!',
            cancelButtonText: 'Batal',
            background: '#0f172a',
            color: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('warga/reset-password/') ?>' + id;
            }
        });
    }

    // Hapus Warga
    function konfirmasiHapus(id, nama) {
        Swal.fire({
            title: 'Hapus Akun Warga?',
            html: `Data akun warga <b>${nama}</b> akan dihapus secara permanen dari sistem.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#0f172a',
            color: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('warga/delete/') ?>' + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>
