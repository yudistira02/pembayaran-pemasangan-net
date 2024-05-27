<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

    <div class="flex justify-between items-center">
        <a href="<?= base_url('dashboard/paket/create') ?>">
            <div class="flex items-center bg-sky-500 p-2 rounded-lg text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah
            </div>
        </a>
    </div>  

    <div class="bg-gray-200 rounded-lg p-5 px-10 shadow-xl">
        <div>
            <table id="myTable" class="w-full">
                <thead>
                    <tr class="text-left">
                        <th class="py-3">#</th>
                        <th class="py-3">Nama Paket</th>
                        <th class="py-3">Kecepatan</th>
                        <th class="py-3">Harga</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $index => $item): ?>
                    <tr>
                        <td class="text-left"><?= $index + 1 ?></td>
                        <td><?= $item['nama'] ?></td>
                        <td><?= $item['kecepatan'] ?></td>
                        <td><?= 'Rp ' . number_format($item['harga'], 0, ',', '.') ?></td>
                        <td class="text-white flex gap-2">
                            <a href="<?= base_url('dashboard/paket/update/') ?>${item['id']}" class="bg-sky-500 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <a href="javascript:void(0)" onclick="confirmDelete('<?= base_url('dashboard/paket/delete/') ?>${item['id']}')" class="bg-red-500 p-2 rounded-lg">
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
