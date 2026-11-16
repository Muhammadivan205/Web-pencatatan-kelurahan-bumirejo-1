<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Pro 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-title: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --accent-emerald: #059669;
            --accent-blue: #2563eb;
            --accent-amber: #d97706;
            --accent-indigo: #4f46e5;
            --card-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.05), 0 4px 6px -4px rgba(15, 23, 42, 0.03);
            --header-gradient: linear-gradient(135deg, #064e3b 0%, #065f46 45%, #0f766e 100%);
        }

        [data-bs-theme="dark"] {
            --bg-main: #0b1329;
            --card-bg: #111c3a;
            --card-border: #1e293b;
            --text-title: #f8fafc;
            --text-body: #cbd5e1;
            --text-muted: #94a3b8;
            --card-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.4);
            --header-gradient: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #042f2e 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-body);
            transition: background-color 0.3s ease, color 0.3s ease;
            min-height: 100vh;
            padding-bottom: 5rem;
        }

        /* Executive Top Header */
        .gov-header {
            background: var(--header-gradient);
            color: #ffffff;
            padding: 2rem 0 4.5rem 0;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .gov-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
        }

        .gov-brand {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .gov-logo-badge {
            width: 62px;
            height: 62px;
            background: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 22px rgba(0,0,0,0.22);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 6px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .gov-logo-badge img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .gov-logo-badge:hover {
            transform: scale(1.06) translateY(-2px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.3);
        }

        .gov-title-sub {
            font-family: 'Outfit', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #a7f3d0;
            font-weight: 700;
        }

        .gov-title-main {
            font-family: 'Outfit', sans-serif;
            font-size: 1.75rem;
            font-weight: 800;
            margin: 0;
            line-height: 1.2;
            color: #ffffff;
        }

        /* Clock widget */
        .clock-widget {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            color: #ffffff;
            font-size: 0.88rem;
            font-weight: 600;
        }

        /* Floating KPI Cards Banner */
        .stats-wrapper {
            margin-top: -3.2rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 10;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 18px;
            padding: 1.35rem 1.5rem;
            border: 1px solid var(--card-border);
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px -5px rgba(15, 23, 42, 0.12);
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
        }

        .stat-icon.blue { background: rgba(37, 99, 235, 0.1); color: #3b82f6; }
        .stat-icon.emerald { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .stat-icon.amber { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .stat-icon.teal { background: rgba(20, 184, 166, 0.1); color: #14b8a6; }

        .stat-number {
            font-family: 'Outfit', sans-serif;
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-title);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.825rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .progress-bar-custom {
            height: 6px;
            border-radius: 10px;
            background: rgba(100, 116, 139, 0.15);
            overflow: hidden;
            margin-top: 0.75rem;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            background: linear-gradient(90deg, #10b981, #059669);
            transition: width 0.6s ease;
        }

        /* Filter Section & Main Table Card */
        .content-card {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow: var(--card-shadow);
            margin-bottom: 3rem;
            overflow: hidden;
        }

        .card-header-custom {
            padding: 1.35rem 1.75rem;
            background: var(--card-bg);
            border-bottom: 1px solid var(--card-border);
        }

        .filter-chip {
            background: rgba(100, 116, 139, 0.08);
            border: 1px solid var(--card-border);
            color: var(--text-body);
            border-radius: 50px;
            padding: 0.35rem 0.9rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .filter-chip:hover, .filter-chip.active {
            background: #059669;
            color: #ffffff;
            border-color: #059669;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .table-custom {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table-custom thead th {
            background-color: rgba(100, 116, 139, 0.05);
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 1rem 1.15rem;
            border-bottom: 1px solid var(--card-border);
        }

        .table-custom tbody tr {
            transition: background 0.15s ease;
        }

        .table-custom tbody tr:hover {
            background-color: rgba(5, 150, 105, 0.04);
        }

        .table-custom td {
            padding: 1.15rem 1.15rem;
            color: var(--text-body);
            font-size: 0.92rem;
            border-bottom: 1px solid var(--card-border);
        }

        /* Avatar Circle for Names */
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            flex-shrink: 0;
        }

        /* Status Badges with Pulsing Animation */
        .badge-status {
            padding: 0.45rem 0.95rem;
            border-radius: 50px;
            font-size: 0.76rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .badge-status:hover {
            transform: scale(1.05);
        }

        .badge-status.selesai { background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); }
        .badge-status.siap { background: rgba(20, 184, 166, 0.15); color: #0d9488; border: 1px solid rgba(20, 184, 166, 0.3); }
        .badge-status.proses { background: rgba(245, 158, 11, 0.12); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); }
        .badge-status.rencana { background: rgba(37, 99, 235, 0.12); color: #3b82f6; border: 1px solid rgba(37, 99, 235, 0.3); }
        .badge-status.batal { background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }
        .pulse-dot.amber { background: #f59e0b; box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); animation: pulseAmber 1.6s infinite; }
        .pulse-dot.blue { background: #3b82f6; }
        .pulse-dot.green { background: #10b981; }
        .pulse-dot.teal { background: #14b8a6; }
        .pulse-dot.red { background: #ef4444; }

        @keyframes pulseAmber {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }

        /* Category Badge Colors */
        .badge-kategori {
            font-size: 0.73rem;
            font-weight: 700;
            padding: 0.28rem 0.65rem;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .cat-sku { background: rgba(16, 185, 129, 0.15); color: #047857; }
        .cat-skck { background: rgba(37, 99, 235, 0.12); color: #1d4ed8; }
        .cat-domisili { background: rgba(99, 102, 241, 0.12); color: #4338ca; }
        .cat-sktm { background: rgba(245, 158, 11, 0.15); color: #b45309; }
        .cat-nikah { background: rgba(236, 72, 153, 0.12); color: #be185d; }
        .cat-kelahiran { background: rgba(6, 182, 212, 0.12); color: #0e7490; }
        .cat-kematian { background: rgba(100, 116, 139, 0.15); color: #334155; }
        .cat-default { background: rgba(100, 116, 139, 0.12); color: #64748b; }

        /* Action Buttons */
        .btn-gov-primary {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 0.65rem 1.35rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            transition: all 0.25s ease;
        }

        .btn-gov-primary:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.88rem;
            text-decoration: none;
        }

        .action-btn.view { background: rgba(37, 99, 235, 0.1); color: #2563eb; }
        .action-btn.view:hover { background: #2563eb; color: #fff; transform: translateY(-2px); }

        .action-btn.edit { background: rgba(245, 158, 11, 0.1); color: #d97706; }
        .action-btn.edit:hover { background: #d97706; color: #fff; transform: translateY(-2px); }

        .action-btn.delete { background: rgba(239, 68, 68, 0.1); color: #dc2626; }
        .action-btn.delete:hover { background: #dc2626; color: #fff; transform: translateY(-2px); }



        /* Modal styling */
        .modal-content {
            background: var(--card-bg);
            color: var(--text-body);
            border-radius: 22px;
            border: 1px solid var(--card-border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: var(--header-gradient);
            color: #ffffff;
            border-radius: 22px 22px 0 0;
            padding: 1.35rem 1.75rem;
        }

        .modal-header .btn-close {
            filter: invert(1) brightness(200%);
        }

        .form-control, .form-select {
            background-color: var(--card-bg);
            color: var(--text-body);
            border-radius: 12px;
            border: 1px solid var(--card-border);
            padding: 0.7rem 1rem;
            font-size: 0.92rem;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--card-bg);
            color: var(--text-body);
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        .quick-preset-btn {
            font-size: 0.78rem;
            padding: 0.3rem 0.65rem;
            border-radius: 8px;
            border: 1px solid var(--card-border);
            background: rgba(100, 116, 139, 0.08);
            color: var(--text-body);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-preset-btn:hover {
            background: #10b981;
            color: #fff;
            border-color: #10b981;
        }

        .num-badge {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            padding: 0.25rem 0.55rem;
            border-radius: 6px;
            border: 1px solid rgba(16, 185, 129, 0.25);
            font-size: 0.85rem;
        }
        [data-bs-theme="dark"] .num-badge {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }
    </style>
</head>
<body>

    <!-- Executive Header Banner -->
    <header class="gov-header">
        <div class="container-fluid px-4">
            <div class="row align-items-center justify-content-between g-3">
                <div class="col-md-7">
                    <div class="gov-brand">
                        <div class="gov-logo-badge">
                            <img src="<?= base_url('images/logo-magelang.svg') ?>" alt="Logo Kabupaten Magelang" width="52" height="52">
                        </div>
                        <div>
                            <div class="gov-title-sub"><i class="fa-solid fa-landmark me-1"></i> PEMERINTAH KABUPATEN MAGELANG • KECAMATAN MUNGKID • KELURAHAN BUMIREJO</div>
                            <h1 class="gov-title-main">Buku Pencatatan Pelayanan Surat Warga</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-md-end">
                    <div class="d-inline-flex align-items-center gap-2 flex-wrap justify-content-md-end">
                        <div class="clock-widget">
                            <i class="fa-regular fa-clock" style="color: #6ee7b7;"></i>
                            <span id="liveClock">Loading...</span>
                        </div>
                        <button class="btn btn-outline-light rounded-circle" id="themeToggle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" title="Toggle Light/Dark Mode">
                            <i class="fa-solid fa-moon"></i>
                        </button>
                        <a href="<?= base_url('agenda/tambah') ?>" class="btn btn-gov-primary px-3" style="border-radius: 12px;" title="Buka Halaman Form Input Pencatatan Surat">
                            <i class="fa-solid fa-file-pen me-1"></i> Form Input
                        </a>
                        <a href="<?= base_url('agenda/print?' . http_build_query($filters)) ?>" target="_blank" class="btn btn-light text-dark fw-bold px-3" style="border-radius: 12px;">
                            <i class="fa-solid fa-print me-1 text-success"></i> Cetak Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid px-4">
        <!-- Floating Analytics KPI Cards Banner -->
        <div class="stats-wrapper">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                            <div>
                                <div class="stat-number"><?= number_format($stats['total']) ?></div>
                                <div class="stat-label">Total Surat Dicatat</div>
                            </div>
                            <div class="stat-icon emerald">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>
                        </div>
                        <div class="small text-muted fw-semibold" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-database me-1 text-success"></i> Register Pelayanan Aktif
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                            <div>
                                <div class="stat-number"><?= number_format($stats['today']) ?></div>
                                <div class="stat-label">Permohonan Hari Ini</div>
                            </div>
                            <div class="stat-icon blue">
                                <i class="fa-solid fa-calendar-day"></i>
                            </div>
                        </div>
                        <div class="small text-muted fw-semibold" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-clock me-1 text-primary"></i> <?= date('d M Y') ?>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                            <div>
                                <div class="stat-number"><?= number_format($stats['proses'] + ($stats['siapAmbil'] ?? 0)) ?></div>
                                <div class="stat-label">Sedang Diproses / Siap</div>
                            </div>
                            <div class="stat-icon amber">
                                <i class="fa-solid fa-hourglass-half"></i>
                            </div>
                        </div>
                        <div class="small text-muted fw-semibold" style="font-size: 0.75rem;">
                            <span class="pulse-dot amber me-1"></span> Menunggu Penyerahan Warga
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="d-flex align-items-center justify-content-between w-100 mb-1">
                            <div>
                                <div class="stat-number"><?= number_format($stats['selesai']) ?></div>
                                <div class="stat-label">Surat Selesai Diserahkan</div>
                            </div>
                            <div class="stat-icon teal">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: <?= $stats['percentSelesai'] ?>%;"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1" style="font-size: 0.72rem; color: var(--text-muted);">
                            <span>Tingkat Efektivitas</span>
                            <span class="fw-bold text-success"><?= $stats['percentSelesai'] ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Notification Feedback -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert" style="background: rgba(16, 185, 129, 0.15); color: #047857;">
                <i class="fa-solid fa-circle-check me-2 fs-5"></i> <strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i> <strong>Perhatian!</strong> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Main Content Card -->
        <div class="content-card">
            <!-- Filter & Search Header Bar -->
            <div class="card-header-custom">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-sliders text-success fs-5"></i>
                        <h6 class="mb-0 fw-bold fs-5 text-title">Filter & Pencarian Registrasi Surat</h6>
                    </div>
                    <!-- Date Preset Chips -->
                    <div class="d-flex align-items-center gap-1 flex-wrap">
                        <span class="small text-muted me-1 fw-bold">Shortcut Waktu:</span>
                        <a href="<?= base_url('agenda') ?>" class="filter-chip <?= empty($filters['tgl_awal']) ? 'active' : '' ?>">Semua</a>
                        <a href="<?= base_url('agenda?tgl_awal=' . date('Y-m-d') . '&tgl_akhir=' . date('Y-m-d')) ?>" class="filter-chip <?= ($filters['tgl_awal'] == date('Y-m-d')) ? 'active' : '' ?>"><i class="fa-solid fa-calendar-day"></i> Hari Ini</a>
                        <a href="<?= base_url('agenda?tgl_awal=' . date('Y-m-d', strtotime('-7 days')) . '&tgl_akhir=' . date('Y-m-d')) ?>" class="filter-chip">7 Hari Terakhir</a>
                        <a href="<?= base_url('agenda?tgl_awal=' . date('Y-m-01') . '&tgl_akhir=' . date('Y-m-t')) ?>" class="filter-chip">Bulan Ini</a>
                    </div>
                </div>

                <form action="<?= base_url('agenda') ?>" method="GET" class="w-100">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari Nomor, NIK, Nama, Alamat, Keterangan..." value="<?= esc($filters['search'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="kategori" class="form-select">
                                <option value="">-- Semua Jenis Surat --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= esc($cat) ?>" <?= ($filters['kategori'] == $cat) ? 'selected' : '' ?>><?= esc($cat) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">-- Semua Status --</option>
                                <option value="Selesai" <?= ($filters['status'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                                <option value="Siap Diambil" <?= ($filters['status'] == 'Siap Diambil') ? 'selected' : '' ?>>Siap Diambil</option>
                                <option value="Dalam Proses" <?= ($filters['status'] == 'Dalam Proses') ? 'selected' : '' ?>>Dalam Proses</option>
                                <option value="Direncanakan" <?= ($filters['status'] == 'Direncanakan') ? 'selected' : '' ?>>Direncanakan</option>
                                <option value="Dibatalkan" <?= ($filters['status'] == 'Dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-1 align-items-center">
                                <input type="date" name="tgl_awal" class="form-control" title="Tanggal Awal" value="<?= esc($filters['tgl_awal'] ?? '') ?>">
                                <span class="text-muted">-</span>
                                <input type="date" name="tgl_akhir" class="form-control" title="Tanggal Akhir" value="<?= esc($filters['tgl_akhir'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-1 d-flex gap-1">
                            <button type="submit" class="btn btn-success w-100 rounded-3" title="Terapkan Filter">
                                <i class="fa-solid fa-filter"></i>
                            </button>
                            <a href="<?= base_url('agenda') ?>" class="btn btn-outline-secondary rounded-3" title="Reset Filter">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Ketentuan Kolom: Nomor, Tanggal, Nama, Alamat, Keterangan -->
            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th style="width: 45px;" class="text-center">No</th>
                            <th style="width: 170px;"><i class="fa-solid fa-hashtag me-1 text-success"></i> 1. Nomor Register</th>
                            <th style="width: 130px;"><i class="fa-regular fa-calendar me-1 text-primary"></i> 2. Tanggal</th>
                            <th style="width: 220px;"><i class="fa-regular fa-user me-1 text-info"></i> 3. Nama Pemohon</th>
                            <th style="width: 220px;"><i class="fa-solid fa-location-dot me-1 text-danger"></i> 4. Alamat</th>
                            <th><i class="fa-solid fa-file-lines me-1 text-warning"></i> 5. Keterangan (Surat Yang Diminta)</th>
                            <th style="width: 130px;" class="text-center">Status</th>
                            <th style="width: 110px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($agenda)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-file-circle-question fa-3x mb-3 text-secondary opacity-40"></i>
                                    <p class="mb-0 fw-bold fs-6">Belum ada data pencatatan surat yang sesuai.</p>
                                    <small>Silakan atur filter pencarian atau klik menu <strong>Form Input</strong> untuk mencatat permohonan surat warga.</small>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php 
                                $gradients = [
                                    'linear-gradient(135deg, #10b981, #047857)',
                                    'linear-gradient(135deg, #3b82f6, #1d4ed8)',
                                    'linear-gradient(135deg, #8b5cf6, #6d28d9)',
                                    'linear-gradient(135deg, #f59e0b, #b45309)',
                                    'linear-gradient(135deg, #06b6d4, #0e7490)',
                                ];
                                $no = 1; 
                                foreach ($agenda as $item): 
                                    // Initials for avatar
                                    $words = explode(' ', trim($item['nama']));
                                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                    $bgGrad = $gradients[$item['id'] % count($gradients)];

                                    // Category styling
                                    $catClass = 'cat-default';
                                    $kategoriStr = $item['kategori'] ?? '';
                                    if (stripos($kategoriStr, 'Usaha') !== false || stripos($kategoriStr, 'SKU') !== false) $catClass = 'cat-sku';
                                    elseif (stripos($kategoriStr, 'SKCK') !== false) $catClass = 'cat-skck';
                                    elseif (stripos($kategoriStr, 'Domisili') !== false) $catClass = 'cat-domisili';
                                    elseif (stripos($kategoriStr, 'Tidak Mampu') !== false || stripos($kategoriStr, 'SKTM') !== false) $catClass = 'cat-sktm';
                                    elseif (stripos($kategoriStr, 'Nikah') !== false) $catClass = 'cat-nikah';
                                    elseif (stripos($kategoriStr, 'Kelahiran') !== false) $catClass = 'cat-kelahiran';
                                    elseif (stripos($kategoriStr, 'Kematian') !== false) $catClass = 'cat-kematian';
                            ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted" style="font-size: 0.85rem;"><?= $no++ ?></td>
                                    
                                    <!-- 1. NOMOR -->
                                    <td>
                                        <span class="num-badge"><?= esc($item['nomor_agenda'] ?? '-') ?></span>
                                    </td>

                                    <!-- 2. TANGGAL -->
                                    <td>
                                        <div class="fw-semibold text-title" style="font-size: 0.88rem;">
                                            <i class="fa-regular fa-calendar-check text-success me-1"></i><?= date('d/m/Y', strtotime($item['tanggal'])) ?>
                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;"><?= date('l', strtotime($item['tanggal'])) ?></small>
                                    </td>

                                    <!-- 3. NAMA -->
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-circle" style="background: <?= $bgGrad ?>;">
                                                <?= $initials ?>
                                            </div>
                                            <div>
                                                <a href="<?= base_url('agenda/detail-view/' . $item['id']) ?>" class="fw-bold text-decoration-none text-title" style="font-size: 0.95rem;">
                                                    <?= esc($item['nama']) ?>
                                                </a>
                                                <?php if (!empty($item['instansi'])): ?>
                                                    <div class="text-muted small" style="font-size: 0.76rem;">
                                                        <i class="fa-solid fa-id-card me-1 text-success"></i><span class="text-body fw-semibold">NIK: <?= esc($item['instansi']) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- 4. ALAMAT -->
                                    <td>
                                        <div class="text-truncate" style="max-width: 220px;" title="<?= esc($item['alamat']) ?>">
                                            <i class="fa-solid fa-location-dot text-danger me-1"></i><?= esc($item['alamat']) ?>
                                        </div>
                                    </td>

                                    <!-- 5. KETERANGAN -->
                                    <td>
                                        <div class="mb-1">
                                            <span class="badge-kategori <?= $catClass ?>"><?= esc($item['kategori'] ?: 'Surat Keterangan') ?></span>
                                        </div>
                                        <div class="text-body fw-medium" style="font-size: 0.88rem; max-width: 380px;">
                                            <?= esc($item['keterangan'] ?? '-') ?>
                                        </div>
                                    </td>

                                    <!-- STATUS -->
                                    <td class="text-center">
                                        <?php 
                                            $statusClass = 'rencana';
                                            $dotClass = 'blue';
                                            if ($item['status'] == 'Selesai') { $statusClass = 'selesai'; $dotClass = 'green'; }
                                            elseif ($item['status'] == 'Siap Diambil') { $statusClass = 'siap'; $dotClass = 'teal'; }
                                            elseif ($item['status'] == 'Dalam Proses' || $item['status'] == 'Sedang Diproses') { $statusClass = 'proses'; $dotClass = 'amber'; }
                                            elseif ($item['status'] == 'Dibatalkan') { $statusClass = 'batal'; $dotClass = 'red'; }
                                        ?>
                                        <span class="badge-status <?= $statusClass ?>" onclick="toggleStatus(<?= $item['id'] ?>, '<?= esc($item['status']) ?>')" title="Klik untuk ubah status pelayanan">
                                            <span class="pulse-dot <?= $dotClass ?>"></span> <?= esc($item['status']) ?>
                                        </span>
                                    </td>

                                    <!-- AKSI -->
                                    <td class="text-center">
                                        <div class="d-inline-flex gap-1.5">
                                            <a href="<?= base_url('agenda/detail-view/' . $item['id']) ?>" class="action-btn view" title="Lihat Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('agenda/edit/' . $item['id']) ?>" class="action-btn edit" title="Edit Catatan">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button onclick="confirmDelete('<?= base_url('agenda/delete/' . $item['id']) ?>', '<?= esc($item['nomor_agenda']) ?>')" class="action-btn delete" title="Hapus Data">
                                                <i class="fa-solid fa-trash-can"></i>
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



    <!-- Footer -->
    <footer class="text-center text-muted py-4 small border-top bg-transparent mt-auto">
        <div class="container">
            <p class="mb-0">© <?= date('Y') ?> <strong>Pemerintah Kelurahan Bumirejo</strong> • Kecamatan Mungkid, Kabupaten Magelang • Sistem Pencatatan & Registrasi Pelayanan Surat Warga</p>
        </div>
    </footer>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Live Clock Widget
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('liveClock').textContent = now.toLocaleDateString('id-ID', options) + ' WIB';
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Theme Toggle Handler
        const themeToggleBtn = document.getElementById('themeToggle');
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', currentTheme);
        themeToggleBtn.innerHTML = currentTheme === 'dark' ? '<i class="fa-solid fa-sun text-warning"></i>' : '<i class="fa-solid fa-moon"></i>';

        themeToggleBtn.addEventListener('click', function() {
            let theme = document.documentElement.getAttribute('data-bs-theme');
            let newTheme = theme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            themeToggleBtn.innerHTML = newTheme === 'dark' ? '<i class="fa-solid fa-sun text-warning"></i>' : '<i class="fa-solid fa-moon"></i>';
        });



        // SweetAlert Delete
        function confirmDelete(deleteUrl, noAgenda) {
            Swal.fire({
                title: 'Hapus Pencatatan Surat?',
                text: 'Apakah Anda yakin ingin menghapus catatan surat nomor ' + noAgenda + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }

        // Toggle Status via AJAX
        function toggleStatus(id, currentStatus) {
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
                showCancelButton: true,
                confirmButtonColor: '#10b981',
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
</body>
</html>
