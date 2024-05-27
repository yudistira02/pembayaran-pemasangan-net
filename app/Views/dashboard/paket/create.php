<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="py-5 w-full">
    <?php if (session()->has('message')) : ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('dashboard/paket/create') ?>" method="post">
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="nama" class="block font-medium text-gray-700">Nama Paket</label>
                <input type="text" id="nama" name="nama" placeholder="Masukan Nama" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="" required>
            </div>        
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="kecepatan" class="block font-medium text-gray-700">Kecepatan (MB/s)</label>
                <input type="number" id="kecepatan" name="kecepatan" placeholder="Masukan Kecepatan" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="" required>
            </div>        
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="harga" class="block font-medium text-gray-700">Harga</label>
                <input type="number" id="harga" name="harga" placeholder="Masukan Harga" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="" required>
            </div>        
        </div>
        <div class="block mt-5">
            <button type="submit" class="bg-sky-500 rounded-lg p-2 text-white">Simpan</button>       
        </div>
    </form>
</div>

<?= $this->endSection() ?>
