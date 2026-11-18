<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Kelurahan Bumirejo' ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR KIRI -->
        <aside class="w-64 bg-slate-900 border-r border-slate-800 flex flex-col justify-between hidden md:flex">
            <div>
                <!-- Header Sidebar -->
                <div class="h-16 flex items-center px-6 border-b border-slate-800">
                    <div class="flex items-center space-x-3">
                        <div class="bg-emerald-600 p-2 rounded-lg text-white">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div>
                            <h1 class="text-sm font-bold tracking-wide">Kel. Bumirejo</h1>
                            <p class="text-xs text-slate-400 uppercase tracking-wider"><?= session()->get('role') ?></p>
                        </div>
                    </div>
                </div>

                <!-- Menu Navigasi Berdasarkan Role -->
                <nav class="p-4 space-y-1">
                    <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Menu Utama</p>
                    
                    <?php if (session()->get('role') !== 'warga'): ?>
                        <a href="<?= base_url('agenda') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?= (url_is('agenda') || url_is('/')) ? 'bg-emerald-500/15 text-emerald-400 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?> transition">
                            <i class="fa-solid fa-book-open w-5 text-center"></i>
                            <span>Buku Agenda Surat</span>
                        </a>
                    <?php endif; ?>

                    <?php if (session()->get('role') === 'admin'): ?>
                        <a href="<?= base_url('agenda/create') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?= url_is('agenda/create*') ? 'bg-emerald-500/15 text-emerald-400 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?> transition">
                            <i class="fa-solid fa-circle-plus w-5 text-center"></i>
                            <span>Input Register Baru</span>
                        </a>
                        <a href="<?= base_url('warga') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?= url_is('warga*') ? 'bg-emerald-500/15 text-emerald-400 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?> transition">
                            <i class="fa-solid fa-users-gear w-5 text-center"></i>
                            <span>Verifikasi Warga</span>
                        </a>
                    <?php endif; ?>

                    <?php if (session()->get('role') === 'pejabat'): ?>
                        <a href="<?= base_url('monitoring') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?= url_is('monitoring*') ? 'bg-emerald-500/15 text-emerald-400 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?> transition">
                            <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                            <span>Monitoring & Laporan</span>
                        </a>
                    <?php endif; ?>

                    <?php if (session()->get('role') === 'warga'): ?>
                        <a href="<?= base_url('riwayat') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?= (url_is('riwayat*') || url_is('agenda') || url_is('/')) ? 'bg-emerald-500/15 text-emerald-400 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?> transition">
                            <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i>
                            <span>Riwayat Permohonan</span>
                        </a>
                        <a href="<?= base_url('agenda/create') ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium <?= url_is('agenda/create*') ? 'bg-emerald-500/15 text-emerald-400 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?> transition">
                            <i class="fa-solid fa-file-pen w-5 text-center"></i>
                            <span>Ajukan Surat Baru</span>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>

            <!-- Footer Sidebar / User Info & Logout -->
            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center justify-between mb-3 px-2">
                    <div class="truncate">
                        <p class="text-xs font-medium text-white truncate"><?= session()->get('nama') ?></p>
                        <p class="text-[10px] text-slate-400 truncate">NIK: <?= session()->get('nik') ?></p>
                    </div>
                </div>
                <a href="<?= base_url('logout') ?>" class="flex items-center justify-center space-x-2 w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 text-sm font-medium py-2 rounded-lg transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar Sistem</span>
                </a>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar Mobile / Header -->
            <header class="h-16 bg-slate-900 border-b border-slate-800 flex items-center justify-between px-6 md:justify-end">
                <div class="md:hidden flex items-center space-x-2">
                    <span class="font-bold text-sm">Kelurahan Bumirejo</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-xs bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-full font-medium">
                        Role: <span class="uppercase font-bold"><?= session()->get('role') ?></span>
                    </span>
                </div>
            </header>

            <!-- Area Isi Halaman (Dinamis) -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-950 p-6">
                <?= $this->renderSection('content') ?>
            </main>
        </div>

    </div>

</body>
</html>