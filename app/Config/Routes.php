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
$routes->get('/surat/tambah', 'AgendaController::create');
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
