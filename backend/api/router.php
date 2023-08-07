<?php
class Router
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
                $access_token = $_COOKIE['a_jwt'] ?? '';
                if (!$access_token) {
                    echo json_encode(Response::errorResponse("Unauthorized", 401));
                    exit();
                } else {
                    if (!Auth::validateAccessJWT($access_token)) {
                        echo json_encode(Response::errorResponse("Unauthorized", 401));
                        exit();
                    }
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

        $path = str_replace("/backend/api", "", $path);
        $path = strtok($path, '?');
        $path = preg_replace('/[^a-zA-Z0-9\/]/', '', $path);

        $callback = $this->routes[$method][$path] ?? null;

        if ($callback && is_callable($callback)) {
            // Implement CSRF protection here if needed
            try {
                $response = $callback();
                echo json_encode($response);
            } catch (Throwable $error) {
                echo json_encode(Response::errorResponse($error->getMessage(), 500));
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
            echo json_encode(Response::errorResponse("Endpoint Not Found", 404));
        }
    }
}
