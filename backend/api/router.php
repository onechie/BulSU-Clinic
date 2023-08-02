<?php
require_once '../utils/Utility.php';
Utility::preventDirectAccess();

class Router extends Utility
{
    private $routes = [];
    private $requireAuthRoutes = [];
    private $notFoundCallback;

    public function get($url, $callback, $requireAuthentication = false)
    {
        $this->addRoute('GET', $url, $callback, $requireAuthentication);
    }

    public function post($url, $callback, $requireAuthentication = false)
    {
        $this->addRoute('POST', $url, $callback, $requireAuthentication);
    }

    private function addRoute($method, $url, $callback, $requireAuthentication)
    {
        $url = preg_replace('/[^a-zA-Z0-9\/]/', '', $url);
        $this->routes[$method][$url] = $callback;
        if ($requireAuthentication) {
            array_push($this->requireAuthRoutes, $url);
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

        // Remove unnecessary parts from the path
        $path = str_replace("/backend/api", "", $path);
        // Remove query parameters from the path (if any)
        $path = strtok($path, '?');
        // Sanitize and validate the URL path (example: only allow alphanumeric characters and slashes)
        $path = preg_replace('/[^a-zA-Z0-9\/]/', '', $path);

        $callback = $this->routes[$method][$path] ?? null;
        //CHECK IF THE PATH REQUIRES AUTHORIZATION IF YES CHECK THE AUTH TOKEN
        if (in_array($path, $this->requireAuthRoutes) && !$this->validateAuthToken()) {
            http_response_code(401);
            echo json_encode($this->errorResponse("Unauthorized"));
            return;
        }
        if ($callback && is_callable($callback)) {
            // Implement CSRF protection here if needed
            try {
                $response = $callback();
                http_response_code($response["success"] ? 200 : 400);
                echo json_encode($response);
            } catch (Throwable $error) {
                echo json_encode($this->errorResponse($error->getMessage()));
            }
        } else {
            $this->handleNotFound();
        }
    }
    private function validateAuthToken()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $authToken = $_COOKIE['access_token'] ?? null;
        if (!$authToken) {
            return false;
        }
        $sessionAuthToken = $_SESSION['ACCESS']['token'] ?? null;
        if ($sessionAuthToken && hash_equals($authToken, $sessionAuthToken)) {
            return true;
        }
        return false;
    }

    private function handleNotFound()
    {
        if ($this->notFoundCallback) {
            $callback = $this->notFoundCallback;
            $callback();
        } else {
            http_response_code(404);
            $response = [
                "message" => "Not Found"
            ];
            echo json_encode($response);
        }
    }
}
