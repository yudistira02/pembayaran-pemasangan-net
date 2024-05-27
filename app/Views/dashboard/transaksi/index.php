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
                        <th class="py-3">Alamat</th>
                        <th class="py-3">Kategori Pembayaran</th>
                        <th class="py-3">Tipe Pembayaran</th>
                        <th class="py-3">Total</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1?></td>
                        <td><?= $item['name']?></td>
                        <td><?= $item['alamat']?></td>
                        <td><?= $item['kategori_pembayaran'] === 'bulanan' ? 'Bulanan' : 'Instalasi Baru' ?></td>
                        <td><?= $item['type_pembayaran'] === '1' ? 'Online' : 'COD (Cash On Delivery)'?></td>
                        <td><?= $item['total']?></td>
                        <td><?= $item['status'] === '0' ? 'Belum Bayar' : 'Sudah bayar'?></td>
                        <td class="text-white flex gap-2">
                            <a href="<?= base_url('dashboard/transaksi/detail/') ?><?= $item['id']?>" class="bg-sky-500 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                            <a href="javascript:void(0)" onclick="confirmDelete('<?= base_url('dashboard/transaksi/delete/') ?><?= $item['id']?>')" class="bg-red-500 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );

    function confirmDelete(deleteUrl) {
        if (confirm("Are you sure you want to delete this item?")) {
            window.location.href = deleteUrl;
        }
    }
</script>

<?= $this->endSection() ?>
