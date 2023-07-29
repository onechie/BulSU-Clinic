<?php
require_once 'page-router.php';

session_start();
// For testing purposes
// Clear the session data (user_id, etc.)
// session_unset();
// session_destroy();
// if (isset($_SESSION['user_id'])) {
//   $response = [
//     'user_id' => $_SESSION['user_id'],
//     'username' => $_SESSION['username'],
//     'email' => $_SESSION['email'],
//     'csrf_token' => $_SESSION['csrf_token']
//   ];
//   echo json_encode($response);
// }else{
//   echo 'NOT LOGGED IN';
// }

// Define your routes here
$pageRouter = new PageRouter($_SESSION);

$pageRouter->get('/', function () {
  PageRouter::displayPage('home.html');
});

// Handle 404 Not Found
$pageRouter->set404(function () {
  PageRouter::displayPage('404.html');
});

// Run the router
$pageRouter->run();
?>