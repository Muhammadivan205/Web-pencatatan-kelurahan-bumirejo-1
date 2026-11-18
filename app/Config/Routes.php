<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AgendaController::index');
$routes->get('/agenda', 'AgendaController::index');
$routes->get('/surat', 'AgendaController::index');

// CRUD Routes (Agenda / Surat)
$routes->get('/agenda/tambah', 'AgendaController::create');
$routes->get('/agenda/create', 'AgendaController::create');
$routes->get('/surat/tambah', 'AgendaController::create');
$routes->get('/surat/create', 'AgendaController::create');
$routes->post('/agenda/store', 'AgendaController::store');
$routes->post('/surat/store', 'AgendaController::store');
$routes->get('/agenda/edit/(:num)', 'AgendaController::edit/$1');
$routes->get('/surat/edit/(:num)', 'AgendaController::edit/$1');
$routes->post('/agenda/update/(:num)', 'AgendaController::update/$1');
$routes->post('/surat/update/(:num)', 'AgendaController::update/$1');
$routes->get('/agenda/delete/(:num)', 'AgendaController::delete/$1');
$routes->get('/surat/delete/(:num)', 'AgendaController::delete/$1');
$routes->get('/agenda/detail/(:num)', 'AgendaController::getDetail/$1');
$routes->get('/surat/detail/(:num)', 'AgendaController::getDetail/$1');
$routes->get('/agenda/detail-view/(:num)', 'AgendaController::detailView/$1');
$routes->get('/surat/detail-view/(:num)', 'AgendaController::detailView/$1');
$routes->post('/agenda/update-status/(:num)', 'AgendaController::updateStatus/$1');
$routes->post('/surat/update-status/(:num)', 'AgendaController::updateStatus/$1');

// Print Route
$routes->get('/agenda/print', 'AgendaController::print');
$routes->get('/surat/print', 'AgendaController::print');

// Verifikasi Warga (User Management)
$routes->get('/warga', 'WargaController::index');
$routes->get('/verifikasi-warga', 'WargaController::index');
$routes->post('/warga/store', 'WargaController::store');
$routes->post('/warga/update/(:num)', 'WargaController::update/$1');
$routes->post('/warga/update-status/(:num)', 'WargaController::updateStatus/$1');
$routes->get('/warga/reset-password/(:num)', 'WargaController::resetPassword/$1');
$routes->get('/warga/delete/(:num)', 'WargaController::delete/$1');
$routes->get('/api/cek-nik/(:segment)', 'WargaController::cekNik/$1');
$routes->get('/api/cek-nik', 'WargaController::cekNik');

// Monitoring & Laporan (Pejabat / Lurah & Admin)
$routes->get('/monitoring', 'MonitoringController::index');
$routes->get('/laporan', 'MonitoringController::index');
$routes->get('/monitoring/sahkan/(:num)', 'MonitoringController::sahkan/$1');
$routes->post('/monitoring/sahkan/(:num)', 'MonitoringController::sahkan/$1');
$routes->get('/monitoring/batal-sahkan/(:num)', 'MonitoringController::batalSahkan/$1');
$routes->get('/monitoring/cetak', 'MonitoringController::cetak');

// Riwayat Permohonan (Warga)
$routes->get('/riwayat', 'AgendaController::riwayat');
$routes->get('/warga/riwayat', 'AgendaController::riwayat');
$routes->get('/riwayat-permohonan', 'AgendaController::riwayat');
$routes->get('/riwayat/cetak-bukti/(:num)', 'AgendaController::cetakBukti/$1');

$routes->get('login', 'AuthController::login');
$routes->post('login/process', 'AuthController::processLogin');
$routes->get('register', 'AuthController::register');
$routes->post('register/process', 'AuthController::processRegister');
$routes->get('logout', 'AuthController::logout');
