<?= $this->extend('layout/home') ?>

<?= $this->section('content') ?>

<div class="py-32 flex justify-center items-center">
    <div class="w-[500px]">
        <div class="font-semibold text-4xl text-center mb-10 animate-slide-top-to-bottom"><?= $title ?></div>
        <?php if (session()->has('message')) : ?>
            <div class="alert alert-success">
                <?= session('message') ?>
            </div>
        <?php endif; ?>
        <div class="bg-white rounded-lg p-5 animate-slide-bottom-to-top">
            <div class="block my-2">
                <div class="flex justify-between items-center">
                    <label for="total" class="block font-medium text-gray-800">Nama</label>
                    <div class="text-black"><?= $data['name'] ?></div>
                </div>        
            </div>
            <div class="block my-2">
                <div class="flex justify-between items-center">
                    <label for="total" class="block font-medium text-gray-800">ID Pelanggan</label>
                    <div class="text-black"><?= $data['id_pelanggan'] ?></div>
                </div>        
            </div>
            <div class="border-t border-gray-300 my-4"></div>
            <div class="block my-2">
                <div class="flex justify-between items-center">
                    <label for="total" class="block font-medium text-gray-800">Status</label>
                    <div class="text-white"><?= $data['status'] === '1' ? '<span class="py-1 px-3 bg-green-500 rounded-lg">Sukses</span>' : '<span class="py-1 px-3 bg-red-500 rounded-lg">Belum Bayar</span>' ?></div>
                </div>        
            </div>
            <div class="block my-2">
                <div class="flex justify-between items-center">
                    <label for="total" class="block font-medium text-gray-800">Pajak</label>
                    <div class="text-black">IDR <?= number_format(2000, 0, ',', '.') ?></div>
                </div>        
            </div>
            <div class="block my-2">
                <div class="flex justify-between items-center">
                    <label for="total" class="block font-medium text-gray-800">Total</label>
                    <div class="text-black">
                        <div>IDR <?= number_format($data['total'], 0, ',', '.') ?></div>
                    </div>
                </div>        
            </div>
            <div class="block my-2">
                <div class="flex justify-between items-center">
                    <label for="total" class="block font-medium text-gray-800">Tipe Pembayaran</label>
                    <div class="text-black"><?= $data['type_pembayaran'] === '0' ? 'COD (Cash On Delivery)' : 'Online' ?></div>
                </div>        
            </div>
            <?php if(session()->userType === 'pelanggan' AND $data['type_pembayaran'] === '1'): ?>
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
                url: '<?= base_url('home/transaksi/saya/bayar/'.$data['id']) ?>',
                method: 'POST',
                success: function(response) {
                    window.snap.pay(response, {  
                        onSuccess: function(result){
                            updatePaymentStatus(result);
                        },
                        onPending: function(result){
                            alert("Payment pending!"); console.log(result);
                        },
                        onError: function(result){
                            alert("Payment failed!"); console.log(result);
                        },
                        onClose: function(){
                            alert('Payment pop-up closed without finishing the payment');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function updatePaymentStatus(result) {
            $.ajax({
                url: '<?= base_url('home/transaksi/saya/bayar/online/'.$data['id']) ?>',
                method: 'POST',
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>