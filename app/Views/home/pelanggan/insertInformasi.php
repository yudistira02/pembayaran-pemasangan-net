<?= $this->extend('layout/home') ?>

<?= $this->section('content') ?>

<div class="py-32 w-full">
    <div class="font-semibold text-4xl text-center mb-10"><?= $title ?></div>
    <?php if (session()->has('message')) : ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>
    <form id="infoForm" action="<?= base_url('home/lengkapi/informasi/' . session()->id) ?>" method="POST" enctype="multipart/form-data">
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="foto_diri" class="block font-medium text-gray-700">Foto Diri</label>
                <input type="file" id="foto_diri" name="foto_diri" class="mt-1 p-2 bg-white rounded-lg focus:outline-none w-full text-gray-800" value="" accept=".jpg, .jpeg" required>
            </div>
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="nomor_whatsapp" class="block font-medium text-gray-700">Nomor WhatsApp</label>
                <input type="number" id="nomor_whatsapp" name="nomor_whatsapp" placeholder="Masukan Nomor WhatsApp" class="mt-1 p-2 bg-white rounded-lg focus:outline-none w-full text-gray-800" value="" required>
            </div>
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="alamat" class="block font-medium text-gray-700">Alamat Lengkap</label>
                <textarea type="text" id="alamat" name="alamat" class="mt-1 p-2 bg-white rounded-lg focus:outline-none w-full text-gray-800" value=""></textarea>
            </div>
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="paket" class="block font-medium text-gray-700">Paket</label>
                <select name="paket" id="paket" class="mt-1 p-2 bg-white rounded-lg focus:outline-none w-full text-gray-800">
                    <?php foreach ($paket as $item) : ?>
                        <option value="<?= $item['id'] ?>" selected><?= $item['nama'] ?> - <?= 'Rp ' . number_format($item['harga'], 0, ',', '.') ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="type_pembayaran" class="block font-medium text-gray-700">Tipe Pembayaran</label>
                <select name="type_pembayaran" id="type_pembayaran" class="mt-1 p-2 bg-white rounded-lg focus:outline-none w-full text-gray-800">
                    <option value="1" selected>Online</option>
                    <option value="0">COD (Cash On Delivery)</option>
                </select>
            </div>
        </div>
        <input type="hidden" id="geolocation" name="geolocation">
        <div class="w-1/2 h-[400px] mt-5 rounded-lg" id="map">
        </div>
        <div class="block mt-5">
            <button type="submit" class="bg-sky-500 rounded-lg p-2 text-white">Simpan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    var map = L.map('map', {
        center: [-7.736287059282285, 113.68848790022479],
        zoom: 13
    });

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = null; // Initialize marker variable

    map.on('click', function(e) {
        if (marker) {
            marker.setLatLng(e.latlng); // Update marker position
        } else {
            marker = L.marker(e.latlng).addTo(map); // Add marker to map
        }
        document.getElementById('geolocation').value = e.latlng.lat + ',' + e.latlng.lng;
    });
</script>
<?= $this->endSection() ?>