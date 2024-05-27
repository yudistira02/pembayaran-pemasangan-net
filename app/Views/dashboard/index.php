<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<h1 class="mb-5 text-4xl font-extralight">
    Selamat datang, <span class="font-bold text-sky-500"><?= session()->name ?>!</span>
</h1>
<?php if(session()->userType === 'admin'): ?>
<div class="grid gap-4 grid-cols-3">
    <div>
        <div class="bg-gray-800 rounded-lg p-5 text-white flex justify-between items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
            </svg>
            <div>
                <h1 class="font-semibold uppercase text-xl">Paket</h1>
                <p><?= $paketCount ?></p>
            </div>    
        </div>
    </div>
    <div>
        <div class="bg-gray-800 rounded-lg p-5 text-white flex justify-between items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
            </svg>
            <div>
                <h1 class="font-semibold uppercase text-xl">Pelanggan</h1>
                <p><?= $pelangganCount ?></p>
            </div>    
        </div>
    </div>
    <div>
        <div class="bg-gray-800 rounded-lg p-5 text-white flex justify-between items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
            </svg>
            <div>
                <h1 class="font-semibold uppercase text-xl">Transaksi</h1>
                <p><?= $transaksiCount ?></p>
            </div>    
        </div>
    </div>
</div>

<div class="grid gap-5 grid-cols-2 py-5">
    <div>
        <canvas id="dataTransaksi"></canvas>
    </div>
    <div>
        <canvas id="dataPemasangan"></canvas>
    </div>
</div>

<?php endif ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
const pemasanganData = <?= json_encode($dataPemasangan) ?>;
const transaksiData = <?= json_encode($dataTransaksi) ?>;

const pemasanganLabels = pemasanganData.map(item => item.label);
const pemasanganValues = pemasanganData.map(item => item.value);

const transaksiLabels = transaksiData.map(item => item.label);
const transaksiValues = transaksiData.map(item => item.value);

const dataPemasanganCtx = document.getElementById('dataPemasangan').getContext('2d');
new Chart(dataPemasanganCtx, {
  type: 'bar',
  data: {
    labels: pemasanganLabels,
    datasets: [{
      label: 'Data Pemasangan',
      data: pemasanganValues,
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

const dataTransaksiCtx = document.getElementById('dataTransaksi').getContext('2d');
new Chart(dataTransaksiCtx, {
  type: 'line',
  data: {
    labels: transaksiLabels,
    datasets: [{
      label: 'Data Transaksi',
      data: transaksiValues,
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
</script>

<?= $this->endSection() ?>
