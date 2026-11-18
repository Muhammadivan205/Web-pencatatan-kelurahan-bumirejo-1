<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kelurahan Bumirejo</title>
    <!-- Menggunakan Tailwind CSS agar tampilannya modern dan rapi -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
            box-shadow: 0 0 0px 1000px #0f172a inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen">
    <div class="bg-slate-800 p-8 rounded-xl shadow-2xl w-full max-w-md border border-slate-700">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-white">Kelurahan Bumirejo</h1>
            <p class="text-slate-400 text-sm mt-1">Sistem Pencatatan & Pelayanan Surat Warga</p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-emerald-500/10 border border-emerald-500 text-emerald-300 p-3 rounded-lg text-sm mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-500/10 border border-red-500 text-red-400 p-3 rounded-lg text-sm mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login/process') ?>" method="post" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-1">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" name="nik" required class="w-full bg-slate-900 border border-slate-750 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-emerald-500 font-mono" placeholder="Masukkan 16 digit NIK">
            </div>

            <div>
                <label class="block text-slate-300 text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required class="w-full bg-slate-900 border border-slate-750 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-emerald-500" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-medium py-2.5 rounded-lg transition duration-200 shadow-lg shadow-emerald-900/20 cursor-pointer">
                Masuk Sistem
            </button>

            <div class="text-center pt-2">
                <p class="text-xs text-slate-400">
                    Belum punya akun? 
                    <a href="<?= base_url('register') ?>" class="text-emerald-400 font-bold hover:underline">Daftar Akun Baru (Warga / Admin / Pejabat)</a>
                </p>
            </div>
        </form>

        <div class="mt-6 text-xs text-slate-500 text-center space-y-1">
            <p><strong>Akun Demo:</strong></p>
            <p>Admin: <code class="text-slate-400">3308090101010001</code> / <code class="text-slate-400">admin123</code></p>
            <p>Pejabat (Lurah): <code class="text-slate-400">3308090202020002</code> / <code class="text-slate-400">pejabat123</code> — Muhammad Nur</p>
            <p>Warga: <code class="text-slate-400">3308092408990001</code> / <code class="text-slate-400">warga123</code></p>
        </div>
    </div>
</body>
</html>