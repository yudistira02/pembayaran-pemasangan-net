<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="py-5 w-full">
    <?php if (session()->has('message')) : ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('dashboard/pelanggan/update/'. $data['id']) ?>" method="post">
        <div class="hidden">
            <div class="w-1/2 mt-5">
                <label for="user_id" class="block font-medium text-gray-700">User ID</label>
                <input type="number" id="user_id" name="user_id" placeholder="Masukkan User ID" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['user_id'] ?>">
            </div>
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="nomor_whatsapp" class="block font-medium text-gray-700">Nomor WhatsApp</label>
                <input type="number" id="nomor_whatsapp" name="nomor_whatsapp" placeholder="Masukkan Nomor WhatsApp" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['nomor_whatsapp'] ?>" readonly>
            </div>
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="geolocation" class="block font-medium text-gray-700">Geolocation</label>
                <input type="text" id="geolocation" name="geolocation" placeholder="Masukkan Geolocation" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['geolocation'] ?>" readonly>
            </div>
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="alamat" class="block font-medium text-gray-700">Alamat</label>
                <input type="text" id="alamat" name="alamat" placeholder="Masukkan Alamat" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['alamat'] ?>" readonly>
            </div>
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="paket" class="block font-medium text-gray-700">Paket</label>
                <input type="text" id="paket" name="paket" placeholder="Masukkan Paket" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['paket'] ?>" readonly>
            </div>
        </div>
        <div class="hidden">
            <div class="w-1/2 mt-5">
                <label for="foto_diri" class="block font-medium text-gray-700">Foto Diri</label>
                <input type="text" id="foto_diri" name="foto_diri" placeholder="Masukkan Foto Diri" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['foto_diri'] ?>" readonly>
            </div>
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="status" class="block font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full">
                    <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>
        </div>
        <div class="block mt-5">
            <button type="submit" class="bg-sky-500 rounded-lg p-2 text-white">Simpan</button>       
        </div>
    </form>
</div>

<?= $this->endSection() ?>
