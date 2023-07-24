<?php
require_once '../utils/Utility.php';
Utility::preventDirectAccess();

class ApiRouter extends Utility
{
    private $routes = [];
    private $notFoundCallback;
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function get($route, $callback)
    {
        $this->routes['GET'][$route] = $callback;
    }

    public function post($route, $callback)
    {
        $this->routes['POST'][$route] = $callback;
    }

    public function set404($callback)
    {
        $this->notFoundCallback = $callback;
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $route = isset($_REQUEST['route']) ? $_REQUEST['route'] : '';

        if (!in_array($method, ['GET', 'POST'])) {
            $this->handleNotFound();
            return;
        }

        $route = preg_replace('/[^a-zA-Z0-9\/]/', '', $route);

        $callback = $this->routes[$method][$route] ?? null;

        if ($callback && is_callable($callback)) {
            $response = $callback($this->controller); // Pass the controller instance to the callback
            echo json_encode($response);
            exit();
        } else {
            $this->handleNotFound();
        }
    }

    private function handleNotFound()
    {
        if ($this->notFoundCallback && is_callable($this->notFoundCallback)) {
            $callback = $this->notFoundCallback;
            $callback();
        } else {
            http_response_code(404);
            echo json_encode($this->errorResponse('Route not found.'));
        }
    }
}
