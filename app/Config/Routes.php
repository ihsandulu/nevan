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
$routes->add('/msatuan', 'master\msatuan::index');
$routes->add('/mvessel', 'master\mvessel::index');
$routes->add('/mvendortruck', 'master\mvendortruck::index');
$routes->add('/mservice', 'master\mservice::index');
$routes->add('/msatuantarif', 'master\msatuantarif::index');
$routes->add('/mtarif', 'master\mtarif::index');
$routes->add('/mrekening', 'master\mrekening::index');
$routes->add('/mbank', 'master\mbank::index');
$routes->add('/mmethodpayment', 'master\mmethodpayment::index');

$routes->add('/synchron', 'transaction\synchron::index');
$routes->add('/job', 'transaction\job::index');
$routes->add('/cppn', 'transaction\job::ppn');
$routes->add('/nppn', 'transaction\job::nppn');
$routes->add('/kas', 'transaction\kas::index');
$routes->add('/inv', 'transaction\inv::index');
$routes->add('/invd', 'transaction\invd::index');
$routes->add('/invpayment', 'transaction\invpayment::index');

$routes->add('/rabsend', 'report\rabsend::index');
$routes->add('/rtarif', 'report\rtarif::index');
$routes->add('/invprint', 'report\invprint::index');
