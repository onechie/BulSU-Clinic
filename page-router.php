<?php
require_once 'backend/middleware/accessMiddleware.php';
Access::preventDirectAccess();
class PageRouter
{
    private $routes = [];
    private $notFoundCallback;
    public function get($url, $callback, $forAuthenticated = true, $forUnauthenticated = true)
    {
        $url = preg_replace('/[^a-zA-Z0-9\/]/', '', $url);

        if ($forAuthenticated && !$forUnauthenticated) {
            $this->routes[$url] = function () use ($callback) {
                $this->isNotAuthenticated();
                $callback();
            };
        } elseif ($forUnauthenticated && !$forAuthenticated) {
            $this->routes[$url] = function () use ($callback) {
                $this->isAuthenticated();
                $callback();
            };
        } else {
            $this->routes[$url] = function () use ($callback) {
                $callback();
            };
        }
    }
    public function set404($callback)
    {
        $this->notFoundCallback = $callback;
    }
    public function run()
    {
        $path = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if (strlen($path) > 1) {
            $path = rtrim($path, '/');
        }
        $path = strtok($path, '?');
        $path = preg_replace('/[^a-zA-Z0-9\/]/', '', $path);

        $callback = $this->routes[$path] ?? null;
        if ($callback && $method === 'GET') {
            // Implement CSRF protection here if needed
            $callback();
        } else {
            $this->handleNotFound();
        }
    }
    private function isNotAuthenticated()
    {
        if (!Auth::isAccessTokenValid()) {
            header("Location: /login");
            exit();
        }
    }
    private function isAuthenticated()
    {
        if (Auth::isAccessTokenValid()) {
            header("Location: /dashboard");
            exit();
        }
    }
    private function handleNotFound()
    {
        if ($this->notFoundCallback) {
            $callback = $this->notFoundCallback;
            $callback();
        } else {
            http_response_code(404);
            echo json_encode(Response::errorResponse("Page Not Found"));
        }
    }
    public static function displayPage($file)
    {
        $path = 'pages/' . $file;
        if (file_exists($path)) {
            require_once $path;
        } else {
            http_response_code(404);
            echo json_encode(Response::errorResponse("Page Not Found"));
        }
    }
}
