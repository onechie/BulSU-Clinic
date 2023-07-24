<?php
require_once 'router.php';

session_start();

// Define your routes here
$pageRouter = new PageRouter();

$pageRouter->get('/', function () {
  PageRouter::displayPage('home.html');
});
$pageRouter->get('/register', function () {
  PageRouter::displayPage('register.demo.html');
});
$pageRouter->get('/login', function () {
  PageRouter::displayPage('login.demo.html');
});
$pageRouter->get('/dashboard', function () {
  PageRouter::displayPage('dashboard.demo.html');
});
$pageRouter->get('/inventory', function () {
  PageRouter::displayPage('inventory.demo.html');
});
$pageRouter->get('/summarization', function () {
  PageRouter::displayPage('summarization.demo.html');
});
$pageRouter->get('/clinicForm', function () {
  PageRouter::displayPage('clinicForm.demo.html');
});
$pageRouter->get('/clinicRecord', function () {
  PageRouter::displayPage('clinicRecord.demo.html');
});
$pageRouter->get('/settings', function () {
  PageRouter::displayPage('settings.demo.html');
});

// Handle 404 Not Found
$pageRouter->set404(function () {
  PageRouter::displayPage('404.html');
});

// Run the router
$router->run();
?>