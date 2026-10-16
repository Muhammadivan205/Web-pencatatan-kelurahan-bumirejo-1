<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-title: #0f172a;
            --text-body: #334155;
            --header-gradient: linear-gradient(135deg, #064e3b 0%, #065f46 45%, #0f766e 100%);
        }
        [data-bs-theme="dark"] {
            --bg-main: #0b1329;
            --card-bg: #111c3a;
            --card-border: #1e293b;
            --text-title: #f8fafc;
            --text-body: #cbd5e1;
            --header-gradient: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #042f2e 100%);
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-body);
            padding-bottom: 4rem;
        }
        .header-bar {
            background: var(--header-gradient);
            color: #ffffff;
            padding: 1.75rem 0;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .detail-card {
            background: var(--card-bg);
            border-radius: 22px;
            border: 1px solid var(--card-border);
            box-shadow: 0 15px 35px -10px rgba(15, 23, 42, 0.08);
            padding: 2.25rem;
        }
        .field-label {
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #059669;
            font-weight: 800;
            margin-bottom: 0.35rem;
        }
        .field-value {
            font-size: 1.05rem;
            color: var(--text-title);
            font-weight: 600;
        }
        .ket-box {
            background: rgba(16, 185, 129, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 14px;
            padding: 1.25rem;
            font-size: 1.05rem;
            line-height: 1.6;
            color: var(--text-title);
        }
    </style>
</head>
<body>

    <header class="header-bar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <a href="<?= base_url('agenda') ?>" class="btn btn-outline-light btn-sm rounded-circle" style="width:40px; height:40px; display:flex; align-items:center; justify-content:center;" title="Kembali">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div style="width: 44px; height: 44px; background: #ffffff; border-radius: 12px; padding: 4px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.2); flex-shrink: 0;">
                        <img src="<?= base_url('images/logo-magelang.svg') ?>" alt="Logo Kabupaten Magelang" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <div>
                        <div class="small fw-bold text-uppercase" style="letter-spacing: 2px; color: #a7f3d0;">Detail Permohonan Surat Warga</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-family: 'Outfit', sans-serif;"><?= esc($agenda['nomor_agenda']) ?></h3>
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <button class="btn btn-outline-light rounded-circle me-1" id="themeToggle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-moon"></i>
                    </button>
                    <a href="<?= base_url('agenda/edit/' . $agenda['id']) ?>" class="btn btn-warning btn-sm font-semibold rounded-3 px-3">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Data
                    </a>
                    <a href="<?= base_url('agenda') ?>" class="btn btn-light btn-sm font-semibold rounded-3 px-3">
                        <i class="fa-solid fa-list me-1"></i> Kembali ke Buku Register
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="detail-card">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4 flex-wrap gap-2">
                        <div>
                            <span class="badge bg-success px-3 py-2 fs-6"><i class="fa-solid fa-hashtag me-1"></i> <?= esc($agenda['nomor_agenda']) ?></span>
                            <span class="badge bg-primary px-3 py-2 fs-6 ms-1"><?= esc($agenda['kategori']) ?></span>
                        </div>
                        <div>
                            <span class="badge bg-secondary px-3 py-2 fs-6"><i class="fa-solid fa-circle-info me-1"></i> <?= esc($agenda['status']) ?></span>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- 1. NOMOR -->
                        <div class="col-md-6">
                            <div class="field-label"><i class="fa-solid fa-hashtag me-1"></i> 1. NOMOR REGISTER / SURAT</div>
                            <div class="field-value fs-5 text-success fw-bold"><?= esc($agenda['nomor_agenda']) ?></div>
                        </div>

                        <!-- 2. TANGGAL -->
                        <div class="col-md-6">
                            <div class="field-label"><i class="fa-regular fa-calendar me-1"></i> 2. TANGGAL PERMOHONAN</div>
                            <div class="field-value"><i class="fa-regular fa-calendar-check text-primary me-2"></i><?= date('d F Y', strtotime($agenda['tanggal'])) ?></div>
                        </div>

                        <!-- 3. NAMA -->
                        <div class="col-md-7">
                            <div class="field-label"><i class="fa-regular fa-user me-1"></i> 3. NAMA PEMOHON / WARGA</div>
                            <div class="field-value fs-4 text-primary fw-bold"><?= esc($agenda['nama']) ?></div>
                        </div>

                        <!-- NOMOR KTP / NIK -->
                        <div class="col-md-5">
                            <div class="field-label"><i class="fa-solid fa-id-card me-1"></i> NOMOR KTP / NIK PEMOHON</div>
                            <div class="field-value text-success fw-bold"><?= esc($agenda['instansi'] ?: '-') ?></div>
                        </div>

                        <!-- 4. ALAMAT -->
                        <div class="col-md-12">
                            <div class="field-label"><i class="fa-solid fa-location-dot me-1"></i> 4. ALAMAT LENGKAP WARGA</div>
                            <div class="field-value"><i class="fa-solid fa-map-pin text-danger me-2"></i><?= esc($agenda['alamat']) ?></div>
                        </div>

                        <!-- 5. KETERANGAN -->
                        <div class="col-md-12">
                            <div class="field-label"><i class="fa-solid fa-file-lines me-1"></i> 5. KETERANGAN / SURAT YANG DIMINTA & KEPERLUAN</div>
                            <div class="ket-box">
                                <?= nl2br(esc($agenda['keterangan'] ?: '-')) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="field-label">WAKTU DICATAT SISTEM</div>
                            <div class="text-muted small"><?= $agenda['created_at'] ? date('d/m/Y H:i', strtotime($agenda['created_at'])) . ' WIB' : '-' ?></div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="field-label">TERAKHIR DIUBAH</div>
                            <div class="text-muted small"><?= $agenda['updated_at'] ? date('d/m/Y H:i', strtotime($agenda['updated_at'])) . ' WIB' : '-' ?></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                        <a href="<?= base_url('agenda') ?>" class="btn btn-outline-secondary rounded-3 px-4">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('agenda/edit/' . $agenda['id']) ?>" class="btn btn-outline-warning rounded-3 px-3">
                                <i class="fa-solid fa-pen me-1"></i> Edit
                            </a>
                            <a href="<?= base_url('agenda/print?search=' . urlencode($agenda['nomor_agenda'])) ?>" target="_blank" class="btn btn-success rounded-3 px-4">
                                <i class="fa-solid fa-print me-1"></i> Cetak Tanda Bukti / Register
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>
</body>
</html>
