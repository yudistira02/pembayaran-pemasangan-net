<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="py-5 w-full">
    <form action="<?= base_url('dashboard/profile/'. session()->id) ?>" method="POST">
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="name" class="block font-medium text-gray-700">Nama User</label>
                <input type="text" id="name" name="name" placeholder="Masukan Name" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['name'] ?>" required>
            </div>        
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="email" class="block font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukan Email" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['email'] ?>" required>
            </div>
        </div>
        <div class="block mt-5">
            <button type="submit" class="bg-sky-500 rounded-lg p-2 text-white">Simpan</button>       
        </div>
    </form>
</div>

<div class="py-5 w-full">
    <form action="<?= base_url('dashboard/profile/password/'. session()->id) ?>" method="POST">
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="password" class="block font-medium text-gray-700">Password Lama</label>
                <input type="password" id="old_password" name="old_password" placeholder="Password Lama" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="" required>
            </div>        
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="password" class="block font-medium text-gray-700">Password Baru</label>
                <input type="password" id="new_password" name="new_password" placeholder="Password Baru" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="" required>
            </div>        
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="konfirmasi_password" class="block font-medium text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" id="konfirmasi_new_password" name="konfirmasi_new_password" placeholder="Konfirmasi Password Baru" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="" required>
            </div>        
        </div>
        <div class="block mt-5">
            <button type="submit" class="bg-sky-500 rounded-lg p-2 text-white">Simpan</button>       
        </div>
    </form>
</div>

<?= $this->endSection() ?>
