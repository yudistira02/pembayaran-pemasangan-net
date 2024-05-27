<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="flex justify-center items-center">
    <div class="w-full">
        <?php if (session()->has('message')) : ?>
            <div class="alert alert-success">
                <?= session('message') ?>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('dashboard/laporan/update/'.$data['id']) ?>" method="POST">
            <div class="block">
                <div class="w-1/2 mt-5">
                    <label for="keluhan" class="block font-medium text-black">Keluhan</label>
                    <textarea type="text" id="keluhan" name="keluhan" class="mt-1 p-2 bg-gray-200 text-gray-500 rounded-lg w-full" required><?= $data['keluhan'] ?></textarea>
                </div>        
            </div>
            <div class="block mt-5">
                <button type="submit" class="transition duration-300 bg-[#5AB2FF] rounded-lg py-2 px-5 text-white border-2 border-white font-bold">Kirim</button>       
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    
</script>

<?= $this->endSection() ?>
