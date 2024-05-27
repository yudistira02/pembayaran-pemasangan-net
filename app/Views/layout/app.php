<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env('APP_NAME') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
</head>

<body class="bg-white">
    <main>
        <div class="flex">
            <?= $this->include('layout/partials/sidebar') ?>
            <div class="flex flex-col w-full">
                <div class="flex-grow p-5">
                    <div class="w-full mb-5 flex justify-between items-center">
                        <h1 class="text-1xl uppercase font-semibold text-gray-800 mr-5"><?= $title ?></h1>
                        <?= $this->include('components/flash') ?>
                    </div>
                    <?= $this->renderSection('content') ?>
                </div>
                <div class="p-5">
                    <?= $this->include('layout/partials/footer') ?>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <?= $this->renderSection('script') ?>
</body>

</html>