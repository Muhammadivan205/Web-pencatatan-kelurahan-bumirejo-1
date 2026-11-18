<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Sistem - Kelurahan Bumirejo</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Paksa semua form input menjadi gelap/hitam pekat dengan teks putih terang */
        input, select, textarea {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border-color: #334155 !important;
        }
        input:focus, select:focus, textarea:focus {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border-color: #10b981 !important;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25) !important;
            outline: none !important;
        }
        /* Mencegah autofill browser Google Chrome / Brave / Edge mengubah background menjadi putih */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active,
        textarea:-webkit-autofill,
        select:-webkit-autofill {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
            box-shadow: 0 0 0px 1000px #0f172a inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-4">
    <div class="bg-slate-800 p-8 rounded-2xl shadow-2xl w-full max-w-lg border border-slate-700 my-8">
        
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-white rounded-xl p-2 mx-auto mb-3 flex items-center justify-center shadow-lg">
                <img src="<?= base_url('images/logo-magelang.svg') ?>" alt="Logo Kabupaten Magelang" class="w-full h-full object-contain">
            </div>
            <h1 class="text-2xl font-bold text-white">Kelurahan Bumirejo</h1>
            <p class="text-slate-400 text-xs mt-1">Registrasi Akun Baru • Sistem Pelayanan Surat Warga</p>
        </div>

        <!-- Alert Notifikasi Flashdata -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-rose-500/10 border border-rose-500 text-rose-300 p-3.5 rounded-xl text-xs mb-4 flex items-start gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-400 mt-0.5 shrink-0"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-rose-500/10 border border-rose-500 text-rose-300 p-3.5 rounded-xl text-xs mb-4">
                <div class="font-bold mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-exclamation text-rose-400"></i> Mohon perbaiki data berikut:
                </div>
                <ul class="list-disc list-inside space-y-0.5 ml-2 text-[11px]">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register/process') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <!-- PILIHAN ROLE / PERAN -->
            <div>
                <label class="block text-slate-300 text-xs font-semibold mb-2">
                    Pilih Peran Akun yang Didaftarkan <span class="text-rose-400">*</span>
                </label>
                <div class="grid grid-cols-3 gap-2">
                    <!-- Role: Warga -->
                    <label class="relative flex flex-col items-center justify-center p-3 rounded-xl border border-slate-700 bg-slate-900 cursor-pointer hover:border-emerald-500 transition text-center role-option has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-950/40">
                        <input type="radio" name="role" value="warga" checked class="sr-only" onchange="switchRole('warga')">
                        <i class="fa-solid fa-house-user text-emerald-400 text-base mb-1"></i>
                        <span class="text-xs font-bold text-white block">Warga</span>
                        <span class="text-[9px] text-slate-400">Masyarakat</span>
                    </label>

                    <!-- Role: Admin -->
                    <label class="relative flex flex-col items-center justify-center p-3 rounded-xl border border-slate-700 bg-slate-900 cursor-pointer hover:border-emerald-500 transition text-center role-option has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-950/40">
                        <input type="radio" name="role" value="admin" class="sr-only" onchange="switchRole('admin')">
                        <i class="fa-solid fa-user-gear text-amber-400 text-base mb-1"></i>
                        <span class="text-xs font-bold text-white block">Admin</span>
                        <span class="text-[9px] text-slate-400">Petugas Kelurahan</span>
                    </label>

                    <!-- Role: Pejabat -->
                    <label class="relative flex flex-col items-center justify-center p-3 rounded-xl border border-slate-700 bg-slate-900 cursor-pointer hover:border-emerald-500 transition text-center role-option has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-950/40">
                        <input type="radio" name="role" value="pejabat" class="sr-only" onchange="switchRole('pejabat')">
                        <i class="fa-solid fa-stamp text-teal-400 text-base mb-1"></i>
                        <span class="text-xs font-bold text-white block">Pejabat</span>
                        <span class="text-[9px] text-slate-400">Lurah / Pimpinan</span>
                    </label>
                </div>
            </div>

            <!-- NIK Pemohon / Petugas -->
            <div>
                <label id="labelNik" class="block text-slate-300 text-xs font-semibold mb-1">
                    NIK (Nomor Induk Kependudukan) <span class="text-rose-400">*</span>
                </label>
                <div class="relative">
                    <input type="text" name="nik" id="fieldNikRegister" maxlength="16" required value="<?= esc(old('nik')) ?>" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 font-mono tracking-wider" placeholder="Contoh: 330809xxxxxxxxxx">
                    <span id="spinNik" class="hidden absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs">
                        <i class="fa-solid fa-spinner fa-spin"></i>
                    </span>
                </div>
                <!-- Box Status Validasi Otomatis -->
                <div id="statusValidasiNik" class="hidden mt-2 text-xs rounded-xl p-3 transition"></div>
                <p id="hintNik" class="text-[10px] text-slate-500 mt-1">Sistem otomatis mencocokkan NIK Anda dengan Buku Induk Kependudukan Kelurahan Bumirejo.</p>
            </div>

            <!-- Nama Lengkap Sesuai KTP / Pegawai -->
            <div>
                <label class="block text-slate-300 text-xs font-semibold mb-1">
                    Nama Lengkap <span class="text-rose-400">*</span>
                </label>
                <input type="text" name="nama" id="fieldNamaRegister" required readonly value="<?= esc(old('nama')) ?>" style="background-color: #0f172a !important; color: #ffffff !important;" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 cursor-not-allowed opacity-80" placeholder="Otomatis terisi setelah NIK divalidasi">
            </div>

            <!-- Alamat Domisili / Instansi -->
            <div>
                <label id="labelAlamat" class="block text-slate-300 text-xs font-semibold mb-1">
                    Alamat Domisili Bumirejo
                </label>
                <input type="text" name="alamat" id="fieldAlamatRegister" readonly value="<?= esc(old('alamat')) ?>" style="background-color: #0f172a !important; color: #ffffff !important;" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 cursor-not-allowed opacity-80" placeholder="Otomatis terisi (RT / RW, Dusun)">
            </div>

            <!-- Nomor WhatsApp / HP -->
            <div>
                <label class="block text-slate-300 text-xs font-semibold mb-1">
                    Nomor WhatsApp / HP Aktif <span class="text-slate-500 font-normal">(opsional)</span>
                </label>
                <input type="text" name="no_hp" value="<?= esc(old('no_hp')) ?>" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500" placeholder="08xxxxxxxxxx">
            </div>

            <!-- Password & Konfirmasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-slate-300 text-xs font-semibold mb-1">
                        Password <span class="text-rose-400">*</span>
                    </label>
                    <input type="password" name="password" required minlength="6" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500" placeholder="Minimal 6 karakter">
                </div>
                <div>
                    <label class="block text-slate-300 text-xs font-semibold mb-1">
                        Ulangi Password <span class="text-rose-400">*</span>
                    </label>
                    <input type="password" name="password_confirm" required minlength="6" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500" placeholder="Ketik ulang password">
                </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" id="btnRegister" disabled class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 rounded-xl transition duration-200 shadow-lg shadow-emerald-900/20 text-xs flex items-center justify-center gap-1.5 cursor-not-allowed opacity-50 mt-2">
                <i class="fa-solid fa-user-check"></i> <span id="labelTombolDaftar">Daftar Akun Warga</span>
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-slate-700 text-center text-xs text-slate-400">
            Sudah memiliki akun? 
            <a href="<?= base_url('login') ?>" class="text-emerald-400 font-bold hover:underline">Masuk ke Sistem</a>
        </div>
    </div>

    <!-- Script Live NIK Validation & Role Switcher -->
    <script>
        let currentRole = 'warga';
        const inputNik = document.getElementById('fieldNikRegister');
        const boxStatus = document.getElementById('statusValidasiNik');
        const inputNama = document.getElementById('fieldNamaRegister');
        const inputAlamat = document.getElementById('fieldAlamatRegister');
        const btnRegister = document.getElementById('btnRegister');
        const spinNik = document.getElementById('spinNik');
        const labelTombol = document.getElementById('labelTombolDaftar');
        const labelAlamat = document.getElementById('labelAlamat');
        const hintNik = document.getElementById('hintNik');

        function switchRole(role) {
            currentRole = role;

            if (role === 'warga') {
                labelTombol.innerText = 'Daftar & Verifikasi Akun Warga';
                labelAlamat.innerText = 'Alamat Domisili Bumirejo';
                hintNik.innerText = 'Sistem otomatis mencocokkan NIK Anda dengan Buku Induk Kependudukan Kelurahan Bumirejo.';
                
                // Set field nama & alamat jadi readonly auto-fill dengan tema gelap
                inputNama.readOnly = true;
                inputNama.className = 'w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 cursor-not-allowed opacity-80';
                inputNama.style.backgroundColor = '#0f172a';
                inputNama.style.color = '#ffffff';
                inputNama.placeholder = 'Otomatis terisi setelah NIK divalidasi';
                
                inputAlamat.readOnly = true;
                inputAlamat.className = 'w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 cursor-not-allowed opacity-80';
                inputAlamat.style.backgroundColor = '#0f172a';
                inputAlamat.style.color = '#ffffff';
                inputAlamat.placeholder = 'Otomatis terisi (RT / RW, Dusun)';

                checkNikWarga(inputNik.value.trim());
            } else {
                const titleRole = role === 'admin' ? 'Administrator' : 'Pejabat';
                labelTombol.innerText = 'Daftar Akun ' + titleRole;
                labelAlamat.innerText = 'Unit Kerja / Kantor Alamat';
                hintNik.innerText = 'Masukkan 16 digit NIK/Identitas resmi aparatur Kelurahan Bumirejo.';

                // Field nama & alamat aktif diketik dengan warna background hitam/gelap
                inputNama.readOnly = false;
                inputNama.className = 'w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500';
                inputNama.style.backgroundColor = '#0f172a';
                inputNama.style.color = '#ffffff';
                inputNama.placeholder = role === 'admin' ? 'Contoh: Ahmad Fauzi, S.Kom (Petugas Pelayanan)' : 'Contoh: Muhammad Nur (Lurah Bumirejo)';
                
                inputAlamat.readOnly = false;
                inputAlamat.className = 'w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500';
                inputAlamat.style.backgroundColor = '#0f172a';
                inputAlamat.style.color = '#ffffff';
                if (!inputAlamat.value || inputAlamat.value.startsWith('RT ')) inputAlamat.value = 'Kantor Kelurahan Bumirejo';

                // Tampilkan box info aparatur
                boxStatus.classList.remove('hidden');
                boxStatus.className = 'mt-2 text-xs rounded-xl p-3 bg-amber-500/10 border border-amber-500 text-amber-300';
                boxStatus.innerHTML = `
                    <div class="font-bold flex items-center gap-1.5 text-amber-400">
                        <i class="fa-solid fa-id-badge"></i> Registrasi Akun ${titleRole} Kelurahan
                    </div>
                    <div class="mt-1 text-[11px] text-slate-300">
                        Pastikan memasukkan 16 digit NIK/Identitas dinas dan nama lengkap beserta gelar resmi.
                    </div>
                `;

                if (inputNik.value.trim().length === 16) {
                    btnRegister.disabled = false;
                    btnRegister.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    btnRegister.disabled = true;
                    btnRegister.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        function checkNikWarga(nik) {
            if (currentRole !== 'warga') {
                if (nik.length === 16) {
                    btnRegister.disabled = false;
                    btnRegister.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    btnRegister.disabled = true;
                    btnRegister.classList.add('opacity-50', 'cursor-not-allowed');
                }
                return;
            }

            if (nik.length === 16) {
                spinNik.classList.remove('hidden');
                boxStatus.classList.remove('hidden');
                boxStatus.className = 'mt-2 text-xs rounded-xl p-3 bg-slate-950 text-slate-400 border border-slate-800';
                boxStatus.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Mencocokkan NIK dengan Buku Induk Kependudukan Kelurahan Bumirejo...';

                fetch('<?= base_url('api/cek-nik/') ?>' + nik)
                    .then(res => res.json())
                    .then(data => {
                        spinNik.classList.add('hidden');
                        if (data.valid) {
                            boxStatus.className = 'mt-2 text-xs rounded-xl p-3 bg-emerald-500/10 border border-emerald-500 text-emerald-300';
                            boxStatus.innerHTML = `
                                <div class="font-bold flex items-center gap-1.5 text-emerald-400">
                                    <i class="fa-solid fa-circle-check"></i> Warga Sah Kelurahan Bumirejo Terverifikasi!
                                </div>
                                <div class="mt-1 text-[11px] text-slate-300">
                                    Nama: <strong>${data.data.nama}</strong> | RT ${data.data.rt} / RW ${data.data.rw}, Dusun ${data.data.dusun}
                                </div>
                            `;
                            inputNama.value = data.data.nama;
                            inputAlamat.value = `RT ${data.data.rt} / RW ${data.data.rw}, Dusun ${data.data.dusun}, Kel. Bumirejo`;
                            btnRegister.disabled = false;
                            btnRegister.classList.remove('opacity-50', 'cursor-not-allowed');
                        } else {
                            boxStatus.className = 'mt-2 text-xs rounded-xl p-3 bg-rose-500/10 border border-rose-500 text-rose-300';
                            boxStatus.innerHTML = `
                                <div class="font-bold flex items-center gap-1.5 text-rose-400">
                                    <i class="fa-solid fa-triangle-exclamation"></i> PENDAFTARAN DITOLAK
                                </div>
                                <div class="mt-1 text-[11px] text-rose-200">
                                    ${data.alasan}
                                </div>
                            `;
                            inputNama.value = '';
                            inputAlamat.value = '';
                            btnRegister.disabled = true;
                            btnRegister.classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    })
                    .catch(() => {
                        spinNik.classList.add('hidden');
                    });
            } else if (nik.length > 0 && nik.length < 16) {
                boxStatus.classList.remove('hidden');
                boxStatus.className = 'mt-2 text-xs rounded-xl p-2 bg-slate-950 text-slate-400 border border-slate-800';
                boxStatus.innerText = `Ketik 16 digit NIK (${nik.length}/16 digit)`;
                btnRegister.disabled = true;
                btnRegister.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                boxStatus.classList.add('hidden');
                btnRegister.disabled = true;
                btnRegister.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        if (inputNik) {
            inputNik.addEventListener('input', function() {
                const nik = this.value.trim().replace(/\D/g, '');
                this.value = nik;
                checkNikWarga(nik);
            });

            if (inputNik.value.trim().length === 16) {
                checkNikWarga(inputNik.value.trim());
            }
        }
    </script>
</body>
</html>
