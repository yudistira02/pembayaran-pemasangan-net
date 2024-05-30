<?= $this->extend('layout/auth') ?>

<?= $this->section('content') ?>

<div class="animate-slide-bottom-to-top text-gray-800 bg-white transition-all duration-300 md:rounded-2xl shadow-2xl w-[500px]">
    <div class="my-10 mx-10">
        <div class="mb-5">
            <h1 class="text-center font-bold text-5xl mt-10 mb-5">BIMANET<span class="text-sky-500 font-bold text-6xl">.</span></h1>
            <p class="text-center font-semibold text-gray-600">Silakan masuk ke akun Anda terlebih dahulu.</p>
        </div>
        <form id="loginForm" class="py-5">
            <div class="block pt-2">
                <label for="email" class="font-semibold text-gray-600">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" class="bg-gray-200 rounded-2xl py-4 px-5 w-full focus:outline-none">
            </div>
            <div class="block pt-2">
                <label for="password" class="font-semibold text-gray-600">Password</label>
                <input type="password" name="password" id="password" placeholder="*****" class="bg-gray-200 rounded-2xl py-4 px-5 w-full focus:outline-none">
            </div>
            <div class="block mt-10">
                <button type="submit" class="bg-sky-500 hover:bg-sky-600 transition-colors duration-300 text-white text-1xl font-bold rounded-2xl py-4 px-5 w-full focus:outline-none">LOGIN</button>
            </div>
        </form>
        <div class="font-medium transition-colors">
            <span class="text-gray-600">Tidak mempunyai akun? <a href="<?= base_url('register') ?>" class="text-sky-500 hover:text-sky-600 duration-300">Register</a></span>
        </div>

        <div class="py-10 font-semibold text-gray-500">
            <a href="<?= base_url('/') ?>" class="items-center flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: '<?= base_url('/login') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        })

                        window.location.href = response.redirect;
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>