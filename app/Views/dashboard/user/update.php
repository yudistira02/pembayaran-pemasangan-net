<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="py-5 w-full">
    <form action="<?= base_url('dashboard/user/update/'.$data['id']) ?>" method="post">
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
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="usertype" class="block font-medium text-gray-700">Role</label>
                <select name="usertype" id="usertype" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full">
                    <?php if($data['usertype'] === 'admin'): ?>
                    <option value="<?= $data['usertype'] ?>" selected>Admin</option>
                    <option value="teknisi">Teknisi</option>
                    <option value="pelanggan">Pelanggan</option>
                    <?php elseif($data['usertype'] === 'teknisi'): ?>
                    <option value="<?= $data['usertype'] ?>" selected>Teknisi</option>
                    <option value="admin">Admin</option>
                    <option value="pelanggan">Pelanggan</option>
                    <?php else: ?>
                    <option value="<?= $data['usertype'] ?>" selected>Pelanggan</option>
                    <option value="admin">Admin</option>
                    <option value="teknisi">Teknisi</option>
                    <?php endif ?>
                </select>
            </div>        
        </div>
        <div class="block mt-5">
            <button type="submit" class="bg-sky-500 rounded-lg p-2 text-white">Simpan</button>       
        </div>
    </form>
</div>



<?= $this->endSection() ?>