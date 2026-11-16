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
        .card-custom {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow: 0 15px 35px -10px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        .card-header-custom {
            background: var(--card-bg);
            border-bottom: 1px solid var(--card-border);
            padding: 1.35rem 1.75rem;
        }
        .form-label {
            font-weight: 700;
            font-size: 0.88rem;
            color: var(--text-title);
        }
        .form-control, .form-select {
            background-color: var(--card-bg);
            color: var(--text-body);
            border-radius: 12px;
            border: 1px solid var(--card-border);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }
        .btn-update-gov {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.75rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        .btn-update-gov:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: #ffffff;
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
                        <div class="small fw-bold text-uppercase" style="letter-spacing: 2px; color: #a7f3d0;">Pelayanan Administrasi Kelurahan Bumirejo</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-family: 'Outfit', sans-serif;">Edit Pencatatan Permohonan Surat</h3>
                    </div>
                </div>
                <button class="btn btn-outline-light rounded-circle" id="themeToggle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-moon"></i>
                </button>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> <strong>Gagal Mengubah Data:</strong>
                        <ul class="mb-0 mt-1">
                            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card-custom">
                    <div class="card-header-custom d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold m-0 fs-5"><i class="fa-solid fa-pen-to-square text-success me-2"></i> Perbarui Catatan Permohonan Surat</h6>
                        <span class="badge bg-secondary px-3 py-2 fs-6" style="border-radius: 10px;">ID Register: #<?= $agenda['id'] ?></span>
                    </div>

                    <form action="<?= base_url('agenda/update/' . $agenda['id']) ?>" method="POST" class="p-4">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <!-- 1. NOMOR -->
                            <div class="col-md-6">
                                <label class="form-label">1. Nomor Registrasi / Surat <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-hashtag text-success"></i></span>
                                    <input type="text" name="nomor_agenda" class="form-control border-start-0" value="<?= esc($agenda['nomor_agenda']) ?>" required>
                                </div>
                            </div>

                            <!-- 2. TANGGAL -->
                            <div class="col-md-6">
                                <label class="form-label">2. Tanggal Permohonan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-calendar text-primary"></i></span>
                                    <input type="date" name="tanggal" class="form-control border-start-0" value="<?= esc($agenda['tanggal']) ?>" required>
                                </div>
                            </div>

                            <!-- 3. NAMA -->
                            <div class="col-md-6">
                                <label class="form-label">3. Nama Pemohon / Warga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-info"></i></span>
                                    <input type="text" name="nama" class="form-control border-start-0" value="<?= esc($agenda['nama']) ?>" required>
                                </div>
                            </div>

                            <!-- NOMOR KTP / NIK -->
                            <div class="col-md-6">
                                <label class="form-label">Nomor KTP / NIK Pemohon <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-id-card text-success"></i></span>
                                    <input type="text" name="instansi" class="form-control border-start-0" value="<?= esc($agenda['instansi'] ?? '') ?>" placeholder="Masukkan 16 digit Nomor KTP / NIK warga" required minlength="5" maxlength="255">
                                </div>
                                <small class="text-muted" style="font-size: 0.78rem;">Wajib diisi sesuai identitas KTP pemohon.</small>
                            </div>

                            <!-- 4. ALAMAT -->
                            <div class="col-md-12">
                                <label class="form-label">4. Alamat Lengkap Pemohon <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control" rows="2" required><?= esc($agenda['alamat']) ?></textarea>
                            </div>

                            <!-- JENIS SURAT -->
                            <div class="col-md-6">
                                <label class="form-label">Jenis Surat Yang Diminta <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= esc($cat) ?>" <?= ($agenda['kategori'] == $cat) ? 'selected' : '' ?>><?= esc($cat) ?></option>
                                    <?php endforeach; ?>
                                    <?php if (!in_array($agenda['kategori'], $categories) && !empty($agenda['kategori'])): ?>
                                        <option value="<?= esc($agenda['kategori']) ?>" selected><?= esc($agenda['kategori']) ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- STATUS PELAYANAN -->
                            <div class="col-md-6">
                                <label class="form-label">Status Pelayanan Surat <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="Dalam Proses" <?= ($agenda['status'] == 'Dalam Proses' || $agenda['status'] == 'Sedang Diproses') ? 'selected' : '' ?>>Dalam Proses</option>
                                    <option value="Siap Diambil" <?= ($agenda['status'] == 'Siap Diambil') ? 'selected' : '' ?>>Siap Diambil</option>
                                    <option value="Selesai" <?= ($agenda['status'] == 'Selesai') ? 'selected' : '' ?>>Selesai (Sudah Diberikan ke Warga)</option>
                                    <option value="Direncanakan" <?= ($agenda['status'] == 'Direncanakan') ? 'selected' : '' ?>>Direncanakan</option>
                                    <option value="Dibatalkan" <?= ($agenda['status'] == 'Dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
                                </select>
                            </div>

                            <!-- 5. KETERANGAN -->
                            <div class="col-md-12">
                                <label class="form-label">5. Keterangan / Rincian Surat Yang Diminta & Keperluan <span class="text-danger">*</span></label>
                                <textarea name="keterangan" class="form-control" rows="4" required><?= esc($agenda['keterangan']) ?></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="<?= base_url('agenda') ?>" class="btn btn-outline-secondary rounded-3 px-4">Batal</a>
                            <button type="submit" class="btn btn-update-gov px-4">
                                <i class="fa-solid fa-check me-1"></i> Perbarui Catatan Surat
                            </button>
                        </div>
                    </form>
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
