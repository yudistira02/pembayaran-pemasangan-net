<?= $this->extend('layout/home') ?>

<?= $this->section('content') ?>

<div class="flex justify-center items-center py-32">
    <div class="container mx-auto py-8">
        <div class="flex justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="rotate-45 w-32 h-32">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-center mb-8">Selamat Datang di Halaman Informasi Provider <span class="text-black"><?= env('APP_NAME') ?></span>.</h1>

        <div class="max-w-3xl mx-auto">
            <h2 class="text-xl font-semibold mb-4">Mengapa Memilih Provider Lokal yang Unggul?</h2>
            <p class="mb-6">Ketika mencari layanan internet keandalan, kecepatan, dan layanan pelanggan yang baik adalah kunci. Di tengah pasar yang semakin berkembang, provider lokal yang unggul sering kali menawarkan keunggulan yang tidak dimiliki oleh perusahaan besar.</p>

            <h2 class="text-xl font-semibold mb-4">Keunggulan Provider Lokal:</h2>
            <ul class="list-disc pl-6 mb-6">
                <li>Koneksi Cepat dan Stabil</li>
                <li>Layanan Pelanggan yang Personal</li>
                <li>Dukungan Komunitas</li>
                <li>Paket yang Disesuaikan</li>
            </ul>

            <h2 class="text-xl font-semibold mb-4">Mengapa Kami?</h2>
            <p class="mb-6">Di <span class="font-semibold"><?= env('APP_NAME') ?></span>, kami bangga menjadi salah satu provider lokal yang unggul di wilayah ini. Berikut adalah alasan mengapa Anda harus memilih kami:</p>

            <ul class="list-disc pl-6 mb-6">
                <li>Kecepatan dan Konsistensi</li>
                <li>Layanan Pelanggan yang Ramah</li>
                <li>Pilihan Paket yang Luas</li>
                <li>Komitmen pada Komunitas</li>
            </ul>

            <p class="mb-6">Jika Anda mencari provider lokal yang dapat diandalkan dengan layanan unggul, <span class="font-semibold">[Nama Provider]</span> adalah pilihan yang tepat untuk Anda. Hubungi kami hari ini untuk mendapatkan lebih banyak informasi tentang paket layanan kami dan mulailah menikmati koneksi yang andal dan layanan pelanggan yang luar biasa!</p>
        </div>

        <div class="max-w-3xl mx-auto">
            <h2 class="text-xl font-semibold mb-4">Keluhan</h2>
            <div>Hubungi Nomor Berikut: <span class="">081232799306</span></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

</script>

<?= $this->endSection() ?>
