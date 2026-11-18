<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Header Banner Khusus Warga -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-2xl p-6 border border-emerald-700/50 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white rounded-xl p-2 flex items-center justify-center shadow-md shrink-0">
                <img src="<?= base_url('images/logo-magelang.svg') ?>" alt="Logo Kabupaten Magelang" class="w-full h-full object-contain">
            </div>
            <div>
                <div class="text-xs font-bold tracking-wider uppercase text-emerald-300 flex items-center gap-1.5">
                    <i class="fa-solid fa-house-user"></i> Portal Pelayanan Warga • Kelurahan Bumirejo
                </div>
                <h1 class="text-xl md:text-2xl font-extrabold text-white mt-0.5">Riwayat & Status Permohonan Surat</h1>
                <p class="text-xs text-slate-300 mt-0.5">
                    Pantau tahapan proses verifikasi, pengesahan Lurah, hingga pengambilan surat Anda
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-3.5 py-2 text-xs font-semibold text-white flex items-center gap-2">
                <i class="fa-solid fa-id-card text-emerald-400"></i>
                <span>NIK: <?= session()->get('nik') ?></span>
            </div>
            <a href="<?= base_url('agenda/create') ?>" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs px-4 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-file-pen"></i> Ajukan Surat Baru
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

    <!-- KPI Tracking Status Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Diajukan -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <div class="text-2xl font-extrabold text-white"><?= number_format($stats['total'] ?? 0) ?></div>
                    <div class="text-[11px] font-medium text-slate-400">Total Permohonan</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
            </div>
            <div class="text-[10px] text-slate-400">Seluruh permohonan Anda</div>
        </div>

        <!-- Sedang Diproses -->
        <div class="bg-slate-900 border border-amber-500/30 rounded-2xl p-4 shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <div class="text-2xl font-extrabold text-amber-400"><?= number_format($stats['proses'] ?? 0) ?></div>
                    <div class="text-[11px] font-medium text-slate-400">Sedang Diproses</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
            <div class="text-[10px] text-amber-300/80">Verifikasi berkas & pembuatan surat</div>
        </div>

        <!-- Siap Diambil -->
        <div class="bg-slate-900 border border-blue-500/30 rounded-2xl p-4 shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <div class="text-2xl font-extrabold text-blue-400"><?= number_format($stats['siapAmbil'] ?? 0) ?></div>
                    <div class="text-[11px] font-medium text-slate-400">Siap Diambil</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-bell"></i>
                </div>
            </div>
            <div class="text-[10px] text-blue-300 font-semibold">Bisa diambil di Kelurahan</div>
        </div>

        <!-- Selesai -->
        <div class="bg-slate-900 border border-emerald-500/30 rounded-2xl p-4 shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <div class="text-2xl font-extrabold text-emerald-400"><?= number_format($stats['selesai'] ?? 0) ?></div>
                    <div class="text-[11px] font-medium text-slate-400">Selesai / Diterima</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-base">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="text-[10px] text-emerald-400">Surat sudah diserahkan</div>
        </div>
    </div>

    <!-- Panduan Alur Pengambilan Surat -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
        <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-3 flex items-center gap-1.5 text-emerald-400">
            <i class="fa-solid fa-circle-info"></i> Tahapan & Petunjuk Pelayanan Surat Kelurahan Bumirejo
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="bg-slate-950 p-3.5 rounded-xl border border-slate-800/80 flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0">1</div>
                <div>
                    <h4 class="text-xs font-bold text-slate-200">Pengajuan Berkas</h4>
                    <p class="text-[11px] text-slate-400 mt-0.5">Warga mengajukan permohonan secara online. NIK otomatis divalidasi ke buku kependudukan Bumirejo.</p>
                </div>
            </div>
            <div class="bg-slate-950 p-3.5 rounded-xl border border-slate-800/80 flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-teal-500/10 text-teal-400 flex items-center justify-center font-bold text-xs shrink-0">2</div>
                <div>
                    <h4 class="text-xs font-bold text-slate-200">Verifikasi & Pengesahan</h4>
                    <p class="text-[11px] text-slate-400 mt-0.5">Admin menyiapkan draft dokumen resmi, kemudian ditandatangani dan disahkan oleh Bapak Lurah.</p>
                </div>
            </div>
            <div class="bg-slate-950 p-3.5 rounded-xl border border-slate-800/80 flex items-start gap-3">
                <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center font-bold text-xs shrink-0">3</div>
                <div>
                    <h4 class="text-xs font-bold text-slate-200">Pengambilan Fisik Surat</h4>
                    <p class="text-[11px] text-slate-400 mt-0.5">Saat status <strong>"Siap Diambil"</strong>, silakan datang ke loket Kelurahan dengan membawa KTP asli & tanda terima.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Permohonan Surat Milik Warga -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 border-b border-slate-800 flex items-center justify-between flex-wrap gap-2">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-emerald-400"></i>
                <h2 class="text-sm font-bold text-white">Daftar Permohonan Surat Anda</h2>
                <span class="bg-slate-800 text-slate-400 text-[11px] font-semibold px-2.5 py-0.5 rounded-full ml-1">
                    <?= count($daftarSurat) ?> Berkas
                </span>
            </div>
            <div class="text-xs text-slate-400">
                Nama Pemohon: <strong class="text-white"><?= session()->get('nama') ?></strong>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/70 border-b border-slate-800 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nomor Register</th>
                        <th class="py-3.5 px-4">Tanggal Pengajuan</th>
                        <th class="py-3.5 px-4">Jenis Surat</th>
                        <th class="py-3.5 px-4">Keperluan Permohonan</th>
                        <th class="py-3.5 px-4 text-center">Status Proses</th>
                        <th class="py-3.5 px-4 text-center">Pengesahan Lurah</th>
                        <th class="py-3.5 px-4 text-center w-36">Tanda Terima</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-xs">
                    <?php if (empty($daftarSurat)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-12 text-slate-500">
                                <i class="fa-solid fa-file-circle-question text-4xl mb-3 text-slate-600 block"></i>
                                Anda belum memiliki riwayat permohonan surat.
                                <div class="mt-2">
                                    <a href="<?= base_url('agenda/create') ?>" class="inline-flex items-center gap-1.5 text-emerald-400 font-semibold hover:underline">
                                        <i class="fa-solid fa-plus"></i> Ajukan Permohonan Surat Sekarang
                                    </a>
                                </div>
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
                                        <?= esc($item['kategori']) ?>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="text-slate-300 truncate max-w-xs" title="<?= esc($item['keterangan']) ?>">
                                        <?= esc($item['keterangan']) ?>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <?php if ($item['status'] === 'Selesai'): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                            <i class="fa-solid fa-circle-check"></i> Selesai Diserahkan
                                        </span>
                                    <?php elseif ($item['status'] === 'Siap Diambil'): ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-500/15 text-blue-400 border border-blue-500/40 animate-pulse">
                                            <i class="fa-solid fa-bell"></i> Siap Diambil
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                            <i class="fa-solid fa-clock"></i> Sedang Diproses
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <?php if (!empty($item['disetujui_oleh'])): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-semibold bg-teal-500/15 text-teal-300 border border-teal-500/30">
                                            <i class="fa-solid fa-stamp text-teal-400"></i> Disahkan Lurah
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                                            <i class="fa-solid fa-clock"></i> Menunggu Tanda Tangan
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="<?= base_url('riwayat/cetak-bukti/' . $item['id']) ?>" target="_blank" class="px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-semibold transition flex items-center gap-1 shadow-md" title="Cetak Bukti Tanda Terima">
                                            <i class="fa-solid fa-print"></i> Cetak Bukti
                                        </a>
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

<?= $this->endSection() ?>
