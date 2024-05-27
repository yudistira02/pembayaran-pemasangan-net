<?= $this->extend('layout/home') ?>

<?= $this->section('content') ?>

<div class="py-32 flex justify-center items-center">
    <div class="w-full">
        <div class="font-semibold text-4xl mb-10"><?= $title ?></div>
        <?php if (session()->has('message')) : ?>
            <div class="alert alert-success">
                <?= session('message') ?>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('home/laporan/saya/update/'.session()->id) ?>" method="POST">
            <div class="block">
                <div class="w-1/2 mt-5">
                    <label for="keluhan" class="block font-medium text-white">Keluhan</label>
                    <textarea type="text" id="keluhan" name="keluhan" class="mt-1 p-2 bg-white text-gray-500 rounded-lg w-full" required><?= $data['keluhan'] ?></textarea>
                </div>        
            </div>
            <div class="block mt-5">
                <button type="submit" class="transition duration-300 bg-[#5AB2FF] hover:bg-white rounded-lg py-2 px-5 text-white hover:text-sky-500 border-2 border-white font-bold">Kirim</button>       
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    
</script>

<?= $this->endSection() ?>
