<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->add('/', 'utama::login');
$routes->add('/api/(:any)', 'api::$1');
$routes->add('/utama', 'utama::index');
$routes->add('/login', 'utama::login');
$routes->add('/logout', 'utama::logout');
$routes->add('/mposition', 'master\mposition::index');
$routes->add('/mpositionpages', 'master\mpositionpages::index');
$routes->add('/muser', 'master\muser::index');
$routes->add('/muserposition', 'master\muserposition::index');
$routes->add('/mpassword', 'master\mpassword::index');
$routes->add('/midentity', 'master\midentity::index');
$routes->add('/mdepartemen', 'master\mdepartemen::index');
$routes->add('/mvendor', 'master\mvendor::index');
$routes->add('/mcustomer', 'master\mcustomer::index');
$routes->add('/morigin', 'master\morigin::index');
$routes->add('/mdestination', 'master\mdestination::index');
$routes->add('/synchron', 'transaction\synchron::index');
$routes->add('/lembur', 'transaction\lembur::index');
$routes->add('/cutihutang', 'transaction\cutihutang::index');
$routes->add('/rabsend', 'report\rabsend::index');
