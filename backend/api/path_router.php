<?php
require_once '../utils/Utility.php';
Utility::preventDirectAccess();
class PathRouter extends Utility
{
    private $routes = [];
    private $notFoundCallback;

    public function route($url, $callback)
    {
        // Sanitize and validate the URL path (example: only allow alphanumeric characters and slashes)
        $url = preg_replace('/[^a-zA-Z0-9\/]/', '', $url);
        $this->routes[$url] = $callback;
    }

    public function set404($callback)
    {
        $this->notFoundCallback = $callback;
    }

    public function run()
    {
        $path = $_SERVER['REQUEST_URI'];

        $path = str_replace("/backend/api", "", $path);

        // Remove last '/' to prevent 'Not Found' on routes ending with '/'
        if (strlen($path) > 1) {
            $path = rtrim($path, '/');
        }

        // Remove query parameters from the path (if any)
        $path = strtok($path, '?');

        // Sanitize and validate the URL path (example: only allow alphanumeric characters and slashes)
        $path = preg_replace('/[^a-zA-Z0-9\/]/', '', $path);

        $callback = $this->routes[$path] ?? null;

        if ($callback && is_callable($callback)) {
            // Implement CSRF protection here if needed
            $callback();
        } else {
            $this->handleNotFound();
        }
    }

    private function handleNotFound()
    {
        if ($this->notFoundCallback) {
            $callback = $this->notFoundCallback;
            $callback();
        } else {
            http_response_code(404);
            $response = [
                "message" => "Route Not Found"
            ];
            echo json_encode($response);
        }
    }
    public static function requireFile($file)
    {
        $path = "routes/" . $file;
        if (file_exists($path)) {
            require $path;
        } else {
            http_response_code(404);
            $response = [
                "message" => "Route Not Found"
            ];
            echo json_encode($response);
        }
    }
}
