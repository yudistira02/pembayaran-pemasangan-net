<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="py-5 w-full">
    <?php if (session()->has('message')) : ?>
        <div class="alert alert-success">
            <?= session('message') ?>
        </div>
    <?php endif; ?>
    <div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="total" class="block font-medium text-gray-700">Total</label>
                <input disabled type="text" id="total" name="total" placeholder="Masukan Total" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['total'] ?>" required>
            </div>        
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="type_jadwal" class="block font-medium text-gray-700">Status</label>
                <select disabled name="status" id="status" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full">
                    <?php if($data['status'] === '1'): ?>
                    <option value="<?= $data['status'] ?>" selected>Sudah Bayar</option>
                    <option value="0">Belum Bayar</option>
                    <?php else: ?>
                    <option value="<?= $data['status'] ?>" selected>Belum Bayar</option>
                    <option value="1">Sudah Bayar</option>
                    <?php endif ?>
                </select>
            </div>        
        </div>
        <div class="block">
            <div class="w-1/2 mt-5">
                <label for="type_pemabayaran" class="block font-medium text-gray-700">Tipe Pemabayaran</label>
                <input disabled type="text" id="type_pemabayaran" name="type_pemabayaran" placeholder="Masukan Type_pemabayaran" class="mt-1 p-2 bg-gray-200 rounded-lg focus:outline-none w-full" value="<?= $data['type_pembayaran'] === '0' ? 'COD (Cash On Delivery)' : 'Online' ?>" required>
            </div>        
        </div>
        <?php if($data['type_pembayaran'] === '0'): ?>
            <?php if($data['status'] === '0'): ?>
            <div class="block">
                <div class="w-1/2 mt-5">
                    <button id="payButton" class="bg-sky-500 rounded-lg p-2 text-white">Bayar</button>
                </div>        
            </div>
            <?php endif ?>
        <?php endif ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#payButton').click(function() {
            handlePayment();
        });

        function handlePayment() {
            $.ajax({
                url: '<?= base_url('dashboard/transaksi/detail/'.$data['id']) ?>',
                method: 'POST',
                success: function(response) {
                    alert(response)
                    location.reload()
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>