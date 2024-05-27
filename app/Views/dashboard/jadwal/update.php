<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="py-5 w-full">
    <?php if (session()->has('success')) : ?>
        <div class="alert alert-success">
            <?= session('success') ?>
        </div>
    <?php elseif (session()->has('error')) : ?>
        <div class="alert alert-danger">
            <?= session('error') ?>
        </div>
    <?php endif; ?>
    
    <form action="<?= base_url('dashboard/jadwal/update/'.$data['id']) ?>" method="POST" enctype="multipart/form-data">
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="waktu_pemasangan" class="block font-medium text-gray-700">Waktu Pelaksanaan</label>
                <input type="date" id="waktu_pemasangan" name="waktu_pemasangan" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['waktu_pemasangan'] ?>" required <?= session()->userType === 'admin' ? '' : 'disabled' ?>>
            </div>        
        </div>

        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="teknisi_id" class="block font-medium text-gray-700">Teknisi</label>
                <select <?= session()->userType === 'admin' ? '' : 'disabled' ?> id="teknisi_id" name="teknisi_id" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" required>
                    <option value="" disabled selected>Pilih Teknisi</option>
                    <?php foreach ($teknisi as $technician): ?>
                        <option value="<?= $technician['id'] ?>" <?= $technician['id'] == $data['teknisi_id'] ? 'selected' : '' ?>>
                            <?= $technician['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="bukti_kegiatan" class="block font-medium text-gray-700">Bukti Instalasi</label>
                <input type="file" id="bukti_kegiatan" name="bukti_kegiatan" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full">
                <?php if (!empty($data['bukti_kegiatan'])): ?>
                    <p class="mt-2">Current file: <?= $data['bukti_kegiatan'] ?></p>
                <?php endif; ?>
            </div>        
        </div>
        
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="foto_pelanggan" class="block font-medium text-gray-700">Foto Dengan Pelanggan</label>
                <input type="file" id="foto_pelanggan" name="foto_pelanggan" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full">
                <?php if (!empty($data['foto_pelanggan'])): ?>
                    <p class="mt-2">Current file: <?= $data['foto_pelanggan'] ?></p>
                <?php endif; ?>
            </div>        
        </div>
        
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="type_jadwal" class="block font-medium text-gray-700">Tipe Jadwal</label>
                <select disabled name="type_jadwal" id="type_jadwal" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full">
                    <option value="instalasi_baru" <?= $data['type_jadwal'] === 'instalasi_baru' ? 'selected' : '' ?>>Instalasi Baru</option>
                    <option value="perbaikan" <?= $data['type_jadwal'] === 'perbaikan' ? 'selected' : '' ?>>Perbaikan</option>
                </select>
            </div>        
        </div>
        
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="status" class="block font-medium text-gray-700">Status</label>
                <select <?= session()->userType === 'admin' ? '' : 'disabled' ?> name="status" id="status" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full">
                    <option value="1" <?= $data['status'] === '1' ? 'selected' : '' ?>>Sudah Terpasang</option>
                    <option value="0" <?= $data['status'] === '0' ? 'selected' : '' ?>>Belum Terpasang</option>
                </select>
            </div>        
        </div>
        
        <div class="block mt-5">
            <button type="submit" class="bg-sky-500 rounded-lg p-2 text-white">Simpan</button>       
        </div>
    </form>
</div>

<script>
document.getElementById('waktu_pemasangan').addEventListener('change', function() {
    const waktuPemasangan = this.value;
    const id = <?= $data['id'] ?>;
    fetch(`<?= base_url('dashboard/jadwal/update') ?>/${id}?waktu_pemasangan=${waktuPemasangan}`, {
        method: 'GET', // Adjust the method to GET
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const teknisiSelect = document.getElementById('teknisi_id');
        teknisiSelect.innerHTML = '<option value="" disabled selected>Pilih Teknisi</option>';
        data.teknisi.forEach(technician => {
            const option = document.createElement('option');
            option.value = technician.id;
            option.textContent = technician.name;
            teknisiSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error fetching technicians:', error));
});
</script>


<?= $this->endSection() ?>
