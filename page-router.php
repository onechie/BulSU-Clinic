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
        $access_token = $_COOKIE['a_jwt'] ?? '';
        if ($access_token) {
            if (!Auth::validateAccessJWT($access_token)) {
                header("Location: /login");
                exit();
            }
        } else {
            header("Location: /login");
            exit();
        }

        // if (!Auth::isAccessTokenValid()) {
        //     header("Location: /login");
        //     exit();
        // }
    }
    private function isAuthenticated()
    {
        $access_token = $_COOKIE['a_jwt'] ?? '';
        if ($access_token) {
            $userData = Auth::validateAccessJWT($access_token);
            if ($userData && $userData->sub && $userData->username) {
                header("Location: /dashboard");
                exit();
            }
        }
        // if (Auth::isAccessTokenValid()) {
        //     header("Location: /dashboard");
        //     exit();
        // }
    }
    private function handleNotFound()
    {
        if ($this->notFoundCallback) {
            $callback = $this->notFoundCallback;
            $callback();
        } else {
            echo json_encode(Response::errorResponse("Page Not Found", 404));
        }
    }
    public static function displayPage($file)
    {
        $path = 'frontend/' . $file;
        if (file_exists($path)) {
            require_once $path;
        } else {
            echo json_encode(Response::errorResponse("Page Not Found", 404));
        }
    }
}
