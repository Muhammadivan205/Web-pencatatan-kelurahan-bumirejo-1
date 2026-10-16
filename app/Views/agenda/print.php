<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Buku Register Pelayanan Surat - Kelurahan Bumirejo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #ffffff;
            color: #000000;
            padding: 20px;
        }

        /* Kop Surat Official Government */
        .kop-surat {
            border-bottom: 3px double #000000;
            padding-bottom: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .kop-title h4 {
            font-size: 15pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .kop-title h3 {
            font-size: 17pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .kop-title h2 {
            font-size: 19pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop-title p {
            font-size: 9.5pt;
            margin: 3px 0 0 0;
            font-style: italic;
        }

        .table-print {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5pt;
        }

        .table-print th, .table-print td {
            border: 1px solid #000000;
            padding: 7px 9px;
            vertical-align: top;
        }

        .table-print th {
            background-color: #f2f2f2 !important;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10pt;
        }

        .ttd-section {
            margin-top: 35px;
            display: flex;
            justify-content: space-between;
        }

        .ttd-box {
            width: 270px;
            text-align: center;
            font-size: 11pt;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Action Bar for Print Page -->
    <div class="no-print mb-4 p-3 bg-light border rounded-3 d-flex justify-content-between align-items-center">
        <div>
            <strong class="text-success"><i class="fa-solid fa-file-signature me-1"></i> Pratinjau Cetak Buku Register Pelayanan Surat</strong>
            <small class="d-block text-muted">Buku register resmi pencatatan permohonan surat warga (Nomor, Tanggal, Nama, Alamat, Keterangan).</small>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-success fw-bold me-2"><i class="fa-solid fa-print me-1"></i> Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn btn-outline-secondary">Tutup</button>
        </div>
    </div>

    <!-- KOP SURAT RESMI -->
    <div class="kop-surat">
        <img src="<?= base_url('images/logo-magelang.svg') ?>" alt="Logo Kabupaten Magelang" style="position: absolute; left: 15px; top: 0; width: 75px; height: auto;">
        <div class="kop-title">
            <h4>PEMERINTAH KABUPATEN MAGELANG</h4>
            <h3>KECAMATAN MUNGKID</h3>
            <h2>KELURAHAN BUMIREJO</h2>
            <p>Jl. Bumirejo, Kec. Mungkid, Kab. Magelang, Jawa Tengah 56512 • Website: magelangkab.go.id • Email: kelurahan.bumirejo@magelangkab.go.id</p>
        </div>
    </div>

    <div class="text-center mb-4">
        <h5 class="fw-bold text-decoration-underline mb-1" style="font-size: 13.5pt;">BUKU REGISTER PENCATATAN PELAYANAN SURAT WARGA</h5>
        <p class="small text-muted mb-0">
            Periode: <?= !empty($filters['tgl_awal']) ? date('d/m/Y', strtotime($filters['tgl_awal'])) : 'Semua Periode' ?> 
            <?= !empty($filters['tgl_akhir']) ? ' s/d ' . date('d/m/Y', strtotime($filters['tgl_akhir'])) : '' ?>
        </p>
    </div>

    <!-- REKAP DATA TABLE: NOMOR, TANGGAL, NAMA, ALAMAT, KETERANGAN -->
    <table class="table-print">
        <thead>
            <tr>
                <th style="width: 4%;">NO</th>
                <th style="width: 17%;">1. NOMOR REGISTER</th>
                <th style="width: 12%;">2. TANGGAL</th>
                <th style="width: 20%;">3. NAMA PEMOHON</th>
                <th style="width: 20%;">4. ALAMAT</th>
                <th>5. KETERANGAN (SURAT YANG DIMINTA)</th>
                <th style="width: 11%;">STATUS / PARAF</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($agenda)): ?>
                <tr>
                    <td colspan="7" class="text-center italic py-4">Belum ada data pencatatan surat pada periode ini.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($agenda as $item): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                            <strong><?= esc($item['nomor_agenda']) ?></strong>
                        </td>
                        <td class="text-center">
                            <?= date('d/m/Y', strtotime($item['tanggal'])) ?>
                        </td>
                        <td>
                            <strong><?= esc($item['nama']) ?></strong>
                            <?php if (!empty($item['instansi'])): ?>
                                <br><small class="text-muted">NIK: <?= esc($item['instansi']) ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($item['alamat']) ?></td>
                        <td>
                            <strong>[<?= esc($item['kategori'] ?: 'Surat Keterangan') ?>]</strong><br>
                            <?= esc($item['keterangan'] ?? '-') ?>
                        </td>
                        <td class="text-center" style="font-size: 9.5pt;">
                            <?= esc($item['status']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- TANDA TANGAN SECTION -->
    <div class="ttd-section">
        <div class="ttd-box">
            <p class="mb-1">&nbsp;</p>
            <p class="mb-5">Pengadministrasi Pelayanan Umum,</p>
            <br><br>
            <p class="mb-0"><strong>RATNA SARI, A.MD</strong></p>
            <p class="mb-0">NIP. 19890415 201402 2 003</p>
        </div>
        <div class="ttd-box">
            <p class="mb-1">Bumirejo, <?= esc($print_date) ?></p>
            <p class="mb-5">Mengetahui,<br><strong>Lurah Bumirejo</strong></p>
            <br><br>
            <p class="mb-0"><strong>H. DRS. BUDI SANTOSO, M.SI</strong></p>
            <p class="mb-0">NIP. 19780512 200312 1 004</p>
        </div>
    </div>

</body>
</html>
