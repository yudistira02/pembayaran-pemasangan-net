<?= $this->extend('layout/home') ?>

<?= $this->section('content') ?>

    <div class="py-32 flex justify-between gap-5">
        <div class="w-full">
            <div class="text-4xl font-semibold mb-5"><?= $title ?></div>
            <?= $this->include('components/flash') ?>
            <div class="w-full">
                <form action="<?= base_url('home/profile/'. session()->id) ?>" method="POST">
                    <div class="block">
                        <div class="w-full mt-5">
                            <label for="name" class="block font-medium text-gray-700">Nama User</label>
                            <input type="text" id="name" name="name" placeholder="Masukan Name" class="mt-1 p-2 bg-white rounded-lg focus:outline-sky-300 w-full text-gray-800" value="<?= $data['name'] ?>" required>
                        </div>        
                    </div>
                    <div class="block">
                        <div class="w-full mt-5">
                            <label for="email" class="block font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" placeholder="Masukan Email" class="mt-1 p-2 bg-white rounded-lg focus:outline-sky-300 w-full text-gray-800" value="<?= $data['email'] ?>" required>
                        </div>
                    </div>
                    <div class="block mt-5">
                        <button type="submit" class="bg-sky-500 rounded-lg p-2 text-white">Simpan</button>       
                    </div>
                </form>
            </div>

            <div class="py-5 w-full">
                <form action="<?= base_url('home/profile/password/'. session()->id) ?>" method="POST">
                    <div class="block">
                        <div class="w-full mt-5">
                            <label for="password" class="block font-medium text-gray-700">Password Lama</label>
                            <input type="password" id="old_password" name="old_password" placeholder="Password Lama" class="mt-1 p-2 bg-white rounded-lg focus:outline-sky-300 w-full text-gray-800" value="" required>
                        </div>        
                    </div>
                    <div class="block">
                        <div class="w-full mt-5">
                            <label for="password" class="block font-medium text-gray-700">Password Baru</label>
                            <input type="password" id="new_password" name="new_password" placeholder="Password Baru" class="mt-1 p-2 bg-white rounded-lg focus:outline-sky-300 w-full text-gray-800" value="" required>
                        </div>        
                    </div>
                    <div class="block">
                        <div class="w-full mt-5">
                            <label for="konfirmasi_password" class="block font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" id="konfirmasi_new_password" name="konfirmasi_new_password" placeholder="Konfirmasi Password Baru" class="mt-1 p-2 bg-white rounded-lg focus:outline-sky-300 w-full text-gray-800" value="" required>
                        </div>        
                    </div>
                    <div class="block mt-5">
                        <button type="submit" class="bg-sky-500 rounded-lg p-2 text-white">Simpan</button>       
                    </div>
                </form>
            </div>
        </div>
        <div class="w-full">
            <div class="text-4xl font-semibold mb-5">Status Layanan</div>
            <?php if(session()->userType === 'pelanggan'): ?>
                <div class="my-5">
                    <?php if(!$pemasangan): ?>
                        <div class="bg-red-500 rounded-lg p-5 text-white flex justify-end">
                            <div>
                                <h1 class="font-semibold uppercase text-xl">Status Pelanggan</h1>
                                <p>Belum Terdaftar</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="<?= $pemasangan['status'] === '1' ? 'bg-green-500' : 'bg-yellow-500' ?> rounded-lg p-5 text-white flex justify-between items-center">
                            <?php if($pemasangan['status'] === '1'): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            <?php else: ?>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                                </svg>
                            <?php endif ?>
                            <div>
                                <h1 class="font-semibold uppercase text-xl">Status Pemasangan</h1>
                                <p><?= $pemasangan['status'] === '1' ? 'Sudah Terpasang': 'Dalam Pemasangan' ; ?></p>
                            </div>
                        </div>
                        <?php if(isset($jadwal['status']) && $jadwal['status'] === '0'): ?>
                            <div class="<?= isset($jadwal['waktu_pemasangan']) && $jadwal['waktu_pemasangan'] === null ? 'bg-red-500' : 'bg-green-500' ?> rounded-lg p-5 text-white flex justify-between items-center mt-5">
                                <p><?= isset($jadwal['waktu_pemasangan']) && $jadwal['waktu_pemasangan'] ? $jadwal['waktu_pemasangan'] : 'Jadwal Pemasangan Belum Ada! Tunggu 1x24 Jam.' ?></p>
                                <h1 class="font-semibold uppercase text-xl">Jadwal Pemasangan</h1>
                            </div>
                        <?php endif; ?>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

</script>

<?= $this->endSection() ?>
