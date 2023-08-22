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

// Handle 404 Not Found
$pageRouter->set404(function () {
  http_response_code(404);
  PageRouter::displayPage('404.php');
});

// Run the router
$pageRouter->run();
