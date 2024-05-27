<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

    <div class="flex justify-between items-center">
        <div class="py-5">
            <div class="bg-gray-200 rounded-lg flex p-2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="text" id="searchInput" placeholder="Cari data.." class="bg-gray-200 focus:outline-none">
            </div>
        </div>
    </div>

    <div class="bg-gray-200 rounded-lg p-5 px-10 shadow-xl">
        <div>
            <table id="myTable" class="w-full">
                <thead>
                    <tr class="text-left">
                        <th class="py-3">#</th>
                        <th class="py-3">Nama Pelanggan</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">Nomor WhatsApp</th>
                        <th class="py-3">Alamat</th>
                        <th class="py-3">Foto Pelanggan</th>
                        <th class="py-3">Paket</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="w-full">
                    <?php foreach($data as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $item['nama'] ?></td>
                            <td><?= $item['email'] ?></td>
                            <td><?= $item['nomor_whatsapp'] ?></td>
                            <td><?= $item['alamat'] ?></td>
                            <td>
                                <div
                                    class="cursor-pointer bg-sky-500 text-white w-fit p-1 rounded-lg px-3"
                                    onclick="enlargeImage('<?= base_url('uploads/') ?><?= $item['foto_diri'] ?>')"    
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </div>
                            </td>
                            <td><?= $item['nama_paket'] ?> - Bandwith <?= $item['kecepatan_paket'] ?> Mbps</td>
                            <td><?= $item['status'] === '0' ? 'Tidak Aktif' : 'Aktif' ?></td>
                            <td class="text-white flex gap-2">
                                <?php if ($item['status'] === '1') : ?>
                                    <a href="<?= base_url('dashboard/pelanggan/tagihan/bulanan/'.$item['id']) ?>" class="bg-green-500 p-2 rounded-lg">
                                        Tambah Tagihan
                                    </a>
                                <?php endif; ?>
                                <a href="<?= base_url('dashboard/pelanggan/update/') ?><?= $item['id'] ?>" class="bg-sky-500 p-2 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div id="pagination" class="mt-5"></div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );

    function enlargeImage(imageUrl) {
        var modal = document.createElement('div');
        modal.classList.add('fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'bg-black', 'bg-opacity-75', 'flex', 'justify-center', 'items-center', 'z-50');

        var enlargedImg = document.createElement('img');
        enlargedImg.src = imageUrl;
        enlargedImg.classList.add('max-w-full', 'max-h-full');

        modal.appendChild(enlargedImg);

        document.body.appendChild(modal);

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.remove();
            }
        });
    }

    function confirmDelete(deleteUrl) {
        if (confirm("Are you sure you want to delete this item?")) {
            window.location.href = deleteUrl;
        }
    }
</script>

<?= $this->endSection() ?>
