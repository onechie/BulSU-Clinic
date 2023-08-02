<?php
class PageRouter
{
    private $routes = [];
    private $notFoundCallback;
    private $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    // Add a route for GET requests
    public function get($url, $callback)
    {
        // Sanitize and validate the URL path (only allow alphanumeric characters and slashes)
        $url = preg_replace('/[^a-zA-Z0-9\/]/', '', $url);

        //Include the 'handleAuth' check for specific routes
        if ($this->requiresAuth($url)) {
            $this->routes[$url] = function () use ($callback) {
                $this->redirectToDashboardIfLoggedIn(); // Redirect if logged in, else allow access
                $callback();
            };
        } else {
            $this->routes[$url] = function () use ($callback) {
                $this->redirectToLoginIfNotLoggedIn(); // Redirect if not logged in, else allow access
                $callback();
            };
        }

        //basic route
        //$this->routes[$url] = $callback;
    }

    // Check if a specific route requires authentication (e.g., login or register page)
    private function requiresAuth($url)
    {
        return in_array($url, ['/login', '/register']);
    }

    // Set a callback for 404 Not Found page
    public function set404($callback)
    {
        $this->notFoundCallback = $callback;
    }


    public function run()
    {
        $path = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        // Remove last '/' to prevent 'Not Found' on routes ending with '/'
        if (strlen($path) > 1) {
            $path = rtrim($path, '/');
        }

        // Remove query parameters from the path (if any)
        $path = strtok($path, '?');

        // Sanitize and validate the URL path (only allow alphanumeric characters and slashes)
        $path = preg_replace('/[^a-zA-Z0-9\/]/', '', $path);

        // Find the callback associated with the URL
        $callback = $this->routes[$path] ?? null;

        // If the route exists and it's a GET request, execute the callback
        if ($callback && $method === 'GET') {
            // Implement CSRF protection here if needed
            $callback();
        } else {
            $this->handleNotFound();
        }
    }

    // Redirect to the dashboard if the user is logged in
    private function redirectToDashboardIfLoggedIn()
    {
        if (isset($this->session['ACCESS']['token']) && isset($_COOKIE['access_token'])) {
            $sessionAuthToken = $this->session['ACCESS']['token'];
            $cookieAuthToken = $_COOKIE['access_token'];
            if (!hash_equals($sessionAuthToken, $cookieAuthToken)) {
                header("Location: /login"); // Redirect to login
                exit();
            }
            header("Location: /"); // Redirect to dashboard
            exit();
        }
    }

    // Redirect to the login page if the user is not logged in
    private function redirectToLoginIfNotLoggedIn()
    {
        if (!isset($this->session['ACCESS']['token']) || !isset($_COOKIE['access_token']) || !hash_equals($this->session['ACCESS']['token'], $_COOKIE['access_token'])) {
            session_unset();
            session_destroy();
            header("Location: /login"); // Redirect to login
            exit();
        }
    }

    // Handle 404 Not Found page
    private function handleNotFound()
    {
        if ($this->notFoundCallback) {
            // If a custom 404 callback is set, use it
            $callback = $this->notFoundCallback;
            $callback();
        } else {
            // Otherwise, return a simple JSON response for 404
            http_response_code(404);
            $response = [
                "message" => "Route Not Found"
            ];
            echo json_encode($response);
        }
    }

    // A static method to display a specific page
    public static function displayPage($file)
    {
        $path = 'pages/' . $file;
        if (file_exists($path)) {
            require_once $path;
        } else {
            // If the requested page doesn't exist, return a simple JSON response for 404
            http_response_code(404);
            $response = [
                "message" => "Route Not Found"
            ];
            echo json_encode($response);
        }
    }
}
