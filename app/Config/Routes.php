<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->post('home/tambah', 'Home::tambah');
$routes->post('home/edit/(:segment)', 'Home::edit/$1');
$routes->get('home/hapus/(:segment)', 'Home::hapus/$1');
