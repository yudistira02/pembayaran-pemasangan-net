<?= $this->extend('layout/home') ?>

<?= $this->section('content') ?>

<div class="flex justify-center items-center py-32">
    <div>
        <div class="font-semibold text-4xl text-center mb-10"><?= $title ?></div>
        <?= $this->include('components/flash') ?>
        <div class="flex justify-between items-center mx-32 gap-10">
            <?php foreach($data as $paket): ?>
            <div class="min-w-[400px] min-h-[400px] bg-white rounded-lg text-black shadow-2xl">
                <div class="flex justify-center items-center py-20">
                    <div>
                        <div class="flex justify-center items-center mb-10 font-bold text-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-32 h-32">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />
                            </svg>
                        </div>
                        <div class="flex justify-center items-center mb-10 font-bold text-2xl">
                            <?= $paket['nama'] ?>
                        </div>
                        <div class="flex justify-center items-center mb-10 text-xl font-extralight">
                            Bandwith <?= $paket['kecepatan'] ?> Mbps
                        </div>
                        <div class="flex justify-center items-center mb-10 font-semibold">
                            <?= "Rp " . number_format($paket['harga'], 0, ',', '.') ?>
                        </div>
                        <div class="flex justify-center items-center">
                            <a href="<?= session()->pelanggan === false ? base_url('home/lengkapi/informasi/'.session()->id) : '#' ?>" class="text-xl font-bold transition duration-300 uppercase py-2 px-5 rounded-2xl bg-sky-500 border-2 border-white text-white hover:bg-white hover:text-sky-500 hover:border-sky-500 hover:border-2">pesan</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

</script>

<?= $this->endSection() ?>
