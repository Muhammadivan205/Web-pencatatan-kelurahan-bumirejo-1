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
            padding: 30px;
        }

        .receipt-card {
            max-width: 750px;
            margin: 0 auto;
            border: 2px dashed #334155;
            padding: 25px;
            border-radius: 12px;
            background: #ffffff;
        }

        .kop-surat {
            border-bottom: 2px solid #000000;
            padding-bottom: 12px;
            margin-bottom: 20px;
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
            width: 65px;
            height: auto;
        }

        .kop-title h4 {
            font-size: 12pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .kop-title h3 {
            font-size: 14pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .kop-title h2 {
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop-title p {
            font-size: 8.5pt;
            margin: 3px 0 0 0;
            font-style: italic;
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
            max-width: 750px;
            margin-left: auto;
            margin-right: auto;
        }

        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Bar Tombol Cetak -->
    <div class="no-print-bar shadow-sm">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-receipt text-success fs-5"></i>
            <div>
                <strong>Tanda Terima Permohonan Surat Warga</strong>
                <div class="small text-light opacity-75">Simpan atau cetak bukti ini untuk pengambilan berkas di kantor kelurahan</div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-success btn-sm fw-bold px-3">
                <i class="fa-solid fa-print me-1"></i> Cetak Bukti
            </button>
            <button onclick="window.close()" class="btn btn-outline-light btn-sm px-3">
                Tutup
            </button>
        </div>
    </div>

    <div class="receipt-card shadow-sm">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <img src="<?= base_url('images/logo-magelang.svg') ?>" alt="Logo Kabupaten Magelang" class="kop-logo">
            <div class="kop-title">
                <h4>Pemerintah Kabupaten Magelang</h4>
                <h3>Kecamatan Mungkid</h3>
                <h2>Kelurahan Bumirejo</h2>
                <p>Jalan Mayor Unus No. 12 Bumirejo, Mungkid, Magelang, Jawa Tengah 56512</p>
            </div>
        </div>

        <div class="text-center mb-4">
            <h5 class="fw-bold text-uppercase text-decoration-underline mb-1">Bukti Registrasi / Tanda Terima Permohonan Surat</h5>
            <div class="font-monospace fw-bold fs-6 text-success">
                NOMOR REGISTER: <?= esc($agenda['nomor_agenda']) ?>
            </div>
        </div>

        <table class="table table-sm table-borderless mb-4" style="font-size: 10.5pt;">
            <tr>
                <td style="width: 32%;" class="fw-bold">Tanggal Pengajuan</td>
                <td style="width: 3%;">:</td>
                <td><?= date('d F Y', strtotime($agenda['tanggal'])) ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Nama Pemohon</td>
                <td>:</td>
                <td class="fw-bold"><?= esc($agenda['nama']) ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Nomor NIK (KTP)</td>
                <td>:</td>
                <td class="font-monospace"><?= esc($agenda['instansi']) ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Alamat Domisili</td>
                <td>:</td>
                <td><?= esc($agenda['alamat']) ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Surat Yang Dimohon</td>
                <td>:</td>
                <td class="fw-bold text-uppercase"><?= esc($agenda['kategori']) ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Keperluan / Keterangan</td>
                <td>:</td>
                <td><?= esc($agenda['keterangan']) ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Status Saat Ini</td>
                <td>:</td>
                <td>
                    <span class="badge bg-dark px-2 py-1"><?= esc($agenda['status']) ?></span>
                    <?php if (!empty($agenda['disetujui_oleh'])): ?>
                        <span class="badge bg-success ms-1">Disahkan: <?= esc($agenda['disetujui_oleh']) ?></span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <div class="alert alert-secondary p-2.5 small mb-4" style="font-size: 9pt;">
            <strong><i class="fa-solid fa-circle-exclamation me-1"></i> Ketentuan Pengambilan Surat:</strong>
            <ol class="mb-0 ps-3 mt-1">
                <li>Surat fisik yang telah siap diambil dapat diambil di loket Pelayanan Kantor Kelurahan Bumirejo pada jam kerja (Senin - Jumat, 08.00 - 15.00 WIB).</li>
                <li>Wajib membawa Kartu Tanda Penduduk (KTP) asli dan memperlihatkan bukti tanda terima ini (cetak atau dari layar ponsel).</li>
                <li>Pelayanan surat warga tidak dipungut biaya (GRATIS).</li>
            </ol>
        </div>

        <div class="row pt-2" style="font-size: 10pt;">
            <div class="col-6 text-center">
                <div class="text-muted small">Pemohon / Warga,</div>
                <div style="height: 60px;"></div>
                <div class="fw-bold text-decoration-underline"><?= esc($agenda['nama']) ?></div>
            </div>
            <div class="col-6 text-center">
                <div class="text-muted small">Bumirejo, <?= date('d F Y') ?><br>Petugas Pelayanan Kelurahan,</div>
                <div style="height: 45px;"></div>
                <div class="fw-bold text-decoration-underline">Petugas Loket Pelayanan</div>
                <div class="small text-muted">Kelurahan Bumirejo</div>
            </div>
        </div>
    </div>

</body>
</html>
