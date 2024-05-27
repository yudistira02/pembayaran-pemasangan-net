<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env('APP_NAME') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= getenv('MIDTRANS_CLIENT_KEY') ?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <!-- Link to jQuery (required by FancyBox) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Link to FancyBox JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
</head>
<body class="bg-[#5AB2FF]">
    <main>  
        <?= $this->include('layout/partials/navbar_home') ?>
        <div class="py-10 px-32 text-white">
            <?= $this->renderSection('content') ?>
        </div>
        <div class="py-10 px-32 bg-white w-full bottom-0 shadow-xl">
            <div class="animate-slide-left-to-right">
                <?= $this->include('layout/partials/footer_home') ?>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/8ef7ea110e.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 0) {
                navbar.classList.add('bg-opacity-70');
            } else {
                navbar.classList.remove('bg-opacity-70');
            }
        });
    </script>
    <?= $this->renderSection('script') ?>
</body>
</html>
