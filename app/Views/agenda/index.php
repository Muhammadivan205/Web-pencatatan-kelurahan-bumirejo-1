<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="space-y-6">
    <!-- Executive Header Banner -->
    <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 rounded-2xl p-6 border border-emerald-700/50 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white rounded-xl p-2 flex items-center justify-center shadow-md shrink-0">
                <img src="<?= base_url('images/logo-magelang.svg') ?>" alt="Logo Kabupaten Magelang" class="w-full h-full object-contain">
            </div>
            <div>
                <div class="text-xs font-bold tracking-wider uppercase text-emerald-300">
                    <i class="fa-solid fa-landmark mr-1"></i> Pemerintah Kabupaten Magelang • Kec. Mungkid • Kel. Bumirejo
                </div>
                <h1 class="text-xl md:text-2xl font-extrabold text-white mt-0.5">Buku Pencatatan Pelayanan Surat Warga</h1>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-3.5 py-2 text-xs font-semibold text-white flex items-center gap-2">
                <i class="fa-regular fa-clock text-emerald-300"></i>
                <span id="liveClock">Loading...</span>
            </div>
            <?php if (in_array(session()->get('role'), ['admin', 'warga'])): ?>
                <a href="<?= base_url('agenda/tambah') ?>" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs px-4 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5">
                    <i class="fa-solid fa-file-pen"></i> Form Input
                </a>
            <?php endif; ?>
            <a href="<?= base_url('agenda/print?' . http_build_query($filters ?? [])) ?>" target="_blank" class="bg-slate-800 hover:bg-slate-700 text-white border border-slate-600 font-semibold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5">
                <i class="fa-solid fa-print text-emerald-400"></i> Cetak Register
            </a>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Surat -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-2xl font-extrabold text-white"><?= number_format($stats['total'] ?? 0) ?></div>
                    <div class="text-xs font-medium text-slate-400 mt-0.5">Total Surat Dicatat</div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
            </div>
            <div class="text-[11px] font-semibold text-slate-500">
                <i class="fa-solid fa-database mr-1 text-emerald-500"></i> Register Pelayanan Aktif
            </div>
        </div>

        <!-- Hari Ini -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-2xl font-extrabold text-white"><?= number_format($stats['today'] ?? 0) ?></div>
                    <div class="text-xs font-medium text-slate-400 mt-0.5">Permohonan Hari Ini</div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
            </div>
            <div class="text-[11px] font-semibold text-slate-500">
                <i class="fa-solid fa-clock mr-1 text-blue-400"></i> <?= date('d M Y') ?>
            </div>
        </div>

        <!-- Sedang Diproses -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <div class="text-2xl font-extrabold text-white"><?= number_format(($stats['proses'] ?? 0) + ($stats['siapAmbil'] ?? 0)) ?></div>
                    <div class="text-xs font-medium text-slate-400 mt-0.5">Sedang Diproses / Siap</div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
            <div class="text-[11px] font-semibold text-slate-500 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span> Menunggu Penyerahan Warga
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <div class="text-2xl font-extrabold text-white"><?= number_format($stats['selesai'] ?? 0) ?></div>
                    <div class="text-xs font-medium text-slate-400 mt-0.5">Surat Selesai Diserahkan</div>
                </div>
                <div class="w-11 h-11 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="w-full bg-slate-800 rounded-full h-1.5 mt-2 overflow-hidden">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: <?= $stats['percentSelesai'] ?? 0 ?>%"></div>
            </div>
            <div class="flex justify-between text-[11px] text-slate-400 mt-1">
                <span>Tingkat Efektivitas</span>
                <span class="font-bold text-emerald-400"><?= $stats['percentSelesai'] ?? 0 ?>%</span>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i>
            <span><strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span><strong>Perhatian!</strong> <?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <!-- Main Filter & Table Card -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
        <!-- Filter Bar -->
        <div class="p-5 border-b border-slate-800 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-emerald-400"></i>
                    <h2 class="font-bold text-white text-base">Filter & Pencarian Registrasi Surat</h2>
                </div>
                <div class="flex flex-wrap items-center gap-1.5 text-xs">
                    <span class="text-slate-400 font-semibold mr-1">Shortcut:</span>
                    <a href="<?= base_url('agenda') ?>" class="px-3 py-1 rounded-full border <?= empty($filters['tgl_awal']) ? 'bg-emerald-600 border-emerald-500 text-white' : 'bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700' ?>">Semua</a>
                    <a href="<?= base_url('agenda?tgl_awal=' . date('Y-m-d') . '&tgl_akhir=' . date('Y-m-d')) ?>" class="px-3 py-1 rounded-full border <?= (($filters['tgl_awal'] ?? '') == date('Y-m-d')) ? 'bg-emerald-600 border-emerald-500 text-white' : 'bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700' ?>">Hari Ini</a>
                    <a href="<?= base_url('agenda?tgl_awal=' . date('Y-m-d', strtotime('-7 days')) . '&tgl_akhir=' . date('Y-m-d')) ?>" class="px-3 py-1 rounded-full border bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700">7 Hari Terakhir</a>
                    <a href="<?= base_url('agenda?tgl_awal=' . date('Y-m-01') . '&tgl_akhir=' . date('Y-m-t')) ?>" class="px-3 py-1 rounded-full border bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700">Bulan Ini</a>
                </div>
            </div>

            <form action="<?= base_url('agenda') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3">
                <div class="md:col-span-3">
                    <input type="text" name="search" placeholder="Cari Nomor, NIK, Nama, Alamat..." value="<?= esc($filters['search'] ?? '') ?>" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                </div>
                <div class="md:col-span-3">
                    <select name="kategori" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                        <option value="">-- Semua Jenis Surat --</option>
                        <?php foreach (($categories ?? []) as $cat): ?>
                            <option value="<?= esc($cat) ?>" <?= (($filters['kategori'] ?? '') == $cat) ? 'selected' : '' ?>><?= esc($cat) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <select name="status" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                        <option value="">-- Semua Status --</option>
                        <option value="Selesai" <?= (($filters['status'] ?? '') == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                        <option value="Siap Diambil" <?= (($filters['status'] ?? '') == 'Siap Diambil') ? 'selected' : '' ?>>Siap Diambil</option>
                        <option value="Dalam Proses" <?= (($filters['status'] ?? '') == 'Dalam Proses') ? 'selected' : '' ?>>Dalam Proses</option>
                        <option value="Direncanakan" <?= (($filters['status'] ?? '') == 'Direncanakan') ? 'selected' : '' ?>>Direncanakan</option>
                        <option value="Dibatalkan" <?= (($filters['status'] ?? '') == 'Dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
                    </select>
                </div>
                <div class="md:col-span-3 flex items-center gap-1.5">
                    <input type="date" name="tgl_awal" value="<?= esc($filters['tgl_awal'] ?? '') ?>" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-2.5 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                    <span class="text-slate-500">-</span>
                    <input type="date" name="tgl_akhir" value="<?= esc($filters['tgl_akhir'] ?? '') ?>" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-2.5 py-2 text-xs text-white focus:outline-none focus:border-emerald-500">
                </div>
                <div class="md:col-span-1 flex gap-1.5">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl py-2 text-xs font-bold transition" title="Terapkan Filter">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                    <a href="<?= base_url('agenda') ?>" class="px-3 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl py-2 text-xs flex items-center justify-center transition" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/60 border-b border-slate-800 text-[11px] uppercase tracking-wider text-slate-400">
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4 w-44"><i class="fa-solid fa-hashtag mr-1 text-emerald-400"></i> 1. Nomor Register</th>
                        <th class="py-3.5 px-4 w-32"><i class="fa-regular fa-calendar mr-1 text-blue-400"></i> 2. Tanggal</th>
                        <th class="py-3.5 px-4 w-56"><i class="fa-regular fa-user mr-1 text-cyan-400"></i> 3. Nama Pemohon</th>
                        <th class="py-3.5 px-4 w-52"><i class="fa-solid fa-location-dot mr-1 text-rose-400"></i> 4. Alamat</th>
                        <th class="py-3.5 px-4"><i class="fa-solid fa-file-lines mr-1 text-amber-400"></i> 5. Keterangan</th>
                        <th class="py-3.5 px-4 text-center w-36">Status</th>
                        <th class="py-3.5 px-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80 text-sm">
                    <?php if (empty($agenda)): ?>
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-500">
                                <i class="fa-solid fa-file-circle-question text-4xl mb-3 opacity-40"></i>
                                <p class="font-semibold text-slate-400">Belum ada data pencatatan surat yang sesuai.</p>
                                <p class="text-xs mt-1">Silakan atur filter pencarian atau klik menu <strong>Form Input</strong> untuk menambah data.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($agenda as $item): ?>
                            <?php 
                                $words = explode(' ', trim($item['nama']));
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

                                $statusBadge = 'bg-blue-500/10 text-blue-400 border-blue-500/30';
                                if ($item['status'] == 'Selesai') $statusBadge = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30';
                                elseif ($item['status'] == 'Siap Diambil') $statusBadge = 'bg-teal-500/10 text-teal-400 border-teal-500/30';
                                elseif (in_array($item['status'], ['Dalam Proses', 'Sedang Diproses'])) $statusBadge = 'bg-amber-500/10 text-amber-400 border-amber-500/30';
                                elseif ($item['status'] == 'Dibatalkan') $statusBadge = 'bg-red-500/10 text-red-400 border-red-500/30';
                            ?>
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4 text-center text-slate-500 font-semibold text-xs"><?= $no++ ?></td>
                                <td class="py-3.5 px-4">
                                    <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-1 rounded-md font-mono text-xs font-bold">
                                        <?= esc($item['nomor_agenda'] ?? '-') ?>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-200 text-xs"><?= date('d/m/Y', strtotime($item['tanggal'])) ?></div>
                                    <div class="text-[11px] text-slate-500"><?= date('l', strtotime($item['tanggal'])) ?></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-700 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                            <?= $initials ?>
                                        </div>
                                        <div>
                                            <a href="<?= base_url('agenda/detail-view/' . $item['id']) ?>" class="font-bold text-white hover:text-emerald-400 transition text-xs block">
                                                <?= esc($item['nama']) ?>
                                            </a>
                                            <?php if (!empty($item['instansi'])): ?>
                                                <span class="text-[11px] text-slate-400">NIK: <?= esc($item['instansi']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-300 max-w-[200px] truncate" title="<?= esc($item['alamat']) ?>">
                                    <i class="fa-solid fa-location-dot text-rose-400 mr-1"></i> <?= esc($item['alamat']) ?>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-block bg-slate-800 text-emerald-300 text-[10px] font-bold uppercase px-2 py-0.5 rounded mb-1">
                                        <?= esc($item['kategori'] ?: 'Surat Keterangan') ?>
                                    </span>
                                    <p class="text-xs text-slate-300 line-clamp-2"><?= esc($item['keterangan'] ?? '-') ?></p>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <button onclick="toggleStatus(<?= $item['id'] ?>, '<?= esc($item['status']) ?>')" class="px-3 py-1 rounded-full text-xs font-bold border <?= $statusBadge ?> hover:scale-105 transition cursor-pointer" title="Klik untuk ubah status">
                                        <?= esc($item['status']) ?>
                                    </button>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="<?= base_url('agenda/detail-view/' . $item['id']) ?>" class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white flex items-center justify-center transition text-xs" title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <?php if (session()->get('role') === 'admin'): ?>
                                            <a href="<?= base_url('agenda/edit/' . $item['id']) ?>" class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 hover:bg-amber-500 hover:text-white flex items-center justify-center transition text-xs" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button onclick="confirmDelete('<?= base_url('agenda/delete/' . $item['id']) ?>', '<?= esc($item['nomor_agenda']) ?>')" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition text-xs" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        <?php endif; ?>
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

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
        const el = document.getElementById('liveClock');
        if (el) el.textContent = now.toLocaleDateString('id-ID', options) + ' WIB';
    }
    setInterval(updateClock, 1000);
    updateClock();

    // SweetAlert Delete
    function confirmDelete(deleteUrl, noAgenda) {
        Swal.fire({
            title: 'Hapus Pencatatan Surat?',
            text: 'Apakah Anda yakin ingin menghapus catatan surat nomor ' + noAgenda + '?',
            icon: 'warning',
            background: '#0f172a',
            color: '#f8fafc',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    }

    // Toggle Status via AJAX
    function toggleStatus(id, currentStatus) {
        <?php if (!in_array(session()->get('role'), ['admin', 'pejabat'])): ?>
            return; // Warga hanya bisa melihat status
        <?php endif; ?>

        const nextStatusMap = {
            'Dalam Proses': 'Siap Diambil',
            'Siap Diambil': 'Selesai',
            'Selesai': 'Dalam Proses',
            'Direncanakan': 'Dalam Proses',
            'Dibatalkan': 'Dalam Proses'
        };
        const nextStatus = nextStatusMap[currentStatus] || 'Dalam Proses';

        Swal.fire({
            title: 'Ubah Status Pelayanan',
            text: 'Ubah status dari "' + currentStatus + '" menjadi "' + nextStatus + '"?',
            icon: 'question',
            background: '#0f172a',
            color: '#f8fafc',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#475569',
            confirmButtonText: 'Ya, Ubah Jadi ' + nextStatus,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('status', nextStatus);

                fetch('<?= base_url('agenda/update-status/') ?>' + id, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(res => {
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Diperbarui!',
                            text: res.message,
                            background: '#0f172a',
                            color: '#f8fafc',
                            timer: 1200,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>