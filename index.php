<?php
require_once 'vendor/autoload.php';
require_once 'backend/middleware/authMiddleware.php';
require_once 'backend/middleware/responseMiddleware.php';
require_once 'page-router.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
//TODO generate csrf token

// ROUTES
$pageRouter = new PageRouter();

$pageRouter->get('/', function () {
  PageRouter::displayPage('home.php');
});
$pageRouter->get('/login', function () {
  PageRouter::displayPage('login.php');
}, false);

$pageRouter->get('/register', function () {
  PageRouter::displayPage('register.php');
}, false);
$pageRouter->get('/dashboard', function () {
  PageRouter::displayPage('dashboard.php');
}, true, false);
$pageRouter->get('/inventory', function () {
  PageRouter::displayPage('inventory.php');
}, true, false);

$pageRouter->get('/summarization', function () {
  PageRouter::displayPage('summarization.php');
}, true, false);

$pageRouter->get('/clinicrecord', function () {
  PageRouter::displayPage('clinicrecord.php');
}, true, false);
$pageRouter->get('/logs', function () {
  PageRouter::displayPage('logs.php');
}, true, false);
$pageRouter->get('/settings', function () {
  PageRouter::displayPage('settings.php');
}, true, false);
$pageRouter->get('/about', function () {
  PageRouter::displayPage('about.php');
}, true, false);

// Handle 404 Not Found
$pageRouter->set404(function () {
  http_response_code(404);
  PageRouter::displayPage('404.php');
});

// Run the router
$pageRouter->run();
