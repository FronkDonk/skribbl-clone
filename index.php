<?php
session_start();


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    //pages routes
    $r->addRoute('GET', '/', function () {



        require $_SERVER['DOCUMENT_ROOT'] . "/src/views/home.php";
    });
    $r->addRoute('GET', '/create-game', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/views/create-game.php";
    });
    $r->addRoute('GET', '/profile', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/views/profile.php";
    });
    $r->addRoute('GET', '/profile/games', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/views/prevGames.php";
    });
    $r->addRoute('GET', '/auth/sign-out', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/views/auth/sign-out.php";
    });
    /*    $r->addRoute('GET', '/game', function () {
           header("Location: /");
           exit ();
       });
       $r->addRoute('GET', '/new-game', function () {
           header("Location: /");
           exit ();
       }); */
    $r->addRoute('GET', '/game/{id}', function ($id) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/views/game.php";
    });
    $r->addRoute('GET', '/new-game/{id}', function ($id) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/views/new-game.php";
    });
    $r->addRoute("GET", "/lobby/{id}", function ($id) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/views/lobby.php";
    });


    //auth
    $r->addRoute("GET", "/auth/sign-up", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/views/auth/sign-up.php";
    });
    $r->addRoute("GET", "/auth/sign-in", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/views/auth/sign-in.php";
    });

    //auth api routes
    $r->addRoute("POST", "/api/auth/sign-in", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/auth/sign-in.php";
    });
    $r->addRoute("POST", "/api/deleteAccount", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/deleteAccount.php";
    });
    $r->addRoute("POST", "/api/auth/sign-up", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/auth/sign-up.php";
    });
    //api routes
    $r->addRoute('POST', '/api/create-game', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/create-game.php";
    });
    $r->addRoute('POST', '/api/updateProfile', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/updateProfile.php";
    });
    $r->addRoute('POST', '/api/join-game', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/join-game.php";
    });
    $r->addRoute('GET', '/api/getProfileData', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/getProfileData.php";
    });
    $r->addRoute('POST', '/api/new-game', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/new-game.php";
    });
    $r->addRoute('GET', '/api/getPrevGames', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/getPrevGames.php";
    });
    $r->addRoute("GET", "/api/getPlayer", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/getPlayer.php";
    });
    $r->addRoute("POST", "/api/getGameData", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/getGameData.php";
    });
    $r->addRoute("POST", "/api/clearPrevDrawers", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/clearPrevDrawers.php";
    });
    $r->addRoute("GET", "/api/chooseWord", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/chooseWord.php";
    });
    $r->addRoute("POST", "/api/changePassword", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/changePassword.php";
    });
    $r->addRoute("POST", "/api/saveWord", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/saveWord.php";
    });
    $r->addRoute("POST", "/api/renderMessage", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/renderMessage.php";
    });
    $r->addRoute("POST", "/api/renderChatMessages", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/renderChatMessages.php";
    });
    $r->addRoute("POST", "/api/guessIsCorrect", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/guessIsCorrect.php";
    });
    $r->addRoute("POST", "/api/saveChatMessage", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/saveChatMessage.php";
    });
    $r->addRoute("POST", "/api/addPlayerToGame", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/addPlayerToGame.php";
    });
    $r->addRoute("POST", "/api/addPrevDrawers", function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/addPrevDrawers.php";
    });

    $r->addRoute('POST', '/api/renderOnlineUsers', function () {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/api/renderOnlineUsers.php";
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

$isApiPrefix = "/api";

$publicRoutes = [
    "/auth/new-verification",
    "/",
    "/new-game/",
    "/game/",
];

$isApiRoute = strpos($uri, $isApiPrefix) === 0;
$isPublicRoute = in_array($uri, $publicRoutes) || strpos($uri, '/new-game/') === 0 || strpos($uri, '/game/') === 0;
$isAuthRoute = in_array($uri, $authRoutes);
$defaultSignInRedirect = "/";
$isSignedIn = isset($_SESSION["userId"]);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // 405 Method Not Allowed
        http_response_code(405);
        echo "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        if ($isApiRoute) {
            $handler($vars);
            break;
        }


        //check if the route is public
        // If the route is not public and not an auth route, check if the user is signed in
        if (!$isPublicRoute && !$isAuthRoute) {
            if ($isSignedIn) {
                // If the user is signed in, handle the route and break
                $handler($vars);
                break;
            }

            // If the user is not signed in, redirect them to the sign-in page with a callback URL
            $callbackUrl = $uri;
            if (isset($_SERVER['QUERY_STRING'])) {
                $callbackUrl .= '?' . $_SERVER['QUERY_STRING'];
            }

            $encodedCallbackUrl = urlencode($callbackUrl);
            header("Location: /auth/sign-in?callbackUrl=$encodedCallbackUrl");
            exit;
        }

        //check if the route is an auth route
        /*    if ($isAuthRoute) {
               if ($isSignedIn) {
                   header("Location: /");
                   break;
               }
               $handler($vars);
               break;
           } */

        $handler($vars);
        break;
}
