<?php
session_start();
require "vendor/autoload.php";
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', function () {
        echo "Home page";
        echo "asjdajsdjaodj dioasjdioSOIDIASOJDIJASIODIOASJDIJAS";
    });
    $r->addRoute('GET', '/new-game/{id}', function ($id) {
        require "src/views/new-game.php";
    });
    $r->addRoute('POST', '/new-game/{id}', function ($id) {
        require "src/api/new-game.php";
    });
    $r->addRoute('POST', '/api/renderOnlineUsers', function () {
        require "src/api/renderOnlineUsers.php";
    });
    $r->addRoute('GET', '/new-game', function () {
        $uuid = \Ramsey\Uuid\Uuid::uuid4();

        header("Location: /new-game/{$uuid->toString()}");
        exit ();
    });
    $r->addRoute("GET", "/src/actions/getUserData", function () {
        require "src/js/actions/getUserData.js";
    });
    $r->addRoute('POST', '/api/new-game', function () {
        require "src/api/new-game.php";
    });
    $r->addRoute("GET", "/lobby/{id}", function ($id) {
        require "src/views/lobby.php";
    });
    $r->addRoute("GET", "/api/getCurrentUser", function () {
        require "src/api/getCurrentUser.php";
    });
    $r->addRoute("GET", "/auth/sign-in", function () {
        require "src/views/auth/sign-in.php";
    });
    $r->addRoute("POST", "/api/auth/sign-in", function () {
        require "src/api/auth/sign-in.php";
    });
    $r->addRoute("GET", "/auth/sign-up", function () {
        require "src/views/auth/sign-up.php";
    });
    $r->addRoute("POST", "/api/auth/sign-up", function () {
        require "src/api/auth/sign-up.php";
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
            if ($_SERVER['QUERY_STRING']) {
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