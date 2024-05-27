<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="py-5 w-full">
    <?php if (session()->has('message')) : ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('dashboard/rekap/jadwal/create') ?>" method="post">
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="start_date" class="block font-medium text-gray-700">Waktu Mulai</label>
                <input type="date" id="start_date" name="start_date" placeholder="Masukan Start_date" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="" required>
            </div>        
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="end_date" class="block font-medium text-gray-700">Waktu Akhir</label>
                <input type="date" id="end_date" name="end_date" placeholder="Masukan End_date" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="" required>
            </div>        
        </div>
        <div class="block mt-5">
            <button type="submit" class="bg-sky-500 rounded-lg p-2 text-white">Simpan</button>       
        </div>
    </form>
</div>

<?= $this->endSection() ?>
