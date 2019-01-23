<?php

namespace Theoduin\Router;

class Router
{
    /** @var array */
    private $routes = [];

    /**
     * @param string $uri
     * @param \Closure|array|string $action
     */
    public function get($uri, $action)
    {
        $this->routes[] = ['method' => 'GET', 'uri' => $uri, 'action' => $action];
    }

    /**
     * @param string $uri
     * @param \Closure|array|string $action
     */
    public function post($uri, $action)
    {
        $this->routes[] = ['method' => 'POST', 'uri' => $uri, 'action' => $action];
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    public function dispatch()
    {
        $match = $this->match();
        if ($match && !is_callable($match['action'])) {
            $explodedAction = explode('@', $match['action']);
            if (count($explodedAction) == 2) {
                $match['action'] = [
                    new $explodedAction[0],
                    $explodedAction[1]
                ];
            }
        }
        if ($match && is_callable($match['action'])) {
            echo call_user_func_array($match['action'], $match['params']);
        } else {
            // no route was matched
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        }
    }

    /**
     * @param string $requestUrl
     * @param string $requestMethod
     * @return array|bool Array with route information on success, false on failure (no match).
     */
    private function match($requestUrl = null, $requestMethod = null)
    {
        $params = [];
        $match = false;

        if ($requestUrl === null) {
            $requestUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        }
        if (($stringPosition = strpos($requestUrl, '?')) !== false) {
            $requestUrl = substr($requestUrl, 0, $stringPosition);
        }

        if ($requestMethod === null) {
            $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        }

        foreach ($this->routes as $route) {
            $methodMatch = (stripos($route['method'], $requestMethod) !== false);
            if (!$methodMatch) {
                continue;
            }
            $regex = $this->compileRoute($route['uri']);
            $pregMatch = preg_match($regex, $requestUrl, $params) === 1;
            if ($pregMatch) {
                if ($params) {
                    foreach ($params as $key => $value) {
                        if (is_numeric($key)) {
                            unset($params[$key]);
                        }
                    }
                }
                $match = $route;
                $match['params'] = $params;
            }
        }
        return $match;
    }

    /**
     * Compile the regex for a given route (EXPENSIVE)
     * @param string $route
     * @return string
     */
    private function compileRoute($route) {
        if (preg_match_all('`(/|\.|)\{(\w+[^\?])(\?|)\}`', $route, $matches, PREG_SET_ORDER)) {
            foreach($matches as $match) {
                list($block, $pre, $param, $optional) = $match;
                $optional = $optional !== '' ? '?' : '';
                $pattern = '(?:'
                    . ($pre !== '' ? $pre : '')
                    . '('
                    . ($param !== '' ? "?P<$param>" : '')
                    . '.+)'
                    . $optional
                    . ')'
                    . $optional;
                $route = str_replace($block, $pattern, $route);
            }
        }
        return "`^$route$`u";
    }
}
