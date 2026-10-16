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
            background-color: var(--card-bg);
            color: var(--text-body);
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }
        .btn-gov-primary {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.75rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        .btn-gov-primary:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: #ffffff;
        }
        .quick-preset-btn {
            font-size: 0.8rem;
            padding: 0.35rem 0.75rem;
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
                        <h3 class="fw-bold mb-0 text-white" style="font-family: 'Outfit', sans-serif;">Pencatatan Permohonan Surat Warga</h3>
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
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> <strong>Gagal Menyimpan Data Pencatatan:</strong>
                        <ul class="mb-0 mt-1">
                            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card-custom">
                    <div class="card-header-custom d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h6 class="fw-bold m-0 fs-5"><i class="fa-solid fa-file-pen text-success me-2"></i> Input Lembar Registrasi Permohonan Surat</h6>
                        <span class="badge bg-success px-3 py-2 fs-6" style="border-radius: 10px;">No. Otomatis: <?= esc($auto_no_agenda) ?></span>
                    </div>

                    <form action="<?= base_url('agenda/store') ?>" method="POST" class="p-4">
                        <?= csrf_field() ?>

                        <!-- Preset Surat Buttons -->
                        <div class="mb-4 p-3 rounded-4" style="background: rgba(16, 185, 129, 0.08); border: 1px dashed rgba(16, 185, 129, 0.35);">
                            <div class="small fw-bold text-success mb-2">
                                <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Klik Cepat Jenis Surat Yang Diminta Warga:
                            </div>
                            <div class="d-flex flex-wrap gap-1.5">
                                <button type="button" class="quick-preset-btn" onclick="applyPreset('Surat Keterangan Usaha (SKU)', 'Permohonan Surat Keterangan Usaha (SKU) toko/usaha mikro untuk pengajuan modal usaha perbankan / KUR.')">
                                    <i class="fa-solid fa-store me-1"></i> SKU (Usaha)
                                </button>
                                <button type="button" class="quick-preset-btn" onclick="applyPreset('Surat Pengantar SKCK', 'Permohonan Surat Pengantar SKCK Polsek/Polres untuk persyaratan melamar pekerjaan.')">
                                    <i class="fa-solid fa-id-badge me-1"></i> Pengantar SKCK
                                </button>
                                <button type="button" class="quick-preset-btn" onclick="applyPreset('Surat Keterangan Domisili', 'Permohonan Surat Keterangan Domisili tempat tinggal sementara warga / pengurusan dokumen.')">
                                    <i class="fa-solid fa-house-user me-1"></i> Domisili
                                </button>
                                <button type="button" class="quick-preset-btn" onclick="applyPreset('Surat Keterangan Tidak Mampu (SKTM)', 'Permohonan SKTM untuk persyaratan keringanan biaya pendidikan / pengobatan di RSUD.')">
                                    <i class="fa-solid fa-hand-holding-heart me-1"></i> SKTM
                                </button>
                                <button type="button" class="quick-preset-btn" onclick="applyPreset('Surat Pengantar Nikah (N1-N4)', 'Permohonan Surat Pengantar Nikah (Formulir N1-N4) untuk pendaftaran ke Kantor Urusan Agama (KUA).')">
                                    <i class="fa-solid fa-rings-wedding me-1"></i> Pengantar Nikah
                                </button>
                                <button type="button" class="quick-preset-btn" onclick="applyPreset('Surat Keterangan Kelahiran', 'Permohonan Surat Keterangan Kelahiran untuk penerbitan Akta Kelahiran di Disdukcapil.')">
                                    <i class="fa-solid fa-baby me-1"></i> Kelahiran
                                </button>
                                <button type="button" class="quick-preset-btn" onclick="applyPreset('Surat Keterangan Kematian', 'Permohonan Surat Keterangan Kematian untuk pengurusan Akta Kematian & hak waris.')">
                                    <i class="fa-solid fa-book-skull me-1"></i> Kematian
                                </button>
                                <button type="button" class="quick-preset-btn" onclick="applyPreset('Surat Keterangan Pindah', 'Permohonan Surat Keterangan Pindah Domisili antar RT/RW/Kelurahan.')">
                                    <i class="fa-solid fa-truck-moving me-1"></i> Pindah
                                </button>
                                <button type="button" class="quick-preset-btn" onclick="applyPreset('Surat Keterangan Belum Menikah', 'Permohonan Surat Keterangan Belum Menikah untuk persyaratan kerja / administrasi bank.')">
                                    <i class="fa-solid fa-user-check me-1"></i> Belum Menikah
                                </button>
                            </div>
                        </div>

                        <!-- 5 KETENTUAN PENCATATAN -->
                        <div class="row g-3">
                            <!-- 1. NOMOR -->
                            <div class="col-md-6">
                                <label class="form-label">1. Nomor Registrasi / Surat <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-hashtag text-success"></i></span>
                                    <input type="text" name="nomor_agenda" id="fieldNomor" class="form-control border-start-0" value="<?= esc($auto_no_agenda) ?>" placeholder="B / 140 / 001 / 10 / 2026" required>
                                </div>
                                <small class="text-muted" style="font-size: 0.78rem;">Format dinas: <strong>B / 140 / No. Urut / Bulan / Tahun</strong> (Otomatis atau disesuaikan).</small>
                            </div>

                            <!-- 2. TANGGAL -->
                            <div class="col-md-6">
                                <label class="form-label">2. Tanggal Permohonan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-calendar text-primary"></i></span>
                                    <input type="date" name="tanggal" id="fieldTanggal" class="form-control border-start-0" value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>

                            <!-- 3. NAMA -->
                            <div class="col-md-6">
                                <label class="form-label">3. Nama Pemohon / Warga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-info"></i></span>
                                    <input type="text" name="nama" id="fieldNama" class="form-control border-start-0" placeholder="Tuliskan nama lengkap warga pemohon (misal: Budi Santoso)" required>
                                </div>
                            </div>

                            <!-- NOMOR KTP / NIK -->
                            <div class="col-md-6">
                                <label class="form-label">Nomor KTP / NIK Pemohon <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-id-card text-success"></i></span>
                                    <input type="text" name="instansi" id="fieldKtp" class="form-control border-start-0" placeholder="Masukkan 16 digit Nomor KTP / NIK warga" required minlength="5" maxlength="255">
                                </div>
                                <small class="text-muted" style="font-size: 0.78rem;">Wajib diisi sesuai identitas KTP pemohon (contoh: 330809xxxxxxxxxx).</small>
                            </div>

                            <!-- 4. ALAMAT -->
                            <div class="col-md-12">
                                <label class="form-label">4. Alamat Lengkap Pemohon <span class="text-danger">*</span></label>
                                <textarea name="alamat" id="fieldAlamat" class="form-control" rows="2" placeholder="Tuliskan jalan, nomor rumah, RT/RW, lingkungan / dusun pemohon..." required></textarea>
                            </div>

                            <!-- JENIS SURAT (KATEGORI) -->
                            <div class="col-md-6">
                                <label class="form-label">Jenis Surat Yang Diminta <span class="text-danger">*</span></label>
                                <select name="kategori" id="fieldKategori" class="form-select" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= esc($cat) ?>"><?= esc($cat) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- STATUS PELAYANAN -->
                            <div class="col-md-6">
                                <label class="form-label">Status Pelayanan Surat <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="Dalam Proses" selected>Dalam Proses</option>
                                    <option value="Siap Diambil">Siap Diambil</option>
                                    <option value="Selesai">Selesai (Sudah Diberikan ke Warga)</option>
                                    <option value="Direncanakan">Direncanakan</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>

                            <!-- 5. KETERANGAN -->
                            <div class="col-md-12">
                                <label class="form-label">5. Keterangan / Rincian Surat Yang Diminta & Keperluan <span class="text-danger">*</span></label>
                                <textarea name="keterangan" id="fieldKeterangan" class="form-control" rows="4" placeholder="Tuliskan rincian surat yang diminta warga dan untuk keperluan apa (contoh: Permohonan Surat Keterangan Usaha Warung Makan Berkah untuk pengajuan pinjaman modal KUR Bank BRI)..." required></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="<?= base_url('agenda') ?>" class="btn btn-outline-secondary rounded-3 px-4">Batal</a>
                            <button type="submit" class="btn btn-gov-primary px-4">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pencatatan Surat
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

        function applyPreset(categoryName, defaultDesc) {
            const kategoriSelect = document.getElementById('fieldKategori');
            const keteranganArea = document.getElementById('fieldKeterangan');

            let found = false;
            for (let i = 0; i < kategoriSelect.options.length; i++) {
                if (kategoriSelect.options[i].value === categoryName) {
                    kategoriSelect.selectedIndex = i;
                    found = true;
                    break;
                }
            }
            if (!found) {
                const opt = document.createElement('option');
                opt.value = categoryName;
                opt.textContent = categoryName;
                opt.selected = true;
                kategoriSelect.appendChild(opt);
            }

            keteranganArea.value = defaultDesc;
            keteranganArea.focus();
        }

        // Otomatis sinkronkan bulan dan tahun pada nomor surat jika tanggal permohonan diubah
        const fieldTanggal = document.getElementById('fieldTanggal');
        const fieldNomor = document.getElementById('fieldNomor');
        if (fieldTanggal && fieldNomor) {
            fieldTanggal.addEventListener('change', function() {
                const val = this.value;
                if (!val) return;
                const parts = val.split('-');
                if (parts.length === 3) {
                    const year = parts[0];
                    const month = parts[1];
                    const currentVal = fieldNomor.value;
                    const match = currentVal.match(/^(B\s*\/\s*140\s*\/\s*\d+)\s*\/\s*\d+\s*\/\s*\d+/i);
                    if (match) {
                        fieldNomor.value = match[1] + " / " + month + " / " + year;
                    }
                }
            });
        }
    </script>
</body>
</html>
