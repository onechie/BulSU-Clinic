<?php
require_once 'page-router.php';

session_start();
//TODO generate csrf token

// Define your routes here
$pageRouter = new PageRouter($_SESSION);

$pageRouter->get('/', function () {
  PageRouter::displayPage('home.html');
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

// Handle 404 Not Found
$pageRouter->set404(function () {
  PageRouter::displayPage('404.html');
});

// Run the router
$pageRouter->run();
