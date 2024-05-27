<?= $this->extend('layout/home') ?>

<?= $this->section('content') ?>

<div class="py-32">
    <div class="font-semibold text-4xl text-center mb-10"><?= $title ?></div>
    <div class="flex justify-between items-center">
        <div class="py-5">
            <div class="bg-white rounded-lg flex p-2 text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="text" id="searchInput" placeholder="Cari data.." class="bg-white focus:outline-none">
            </div>
        </div>
        <a href="<?= base_url('home/laporan/saya/create') ?>">
            <div class="flex items-center bg-white p-2 rounded-lg text-sky-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah
            </div>
        </a>
    </div>

    <div class="bg-white text-gray-800 rounded-lg p-5 px-10 shadow-xl">
        <div id="tableContainer">
            <table class="w-full">
                <thead>
                    <tr class="text-left">
                        <th class="py-3">#</th>
                        <th class="py-3">Keluhan</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
            </table>
        </div>
        <div id="pagination" class="mt-5"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    const itemsPerPage = 5; 
    let currentPage = 1; 
    let originalData = <?= json_encode($data) ?>; 
    let data = originalData.slice(); 

    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + ribuan;
    }

    function displayData() {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const displayData = data.slice(startIndex, endIndex);
        const tableBody = document.getElementById('tableBody');
        let tableContent = '';

        displayData.forEach((item, index) => {
            tableContent += `
                <tr>
                    <td class="font-bold">${startIndex + index + 1}</td>
                    <td>${item['keluhan']}</td>
                    <td><span class="py-1 px-3 rounded-lg text-white ${item['status'] === '0' ? 'bg-yellow-500': 'bg-green-500'}">${item['status'] === '0' ? 'Pending' : 'Success'}</span></td>
                    <td>${item['created_at']}</td>
                    <td class="text-white flex gap-2">
                        <a href="<?= base_url('home/laporan/saya/update/') ?>${item['id']}" class="bg-sky-500 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <a href="<?= base_url('home/laporan/saya/delete/') ?>${item['id']}" class="bg-red-500 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </a>
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = tableContent;
    }

    function generatePagination() {
        const totalPages = Math.ceil(data.length / itemsPerPage);
        let paginationHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `
            <a href="#" onclick="changePage(${i})" class="${currentPage === i ? 'font-bold text-white bg-sky-500 mr-2 p-2 px-4 rounded-lg' : ''}">${i}</a>
            `;
        }

        document.getElementById('pagination').innerHTML = paginationHTML;
    }

    function changePage(pageNumber) {
        currentPage = pageNumber;
        displayData();
        generatePagination();
    }

    function handleSearch() {
        const searchInput = document.getElementById('searchInput').value.trim().toLowerCase();
        if (searchInput === '') {
            data = originalData.slice(); 
        } else {
            data = originalData.filter(item => {
                return item['total'].toLowerCase().includes(searchInput) ||
                       item['status'].toLowerCase().includes(searchInput);
            });
        }
        currentPage = 1;
        displayData();
        generatePagination();
    }

    document.getElementById('searchInput').addEventListener('input', handleSearch);

    displayData();
    generatePagination();
</script>

<?= $this->endSection() ?>
