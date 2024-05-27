<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="">
    <div class="bg-gray-200 text-gray-800 rounded-lg p-5 px-10 shadow-xl">
        <div>
            <table id="myTable" class="w-full">
                <thead>
                    <tr class="text-left">
                        <th class="py-3">#</th>
                        <th class="py-3">Keluhan</th>
                        <th class="py-3">Nama Pelanggan</th>
                        <th class="py-3">Nomor Pelanggan</th>
                        <th class="py-3">Foto Pelanggan</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $index => $item): ?>
                    <tr class="text-left">
                        <td class="py-3"><?= $index + 1 ?></td>
                        <td class="py-3"><?= $item['keluhan'] ?></td>
                        <td class="py-3"><?= $item['nama'] ?></td>
                        <td class="py-3"><?= $item['nomor'] ?></td>
                        <td class="py-3">
                            <div
                                class="cursor-pointer text-blue-500 w-fit p-1 rounded-lg px-3"
                                onclick="enlargeImage('<?= base_url('uploads/') ?><?= $item['foto_pelanggan'] ?>')"    
                            >
                            <?= $item['foto_pelanggan'] ?>
                            </div>
                        </td>
                        <td class="py-3"><span class="py-1 px-3 rounded-lg text-white <?= $item['status'] === '0' ? 'bg-yellow-500': 'bg-green-500' ?>"><?= $item['status'] === '0' ? 'Pending' : 'Success'?></span></td>
                        <td class="py-3"><?= $item['created_at'] ?></td>
                        <td class="text-white flex gap-2">
                            <?php if($item['status'] === '0' ): ?>
                            <a href="<?= base_url('dashboard/laporan/create/jadwal/'. $item['id']) ?>" class="bg-green-500 p-2 rounded-lg ${isTicketExist ? 'pointer-events-none opacity-50' : ''}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008Zm-2.25-2.25h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm0-4.5h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008ZM10.5 12h.008v.008H10.5V12Zm0 2.25h.008v.008H10.5v-.008ZM13.5 12h.008v.008H13.5V12Zm0 2.25h.008v.008H13.5v-.008Zm0-4.5h.008v.008H13.5V12Zm0 2.25h.008v.008H13.5v-.008Zm3 0h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5v-.008Zm0-4.5h.008v.008H16.5V12Z" />
                                </svg>
                            </a>
                            <?php endif ?>
                            <a href="<?= base_url('dashboard/laporan/update/'. $item['id']) ?>" class="bg-sky-500 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                            <a href="javascript:void(0)" onclick="confirmDelete('<?= base_url('dashboard/laporan/delete/'. $item['id']) ?>" class="bg-red-500 p-2 rounded-lg">
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
        <div id="pagination" class="mt-5"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

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
