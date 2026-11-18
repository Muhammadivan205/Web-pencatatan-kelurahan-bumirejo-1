<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #ffffff;
            color: #000000;
            padding: 25px;
        }

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

        .kop-logo {
            position: absolute;
            left: 10px;
            top: 5px;
            width: 75px;
            height: auto;
        }

        .kop-title h4 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .kop-title h3 {
            font-size: 16pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .kop-title h2 {
            font-size: 18pt;
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
            font-size: 10pt;
        }

        .table-print th, .table-print td {
            border: 1px solid #000000;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .table-print th {
            background-color: #f2f2f2 !important;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9.5pt;
        }

        .no-print-bar {
            background-color: #0f172a;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                padding: 0;
            }
            @page {
                size: landscape;
                margin: 15mm;
            }
        }
    </style>
</head>
<body>

    <!-- Bar Aksi (Hanya tampil di layar) -->
    <div class="no-print-bar shadow-sm">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-stamp text-success fs-5"></i>
            <div>
                <strong>Laporan Eksekutif Monitoring Pelayanan Surat</strong>
                <div class="small text-light opacity-75">Kelurahan Bumirejo, Kecamatan Mungkid, Kabupaten Magelang</div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-success btn-sm fw-bold px-3">
                <i class="fa-solid fa-print me-1"></i> Cetak Dokumen
            </button>
            <button onclick="window.close()" class="btn btn-outline-light btn-sm px-3">
                Tutup
            </button>
        </div>
    </div>

    <!-- Kop Surat Dinas -->
    <div class="kop-surat">
        <img src="<?= base_url('images/logo-magelang.svg') ?>" alt="Logo Kabupaten Magelang" class="kop-logo">
        <div class="kop-title">
            <h4>Pemerintah Kabupaten Magelang</h4>
            <h3>Kecamatan Mungkid</h3>
            <h2>Kelurahan Bumirejo</h2>
            <p>Jalan Mayor Unus No. 12 Bumirejo, Mungkid, Magelang, Jawa Tengah 56512 • Pos-el: kelurahan@bumirejo.magelangkab.go.id</p>
        </div>
    </div>

    <!-- Judul Laporan -->
    <div class="text-center mb-4">
        <h5 class="fw-bold text-uppercase text-decoration-underline mb-1">Laporan Rekapitulasi Pelayanan Surat Warga</h5>
        <div class="small">
            <?php if (!empty($tgl_awal) && !empty($tgl_akhir)): ?>
                Periode: <strong><?= date('d/m/Y', strtotime($tgl_awal)) ?> s.d. <?= date('d/m/Y', strtotime($tgl_akhir)) ?></strong>
            <?php else: ?>
                Periode: <strong>Semua Data Pelayanan Aktif</strong>
            <?php endif; ?>
            <?php if (!empty($kategori)): ?>
                | Kategori: <strong><?= esc($kategori) ?></strong>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabel Data Rekapitulasi -->
    <table class="table-print mb-4">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 16%;">Nomor Register</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 18%;">Nama Pemohon & NIK</th>
                <th style="width: 18%;">Alamat Pemohon</th>
                <th style="width: 16%;">Jenis Surat</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 10%;">Pengesahan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($agenda)): ?>
                <tr>
                    <td colspan="8" class="text-center py-4 fst-italic">Tidak ada data pelayanan surat pada periode ini.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($agenda as $index => $item): ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td class="fw-bold font-monospace"><?= esc($item['nomor_agenda']) ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                        <td>
                            <strong><?= esc($item['nama']) ?></strong><br>
                            <span class="text-muted" style="font-size: 8.5pt;">NIK: <?= esc($item['instansi']) ?></span>
                        </td>
                        <td><?= esc($item['alamat']) ?></td>
                        <td><?= esc($item['kategori']) ?></td>
                        <td class="text-center fw-bold"><?= esc($item['status']) ?></td>
                        <td class="text-center" style="font-size: 8.5pt;">
                            <?= !empty($item['disetujui_oleh']) ? 'Disahkan Lurah' : '-' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Ringkasan Statistik -->
    <div class="row mb-5" style="font-size: 10pt;">
        <div class="col-6">
            <table class="table table-sm table-bordered w-75">
                <tr>
                    <td class="bg-light fw-bold">Total Pelayanan Surat:</td>
                    <td class="fw-bold"><?= count($agenda) ?> Berkas</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Tanda Tangan Pejabat (Lurah Bumirejo) -->
    <div class="row mt-4" style="page-break-inside: avoid;">
        <div class="col-7"></div>
        <div class="col-5 text-center">
            <div>Bumirejo, <?= date('d F Y') ?></div>
            <div class="fw-bold text-uppercase mt-1">Lurah Bumirejo</div>
            <div style="height: 75px;"></div>
            <div class="fw-bold text-decoration-underline text-uppercase"><?= esc($pejabat) ?></div>
            <div class="small">Pembina Tingkat I / Gol. IV/b</div>
        </div>
    </div>

</body>
</html>
