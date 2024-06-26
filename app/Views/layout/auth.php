<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= env('APP_NAME') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
</head>

<body class="bg-gray-800 text-white">
    <main class="flex justify-center items-center w-full min-h-screen">
        <?= $this->renderSection('content') ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?= $this->renderSection('script') ?>
</body>

</html>