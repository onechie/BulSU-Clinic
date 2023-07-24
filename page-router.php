<?php
class PageRouter
{
    private $routes = [];
    private $notFoundCallback;

    public function get($url, $callback)
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
        $method = $_SERVER['REQUEST_METHOD'];

        // Remove last '/' to prevent 'Not Found' on routes ending with '/'
        if (strlen($path) > 1) {
            $path = rtrim($path, '/');
        }
        // Remove query parameters from the path (if any)
        $path = strtok($path, '?');

        // Sanitize and validate the URL path (example: only allow alphanumeric characters and slashes)
        $path = preg_replace('/[^a-zA-Z0-9\/]/', '', $path);

        $callback = $this->routes[$path] ?? null;

        if ($callback && $method === 'GET') {
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
    public static function displayPage($file)
    {
        $path = 'pages/' . $file;
        if (file_exists($path)) {
            require_once $path;
        } else {
            http_response_code(404);
            $response = [
                "message" => "Route Not Found"
            ];
            echo json_encode($response);
        }
    }
}
