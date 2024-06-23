<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/paket', 'Home::paket');
$routes->get('/informasi', 'Home::informasi');
$routes->match(['GET', 'POST'], '/login', 'Authentication\AuthController::login');
$routes->match(['GET', 'POST'], '/register', 'Authentication\AuthController::register');
$routes->group('home', ['filter' => 'isAuthenticated', 'filter' => 'isAuthenticatedAs:pelanggan'], function($routes) {
    $routes->get('logout', 'Authentication\AuthController::logout');
    $routes->get('/', 'Home::index');
    $routes->group('profile', function($routes) {
        $routes->match(['GET', 'POST'], '(:num)', 'Home::profile/$1');
        $routes->match(['POST'], 'password/(:num)', 'Home::password/$1');
    });
    $routes->group('transaksi/saya', function($routes) {
        $routes->match(['GET', 'POST'], '(:num)', 'Dashboard\TransaksiController::transaksiSaya/$1');
        $routes->match(['GET', 'POST'], 'bayar/(:num)', 'Dashboard\TransaksiController::bayarOnline/$1');
        $routes->match(['GET', 'POST'], 'bayar/online', 'Dashboard\TransaksiController::updatePaymentStatus');
        $routes->match(['GET'], 'detail/(:num)', 'Dashboard\TransaksiController::detailPelanggan/$1');
    });
    $routes->group('laporan/saya', function($routes) {
        $routes->match(['GET'], '(:num)', 'TicketController::index/$1');
        $routes->match(['GET'], 'delete/(:num)', 'TicketController::delete/$1');
        $routes->match(['GET', 'POST'], 'create', 'TicketController::create');
        $routes->match(['GET', 'POST'], 'update/(:num)', 'TicketController::update/$1');
    });
    $routes->group('lengkapi/informasi', function($routes) {
        $routes->match(['GET', 'POST'], '(:num)', 'Dashboard\PelangganController::lengkapiInformasi/$1');
    });
});

$routes->group('dashboard', ['filter' => 'isAuthenticated', 'filter' => 'isAuthenticatedAs:teknisi,admin'], function($routes) {
    $routes->get('logout', 'Authentication\AuthController::logout');
    $routes->get('/', 'Dashboard\DashboardController::index');
    $routes->group('profile', function($routes) {
        $routes->match(['GET', 'POST'], '(:num)', 'Dashboard\DashboardController::profile/$1');
        $routes->match(['POST'], 'password/(:num)', 'Dashboard\DashboardController::password/$1');
    });
    $routes->group('jadwal', ['filter' => 'isAuthenticatedAs:admin,teknisi'], function($routes) {
        $routes->match(['GET'], '/', 'Dashboard\JadwalController::index');
        $routes->match(['GET', 'POST'], 'create', 'Dashboard\JadwalController::create');
        $routes->match(['GET', 'POST'], 'update/(:num)', 'Dashboard\JadwalController::update/$1');
        $routes->match(['GET'], 'delete/(:num)', 'Dashboard\JadwalController::delete/$1');
    });
    $routes->group('rekap/transaksi', ['filter' => 'isAuthenticatedAs:admin'], function($routes) {
        $routes->match(['GET'], '/', 'Dashboard\LaporanController::index');
        $routes->match(['GET', 'POST'], 'create', 'Dashboard\LaporanController::create');
        $routes->match(['GET', 'POST'], 'update/(:num)', 'Dashboard\LaporanController::update/$1');
        $routes->match(['GET'], 'delete/(:num)', 'Dashboard\LaporanController::delete/$1');
        $routes->match(['GET'], 'export/(:num)', 'Dashboard\LaporanController::export/$1');
    });
    $routes->group('rekap/jadwal', ['filter' => 'isAuthenticatedAs:admin'], function($routes) {
        $routes->match(['GET'], '/', 'Dashboard\LaporanController::indexJadwal');
        $routes->match(['GET', 'POST'], 'create', 'Dashboard\LaporanController::createJadwal');
        $routes->match(['GET', 'POST'], 'update/(:num)', 'Dashboard\LaporanController::updateJadwal/$1');
        $routes->match(['GET'], 'delete/(:num)', 'Dashboard\LaporanController::deleteJadwal/$1');
        $routes->match(['GET'], 'export/(:num)', 'Dashboard\LaporanController::exportJadwal/$1');
    });
    $routes->group('paket', ['filter' => 'isAuthenticatedAs:admin'], function($routes) {
        $routes->match(['GET'], '/', 'Dashboard\PaketController::index');
        $routes->match(['GET', 'POST'], 'create', 'Dashboard\PaketController::create');
        $routes->match(['GET', 'POST'], 'update/(:num)', 'Dashboard\PaketController::update/$1');
        $routes->match(['GET'], 'delete/(:num)', 'Dashboard\PaketController::delete/$1');
    });
    $routes->group('laporan', ['filter' => 'isAuthenticatedAs:admin'], function($routes) {
        $routes->match(['GET'], '/', 'TicketController::indexAdmin');
        $routes->match(['GET', 'POST'], 'create/jadwal/(:num)', 'TicketController::createAdmin/$1');
        $routes->match(['GET', 'POST'], 'update/(:num)', 'TicketController::updateAdmin/$1');
        $routes->match(['GET'], 'delete/(:num)', 'TicketController::delete/$1');
    });
    $routes->group('pelanggan', ['filter' => 'isAuthenticatedAs:admin'], function($routes) {
        $routes->match(['GET'], '/', 'Dashboard\PelangganController::index');
        $routes->match(['GET', 'POST'], 'create', 'Dashboard\PelangganController::create');
        $routes->match(['GET', 'POST'], 'update/(:num)', 'Dashboard\PelangganController::update/$1');
        $routes->match(['GET'], 'delete/(:num)', 'Dashboard\PelangganController::delete/$1');
        $routes->group('tagihan/bulanan', ['filter' => 'isAuthenticatedAs:admin'], function($routes) {
            $routes->match(['GET'], '(:num)', 'Dashboard\PelangganController::createTagihanBulanan/$1');
        });
    });
    $routes->group('transaksi', ['filter' => 'isAuthenticatedAs:admin,pelanggan'], function($routes) {
        $routes->match(['GET', 'POST'], 'detail/(:num)', 'Dashboard\TransaksiController::detail/$1');
        $routes->match(['GET'], '/', 'Dashboard\TransaksiController::index');
        $routes->match(['GET'], 'delete/(:num)', 'Dashboard\TransaksiController::delete/$1');
        $routes->post('export', 'Dashboard\TransaksiController::export');
    });
    $routes->group('user', ['filter' => 'isAuthenticatedAs:admin'], function($routes) {
        $routes->match(['GET'], '/', 'Dashboard\UserController::index');
        $routes->match(['GET', 'POST'], 'create', 'Dashboard\UserController::create');
        $routes->match(['GET', 'POST'], 'update/(:num)', 'Dashboard\UserController::update/$1');
        $routes->match(['GET'], 'delete/(:num)', 'Dashboard\UserController::delete/$1');
    });
});
