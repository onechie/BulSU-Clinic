<?php
require_once '../utils/Utility.php';
Utility::preventDirectAccess();

class Router extends Utility
{
    private $routes = [];
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

        if ($requireAuthentication) {
            $this->routes[$method][$url] = function () use ($callback) {
                //CHECK THE AUTH TOKEN
                if (!$this->isAccessTokenValid()) {
                    http_response_code(401);
                    echo json_encode($this->errorResponse("Unauthorized"));
                    exit();
                }
                return $callback();
            };
        } else {
            $this->routes[$method][$url] = $callback;
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
