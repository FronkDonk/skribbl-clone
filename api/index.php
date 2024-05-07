<?php
session_start();



require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/index.php";
    });
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

$authRoutes = [
    "/auth/sign-in",
    "/auth/sign-up",
    "/auth/new-password",
];

$apiAuthPrefix = "/api/auth";

$publicRoutes = [
    "/auth/new-verification",
    "/"
];

$isApiAuthRoute = strpos($uri, $apiAuthPrefix) === 0;
$isPublicRoute = in_array($uri, $publicRoutes);
$isAuthRoute = in_array($uri, $authRoutes);
$defaultSignInRedirect = "/";
$isSignedIn = isset($_SESSION["access_token"]);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        if ($isApiAuthRoute) {
            $handler($vars);
            break;
        }


        //check if the route is public
        if (!$isPublicRoute && !$isAuthRoute) {
            if ($isSignedIn) {
                $handler($vars);
                break;
            }
            $callbackUrl = $uri;
            if (isset($_SERVER['QUERY_STRING'])) {
                $callbackUrl .= '?' . $_SERVER['QUERY_STRING'];
            }

            $encodedCallbackUrl = urlencode($callbackUrl);

            header("Location: /auth/sign-in");
            break;
        }
        //check if the route is an auth route
        if ($isAuthRoute) {
            if ($isSignedIn) {
                header("Location: /");
                break;
            }
            $handler($vars);
            break;
        }

        $handler($vars);
        break;
}
